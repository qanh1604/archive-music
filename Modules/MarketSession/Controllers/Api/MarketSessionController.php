<?php

namespace Modules\MarketSession\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use Modules\MarketSession\Models\MarketSession;
use Modules\MarketSession\Models\MarketSessionJoiner;
use Modules\MarketSession\Models\MarketSessionDetail;
use Modules\MarketSession\Models\HotOrder;
use Modules\MarketSession\Models\HotOrderGift;
use Artisan;
use Auth;
use CoreComponentRepository;
use Validator;
use DB;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Support\Str;

class MarketSessionController extends Controller
{
    public function getSeller(Request $request)
    {
        /**Method: get
         * Request params
         * id: int //market_id
         */
        $listSellers = MarketSessionJoiner::with([
                    'joinerUser:id,name,email,avatar', 
                    'shop:id,user_id,name,logo,sliders,phone,address,meta_title,meta_description,background_img,virtual_assistant'
                ])->where('market_detail_id', $request->id)
                        ->whereHas('joinerUser', function($query){
                            $query->where('user_type', 'seller');
                        })->paginate(15);
        return response()->json($listSellers, 200);
    }

    public function getCustomer(Request $request)
    {
        /**Method: get
         * Request params
         * id: int //market_id
         */
        $listSellers = MarketSessionJoiner::with(['joinerUser:id,name,email,avatar'])->where('market_detail_id', $request->id)
                        ->whereHas('joinerUser', function($query){
                            $query->where('user_type', 'customer');
                        })->paginate(15);
        return response()->json($listSellers, 200);
    }

    public function getSellerProducts(Request $request){
        /**Method: get
         * Request params
         * id: int //seller_id
         */
        $sellerProducts = Product::where('user_id', $request->id)->where('auction_product', 0)->where('approved', 1)->paginate(15);
        
        return response()->json($sellerProducts, 200);
    }

    public function getMarketList(Request $request)
    {   
        /**Method: post
         * Request body
         * type: ['previous', 'current', 'next']
         */
        $type = $request->type;
        $marketLists = MarketSessionDetail::with([
            'marketSession:id,name,zoom_id,duration,join_link,image,type',
            'attended:market_detail_id,user_id,open_video,slider_video',
            'attended.joinerUser:id,name,email,avatar', 
            'attended.shop:id,user_id,name,logo,sliders,phone,address,meta_title,meta_description,background_img,virtual_assistant'
        ]);

        if($type == 'previous')
        {
            $marketLists = $marketLists->whereRaw('DATE(start_time) < CURDATE()');
        }
        else if($type == 'next')
        {
            $marketLists = $marketLists->whereRaw('DATE(start_time) > CURDATE()');
        }
        else
        {
            $marketLists = $marketLists->whereRaw('DATE(start_time) = CURDATE()');
        }

        $marketLists = $marketLists->orderBy('start_time')->paginate(15);
        return response()->json($marketLists, 200);
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
                $userJoin = MarketSessionJoiner::where('market_detail_id', $request->market_id)
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
        $marketSession = MarketSessionJoiner::where('market_detail_id', $request->market_id)
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
        /**Method: post
         * Request body
         * market_id: int
         */

        $hotOrderGift = HotOrderGift::where('market_id', $request->id)->first();
        if(!$hotOrderGift)
        {
            $attendances = HotOrder::with('user')->where('market_id', $request->id)->get();
            $giftData = MarketSessionDetail::find($request->id);
            
            $colors = ['#ee1c24', '#3cb878', '#f6989d', '#00aef0', '#f26522', '#000000', '#e70697', '#fff200'];
    
            $userInWheel = [];
            $giftWheel = [];
    
            if($giftData && $giftData->gift)
            {
                $gifts = json_decode($giftData->gift);
                foreach($gifts as $gift){
                    for($i = 0; $i < $gift->amount; $i++){
                        $giftWheel[] = [
                            'image' => $gift->image,
                            'name' => $gift->name,
                            'uuid' => str_replace('-', '_', (string) Str::uuid())
                        ];
                    }
                }
            }
            shuffle($giftWheel);
            
            $colorKey = 0;
            foreach($attendances as $value){
                $userInWheel[] = [
                    'fillStyle' => $colors[$colorKey],
                    'text' => $value->user->name,
                    'textFontSize' => 16,
                    'data-id' => $value->user->id,
                    'textFillStyle' => '#ffffff'
                ];
                $colorKey++;
                if($colorKey > count($colors)-1){
                    $colorKey = 0;
                }
            }
    
            shuffle($userInWheel);
    
            $numberOfPin = count($userInWheel);

            $wheelResult = [];

            $arrayOfWheelSet = [];

            for($i = 0; $i < count($giftWheel); $i++){
                if(empty($userInWheel)){
                    break;
                }
                $rand = rand(0, count($userInWheel)-1);
                
                while(true){
                    if(in_array($rand, $arrayOfWheelSet)){
                        $rand = rand(0, count($userInWheel)-1);
                    }
                    else{
                        $arrayOfWheelSet[] = $rand;
                        $wheelResult[] = [
                            'image' => $giftWheel[$i]['image'],
                            'name' => $giftWheel[$i]['name'],
                            'uuid' => $giftWheel[$i]['uuid'],
                            'user' => [
                                'name' => $userInWheel[$rand]['text'],
                                'id' => $userInWheel[$rand]['data-id']
                            ],
                            'position' => $rand
                        ];
                        break;
                    }
                }
            }

            $userInWheel = json_encode($userInWheel);

            $current_turn = 0;
            $max_turn = count($giftWheel);

            $giftWheel = json_encode($giftWheel);

            $hotOrderGift = new HotOrderGift();
            $hotOrderGift->market_id = $request->id;
            $hotOrderGift->gift = $giftWheel;
            $hotOrderGift->user = $userInWheel;
            $hotOrderGift->wheel = json_encode($wheelResult);
            $hotOrderGift->current_turn = $current_turn;
            $hotOrderGift->max_turn = $max_turn;
            $hotOrderGift->save();
        }
        else{
            $userInWheel = $hotOrderGift->user;
            $wheelResult = $hotOrderGift->wheel;
            $current_turn = $hotOrderGift->current_turn;
            $max_turn = $hotOrderGift->max_turn;
            $giftWheel = $hotOrderGift->gift;
            $numberOfPin = count(json_decode($userInWheel));
        }   

        $marketId = $request->id;

        return view('MarketSession::wheel', compact(
            'marketId',
            'numberOfPin', 
            'userInWheel', 
            'wheelResult', 
            'current_turn', 
            'max_turn', 
            'giftWheel'
        ));
    }

    public function syncWheelTurn(Request $request){
        $hotOrderGift = HotOrderGift::where('market_id', $request->market_id)->first();
        if($hotOrderGift){
            if($request->currentTurn > $hotOrderGift->current_turn && $request->currentTurn < $hotOrderGift->max_turn){
                $hotOrderGift->current_turn = $request->currentTurn;
                $hotOrderGift->save();
            }
        }
        return 1;
    }

    public function attendance(Request $request)
    {
        /**Method: post
         * Request body
         * market_id: int
         * user_id: int
         */
        $marketSession = MarketSessionJoiner::where('market_detail_id', $request->market_id)
                        ->where('user_id', $request->user_id)->first();
        if($marketSession)
        {
            return response()->json([
                'result' => true,
                'isAttended' => true,
                'alreadyAttended' => true,
            ], 200);
        }

        $marketSession = new MarketSessionJoiner();
        $marketSession->market_detail_id = $request->market_id;
        $marketSession->user_id = $request->user_id;
        $marketSession->wheel_turn = 0;
        $marketSession->join_time = date('Y-m-d H:i:s');

        if($marketSession->save())
        {
            return response()->json([
                'result' => true,
                'isAttended' => true,
                'alreadyAttended' => false
            ], 200);
        }

        return response()->json([
            'result' => true,
            'isAttended' => false
        ], 200);
    }

    public function countdown(Request $request)
    {
        $marketSession = MarketSessionDetail::with('marketSession')->where('start_time', '>=', date('Y-m-d 00:00:00'))
                        ->where('start_time', '<=', date('Y-m-d 23:59:59'))->whereHas('marketSession', function($query){
                            $query->where('status', 1);
                        })->paginate(15);

        return response()->json($marketSession, 200);
    }
}
