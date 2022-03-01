<?php

namespace Modules\MarketSession\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use Modules\MarketSession\Models\MarketSession;
use Modules\MarketSession\Models\MarketSessionJoiner;
use Modules\MarketSession\Models\MarketSessionDetail;
use Modules\MarketSession\Models\HotOrder;
use Artisan;
use Auth;
use CoreComponentRepository;
use Validator;
use DB;
use App\Models\User;
use App\Models\Address;

class MarketSessionController extends Controller
{
    public function getSeller(Request $request)
    {
        $listSellers = MarketSessionJoiner::with('joinerUser')->where('market_id', $request->market_id)
                        ->where('user_id', $request->user_id)
                        ->whereHas('joinerUser', function($query){
                            $query->where('user_type', 'seller');
                        })->get();
        return response()->json([
            'result' => true,
            'data' => $listSellers
        ], 200);
    }

    public function hotBuy(Request $request)
    {
        /**Method: post
         * Request body
         * market_id: int
         * seller_id: int
         * user_id: int
         * product_name: string
         * address_id: int
         */

        $rules = [
            'seller_id' => 'required',
            'product_name' => 'required',
            'address_id' => 'required'
        ];

        $message = [
            'seller_id.required' => 'Vui lòng chọn quầy hàng',
            'product_name.required' => 'Vui lòng nhập tên sản phẩm',
            'address_id.required' => 'Vui lòng chọn địa chỉ'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->passes())
        {
            $hotOrder = new HotOrder();
            $hotOrder->market_id = $request->market_id;
            $hotOrder->seller_id = $request->seller_id;
            $hotOrder->user_id = $request->user_id;
            $hotOrder->product_name = $request->product_name;
            $hotOrder->payment_status = 'unpaid';
            $hotOrder->delivery_status = 'pending';
            $hotOrder->order_at = date('Y-m-d H:i:s');
            $hotOrder->order_code = date('Ymd') . '-' . $request->market_id . $request->seller_id . $request->user_id . date('His');
            
            $address = Address::where('id', $request->address_id)->first();
            $userInfo = User::where('id', $request->user_id)->first();

            $shippingAddress = [];
            if ($address != null) {
                $shippingAddress['name']        = $userInfo->name;
                $shippingAddress['email']       = $userInfo->email;
                $shippingAddress['address']     = $address->address;
                $shippingAddress['country']     = $address->country->name;
                $shippingAddress['state']       = $address->state->name;
                $shippingAddress['city']        = $address->city->name;
                $shippingAddress['postal_code'] = $address->postal_code;
                $shippingAddress['phone']       = $address->phone;
                if ($address->latitude || $address->longitude) {
                    $shippingAddress['lat_lang'] = $address->latitude . ',' . $address->longitude;
                }
            }

            $hotOrder->shipping_address = json_encode($shippingAddress);

            if($hotOrder->save())
            {
                $userJoin = MarketSessionJoiner::where('market_id', $request->market_id)
                        ->where('user_id', $request->user_id)->increment('wheel_turn', 1);  
                        
                return response()->json([
                    'result' => true,
                    'message' => 'Đơn hàng đã được tạo thành công'
                ], 200);
            }
            return response()->json([
                'result' => false,
                'message' => 'Có lỗi xảy ra trong quá trình lên đơn hàng'
            ], 200);
        }
        return response()->json([
            'result' => false,
            'message' => $validator->errors()
        ], 200);
    }

    public function getLuckyWheelTurn(Request $request)
    {
        /**Method: post
         * Request body
         * market_id: int
         * user_id: int
         */
        $marketSession = MarketSessionJoiner::where('market_id', $request->market_id)
                        ->where('user_id', $request->user_id)->select('wheel_turn')->first();
        if(!$marketSession)
        {
            return response()->json([
                'result' => true,
                'message' => translate('User not joined')
            ], 200);
        }

        return response()->json([
            'result' => true,
            'data' => $marketSession
        ], 200);
    }

    public function luckyWheel(Request $request)
    {

    }

    public function attendance(Request $request)
    {
        /**Method: post
         * Request body
         * market_id: int
         * user_id: int
         */
        $marketSession = MarketSessionJoiner::where('market_id', $request->market_id)
                        ->where('user_id', $request->user_id)->first();
        if($marketSession)
        {
            return response()->json([
                'result' => true,
                'message' => translate('User already joined')
            ], 200);
        }

        $marketSession = new MarketSessionJoiner();
        $marketSession->market_id = $request->market_id;
        $marketSession->user_id = $request->user_id;
        $marketSession->wheel_turn = 0;
        $marketSession->join_time = date('Y-m-d H:i:s');

        if($marketSession->save())
        {
            return response()->json([
                'result' => true,
                'message' => translate('Join success')
            ], 200);
        }

        return response()->json([
            'result' => true,
            'message' => translate('Join failed')
        ], 200);
    }

    public function countdown(Request $request)
    {
        $marketSession = MarketSessionDetail::with('marketSession')->where('start_time', '>=', date('Y-m-d 00:00:00'))
                        ->where('start_time', '<=', date('Y-m-d 23:59:59'))->whereHas('marketSession', function($query){
                            $query->where('status', 1);
                        })->select(DB::RAW('id as market_id'), 'start_time', 'wheel_slot')->get();

        return response()->json([
            'result' => true,
            'data' => $marketSession
        ], 200);
    }
}
