<?php

namespace Modules\MarketSession\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use Modules\MarketSession\Models\MarketSession;
use Modules\MarketSession\Models\MarketSessionJoiner;
use Modules\MarketSession\Models\MarketSessionDetail;
use Artisan;
use Auth;
use CoreComponentRepository;

class MarketSessionController extends Controller
{
    protected $zoomEndpoint = 'https://api.zoom.us/v2/';
    
    public function __construct(){
    }

    public function index(Request $request){
        $type = null;
        $sort_search = null;

        $marketSession = new MarketSession();

        if($request->search){
            $marketSession = $marketSession->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        if($request->type){
            $marketSession = $marketSession->where('type', $request->type);
            $type = $request->type;
        }

        $marketSessions = $marketSession->paginate(15);
        
        return view('MarketSession::index', compact('marketSessions', 'type', 'sort_search'));
    }

    public function bulk_product_delete(Request $request){
        if($request->id) {
            foreach ($request->id as $product_id) {
                $this->destroy($product_id);
            }
        }

        return 1;
    }

    public function destroy($id) {
        $market = MarketSession::find($id);
        $res = $this->executeRequest('meetings/'.$market->zoom_id, 'DELETE');

        if(MarketSession::destroy($id)){

            flash('Đã xóa thành công')->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return back();
        }
        else{
            flash('Đã có lỗi xảy ra')->error();
            return back();
        }
    }

    public function create(Request $request){
        $lang = $request->lang;
        return view('MarketSession::create', compact('lang'));
    }

    public function store(Request $request){        
        $startTime = null;
        if($request->type == 'single'){
            $startTime = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $request->period)));
        }
        else{
            $startTime = date("Y-m-d H:i:s", strtotime($request->period_time));
        }
        
        $postData = [
            'agenda' => $request->name,
            'duration' => 1440,
            'recurrence' => [
                'end_times' => 1,
                "repeat_interval" => 1,
                "type" => 3
            ],
            'start_time' => $startTime,
            "timezone" => "Asia/Saigon",
            "topic" => $request->name,
            "type" => 8
        ];
        
        if($request->type == 'monthly'){
            $postData['recurrence']['monthly_day'] = intval(implode(',', $request->period));
        }
        else if($request->type == 'weekly'){
            $postData['recurrence']['weekly_days'] = implode(',', $request->period);
        }

        $res = $this->executeRequest('users/me/meetings', 'POST', $postData);

        if($res->getStatusCode() == 201){
            $responseBody = json_decode((string)$res->getBody());

            $market = new MarketSession();
            $market->zoom_id = $responseBody->id;
            $market->name = $request->name;
            $market->type = $request->type;
            $market->status = $request->status;
            $market->user_id = Auth::user()->id;
            $market->start_date = $startTime;
            $market->image = $request->thumbnail_img;
            $market->date_interval = $request->type!='single'?implode(',', $request->period):'';
            $market->join_link = $responseBody->join_url;
            
            if($market->save())
            {
                flash('Thêm mới thành công')->success();

                Artisan::call('view:clear');
                Artisan::call('cache:clear');

                return back();
            }
        }
        flash('Đã có lỗi xảy ra')->error();
        return back();
    }

    public function edit(Request $request){
        $session = MarketSession::find($request->id);
        $lang = $request->lang;
        $marketSessionLists = MarketSessionDetail::where('market_id', $request->id)->get();

        $sellers = collect(new MarketSessionJoiner);

        $sessionId = null;
  
        if($request->session_id){
            $sessionId = $request->session_id;
            $sellers = MarketSessionJoiner::where('market_id', $request->session_id)->paginate(15);
        }

        return view('MarketSession::edit', compact('session', 'lang', 'marketSessionLists', 'sellers', 'sessionId'));
    }

    public function update(Request $request){
        $startTime = null;
        if($request->type == 'single'){
            $startTime = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $request->period)));
        }
        else{
            $startTime = date("Y-m-d H:i:s", strtotime($request->period_time));
        }
        
        $postData = [
            'agenda' => $request->name,
            'duration' => 1440,
            'recurrence' => [
                'end_times' => 1,
                "repeat_interval" => 1,
                "type" => 3
            ],
            'start_time' => $startTime,
            "timezone" => "Asia/Saigon",
            "topic" => $request->name,
            "type" => 8
        ];
        
        if($request->type == 'monthly'){
            $postData['recurrence']['monthly_day'] = intval(implode(',', $request->period));
        }
        else if($request->type == 'weekly'){
            $postData['recurrence']['weekly_days'] = implode(',', $request->period);
        }

        $market = MarketSession::find($request->id);

        $res = $this->executeRequest('meetings/'.$market->zoom_id, 'PATCH', $postData);

        if($res->getStatusCode() == 204){
            $market->name = $request->name;
            $market->type = $request->type;
            $market->status = $request->status;
            $market->user_id = Auth::user()->id;
            $market->start_date = $startTime;
            $market->image = $request->thumbnail_img;
            $market->date_interval = $request->type!='single'?implode(',', $request->period):'';
            
            if($market->save()){
                flash('Thêm mới thành công')->success();

                Artisan::call('view:clear');
                Artisan::call('cache:clear');

                return back();
            }
        }
        flash('Đã có lỗi xảy ra')->error();
        return back();
    }

    public function getSettingZoomApi(Request $request){
        CoreComponentRepository::initializeCache();
        return view('MarketSession::ConfigZoom.index');
    }

    public function generateJWTAuth(){
        $zoomApiKey = get_setting('zoom_api_key');
        $zoomApiSecret = get_setting('zoom_api_secret');

        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode(['iss' => $zoomApiKey, 'exp' => strtotime(date('Y-m-d H:i:s', strtotime('+1 hours')))]);

        $headerBase64 = $this->base64UrlEncode($header);
        $payloadBase64 = $this->base64UrlEncode($payload); 

        $sig = hash_hmac('sha256', $headerBase64.'.'.$payloadBase64, $zoomApiSecret, true);
        
        $key = $headerBase64.'.'.$payloadBase64.'.'.$this->base64UrlEncode($sig);
        return $key;
    }

    protected function base64UrlEncode($data){
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    protected function executeRequest($uri, $method, $data = []){
        $jwtKey = $this->generateJWTAuth();
        $client = new GuzzleHttp\Client();

        if($method != 'DELETE'){
            $res = $client->request(
                $method, 
                $this->zoomEndpoint.$uri, 
                [
                    'headers' => [
                        'Authorization' => 'Bearer '.$jwtKey,
                        'Content-Type' => 'application/json'
                    ],
                    'http_errors' => false,
                    'body' => json_encode($data)
                ]
            );
        }
        else{
            $res = $client->request(
                $method, 
                $this->zoomEndpoint.$uri, 
                [
                    'headers' => [
                        'Authorization' => 'Bearer '.$jwtKey,
                        'Content-Type' => 'application/json'
                    ],
                    'http_errors' => false,
                ]
            );
        }
        return $res;
    }

    function updateVideo(Request $request){
        $seller = MarketSessionJoiner::find($request->id);
        if(!$seller){
            return 0;
        }
        $seller->open_video = $request->open_video;
        $seller->slider_video = $request->slider_video;

        if($seller->save()){
            return 1;
        }
        return 0;
    }    

    public function marketGift(Request $request)
    {

    }

    public function marketStatistic(Request $request)
    {

    }
}
