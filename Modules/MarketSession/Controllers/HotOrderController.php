<?php

namespace Modules\MarketSession\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use Modules\MarketSession\Models\MarketSession;
use Modules\MarketSession\Models\MarketSessionJoiner;
use Modules\MarketSession\Models\MarketSessionDetail;
use Modules\MarketSession\Models\HotOrder;
use Modules\MarketSession\Models\HotOrderDetail;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Attribute;
use App\Models\Color;
use App\Models\User;
use App\Models\SmsTemplate;
use App\Utility\SmsUtility;
use App\Utility\NotificationUtility;
use Auth;

class HotOrderController extends Controller
{
    public function index(Request $request)
    {
        $date = null;
        $sort_search = null;
        $delivery_status = null;
        $orders = HotOrder::with('orderDetails')->orderBy('order_at')->paginate(15);

        return view('MarketSession::HotOrders.index', compact('orders', 'date', 'sort_search', 'delivery_status'));
    }

    public function edit(Request $request)
    {
        $id = decrypt($request->id);
        $order = HotOrder::with('orderDetails')->where('id', $id)->first();
        $sellerProducts = Product::where('user_id', $order->seller_id)->where('auction_product', 0)->where('approved', 1)->get();

        return view('MarketSession::HotOrders.edit', compact('order', 'sellerProducts'));
    }

    public function getProductVariant($id)
    {
        $product = Product::findOrFail($id);
        $attributesData = [];
        if($product->attributes)
        {
            $attributes = json_decode($product->choice_options);
            foreach($attributes as $attr)
            {
                $attribute = Attribute::findOrFail($attr->attribute_id);
                $attributesData[$attribute->name]['value'] = $attr->values;
                $attributesData[$attribute->name]['attribute_id'] = $attr->attribute_id;
                $attributesData[$attribute->name]['translate'] = $attribute->getTranslation('name');
            }
        }
        if($product->colors)
        {
            $colors = json_decode($product->colors);
            if($colors)
            {
                foreach($colors as $color)
                {
                    $colorData = Color::where('code', $color)->select('name','code')->first();
                    if($colorData)
                    {
                        $attributesData['colors']['value'][] = $colorData;
                    }
                }

                $attributesData['colors']['translate'] = translate('Colors');
            }
        }
        return response()->json(['data' => $attributesData]);
    }

    public function addProduct(Request $request){
        $id = $request->order_id;
        $order = HotOrder::with('orderDetails')->where('id', $id)->first();

        $product = Product::find($request->product);

        $variants = $request->variants;

        $product_variation = '';
        if(isset($variants['color'])){
            $product_variation .= $variants['color'] . '-';
            unset($variants['color']);
        }
        if(!empty($variants)){
            $product_variation .= implode('-', $variants);
        }

        $product_stock = $product->stocks->where('variant', $product_variation)->first();
        if ($product->digital != 1 && $request->quantity > $product_stock->qty) {
            return response()->json(['error' => translate('The requested quantity is not available for ') . $product->getTranslation('name')]);
        } elseif ($product->digital != 1) {
            $product_stock->qty -= $request->quantity;
            $product_stock->save();
        }

        $productPrice = $product_stock->price;
        if($product->discount_start_date <= strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) <= $product->discount_end_date)
        {
            if($product->discount_type == 'percent'){
                $productPrice = $productPrice - ($productPrice*($product->discount/100));
            }
            else{
                $productPrice = $productPrice - $product->discount;
            }
        }

        $order_detail = new HotOrderDetail;
        $order_detail->order_id = $order->id;
        $order_detail->product_id = $product->id;
        $order_detail->variation = $product_variation;
        $order_detail->price = $productPrice * $request->quantity;

        //End of storing shipping cost

        $order_detail->quantity = $request->quantity;
        $order_detail->save();

        $product->num_of_sale += $request->quantity;
        $product->save();

        if ($product->added_by == 'seller' && $product->user->seller != null){
            $seller = $product->user->seller;
            $seller->num_of_sale += $request->quantity;
            $seller->save();
        }

        $order->grand_total = $order->grand_total + $productPrice * $request->quantity;
        $order->save();

        $order = HotOrder::with('orderDetails')->where('id', $id)->first();
        return view('MarketSession::HotOrders.inc.product_detail', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $order = HotOrder::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        if($request->status == 'confirmed' && $order->delivery_status != 'confirmed') {
            $order->confirm_at = date('Y-m-d H:i:s');
        }
        $order->delivery_status = $request->status;
        $order->save();

        if ($request->status == 'cancelled' && $order->payment_type == 'wallet') {
            $user = User::where('id', $order->user_id)->first();
            $user->balance += $order->grand_total;
            $user->save();
        }

        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'delivery_status_change')->first()->status == 1) {
            try {
                SmsUtility::delivery_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {

            }
        }

        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->delivery_status);
            $request->text = " Your order {$order->code} has been {$status}";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;

            NotificationUtility::sendFirebaseNotification($request);
        }


        if (addon_is_activated('delivery_boy')) {
            if (Auth::user()->user_type == 'delivery_boy') {
                $deliveryBoyController = new DeliveryBoyController;
                $deliveryBoyController->store_delivery_history($order);
            }
        }

        return 1;
    }

   public function update_tracking_code(Request $request) {
        $order = HotOrder::findOrFail($request->order_id);
        $order->tracking_code = $request->tracking_code;
        $order->save();

        return 1;
   }

    public function update_payment_status(Request $request)
    {
        $order = HotOrder::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->payment_status = $request->status;
        $order->save();

        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->payment_status);
            $request->text = " Your order {$order->code} has been {$status}";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;
            NotificationUtility::sendFirebaseNotification($request);
        }


        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'payment_status_change')->first()->status == 1) {
            try {
                SmsUtility::payment_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {

            }
        }
        return 1;
    }

    public function destroy($id)
    {
        $order = HotOrder::findOrFail($id);
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                try {

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variation)->first();
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }

                } catch (\Exception $e) {

                }

                $orderDetail->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function bulk_order_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $order_id) {
                $this->destroy($order_id);
            }
        }

        return 1;
    }
}