<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\PurchaseHistoryMiniCollection;
use App\Http\Resources\V2\PurchaseHistoryCollection;
use App\Http\Resources\V2\PurchaseHistoryItemsCollection;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shop;
use App\Models\Address;
use \Modules\MarketSession\Models\MarketSession;
use \Modules\MarketSession\Models\MarketSessionDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\MarketSession\Models\HotOrder;

class PurchaseHistoryController extends Controller
{
    public function index($id, Request $request)
    {
        $order_query = Order::query();
        if ($request->payment_status != "" || $request->payment_status != null) {
            $order_query->where('payment_status', $request->payment_status);
        }
        if ($request->delivery_status != "" || $request->delivery_status != null) {
            $delivery_status = $request->delivery_status;
            $order_query->whereIn("id", function ($query) use ($delivery_status) {
                $query->select('order_id')
                    ->from('order_details')
                    ->where('delivery_status', $delivery_status);
            });
        }

        $orders = DB::table('orders')
            ->select("id", "code", "user_id", "delivery_status", "payment_type", "payment_status", "grand_total", "date", DB::RAW("'order' AS type"))
            ->where("user_id", $id);

        $hot_orders = DB::table('hot_orders')
            ->select("id", DB::RAW('"NULL" AS code'), "user_id", "delivery_status", DB::RAW('"NULL" AS payment_type'), "payment_status", "grand_total", DB::RAW('"NULL" AS date'), DB::RAW("'hot_order' AS type"))
            ->where("user_id", $id)
            ->union($orders)
            ->paginate(5);

        // return new PurchaseHistoryMiniCollection($order_query->where('user_id', $id)->latest()->paginate(5));
        return response()->json($this->ordersdata($hot_orders));
    }

    public function ordersdata($data_order){

        foreach ($data_order->items() as &$data){
            $data->id = intval($data->id);
            $data->code = $data->code;
            $data->user_id = intval($data->user_id);
            $data->payment_type = ucwords(str_replace('_', ' ', $data->payment_type));
            $data->payment_status = $data->delivery_status;
            $data->payment_status_string = $data->delivery_status == 'pending'? "Order Placed" : ucwords(str_replace('_', ' ',  $data->delivery_status));
            $data->grand_total = format_price($data->grand_total);
            $data->date = Carbon::createFromTimestamp($data->date)->format('d-m-Y');
            $data->links = [
                'details' => ''
            ];

            if($data->type == 'hot_order'){
                $hot_order = HotOrder::where('id', $data->id)->first();
                $market_detail = MarketSessionDetail::where('id', $hot_order->market_id)->first();
                $market = MarketSession::where('id', $market_detail->market_id)->first();
                $shop = Shop::where('user_id', $data->user_id)->first();
                
                $address = Address::where('user_id', $data->user_id)->first();

                $data->type_details = [
                    'market_name' => $market->name,
                    'shop_name' => $shop?$shop->name:'',
                    'order_description' => $hot_order->product_name,
                    'address_id' => $address?$address->address:'',
                ];
            }
        }
        return $data_order;
    }

    public function details($id)
    {
        $order_query = Order::where('id', $id);
        return new PurchaseHistoryCollection($order_query->get());
    }

    public function items($id)
    {
        $order_query = OrderDetail::where('order_id', $id);
        return new PurchaseHistoryItemsCollection($order_query->get());
    }
}
