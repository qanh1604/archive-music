<?php

namespace Modules\MarketSession\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use Modules\MarketSession\Models\MarketSession;
use Modules\MarketSession\Models\MarketSessionJoiner;
use Modules\MarketSession\Models\MarketSessionDetail;
use Modules\MarketSession\Models\HotOrderGift;
use App\Models\Upload;
use Artisan;
use Auth;
use CoreComponentRepository;
use DateTime;
use DateInterval;
use DatePeriod;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

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
        if($market && $market->zoom_id){
            $res = $this->executeRequest('meetings/'.$market->zoom_id, 'DELETE');
        }        

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

        $endSessionTime = date("Y-m-d", strtotime(str_replace("/", "-", $request->end_session_date)));

        $postData = [
            'agenda' => $request->name,
            'duration' => $request->duration,
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
            $market->duration = $request->duration;
            $market->end_date = date("Y-m-d H:i:s", strtotime('+'.$request->duration.' minutes', strtotime($startTime)));
            $market->end_session_date = $endSessionTime;

            if($market->save())
            {
                if($market->type == 'single')
                {   
                    $marketSessionDetail = new MarketSessionDetail();
                    $marketSessionDetail->market_id = $market->id;
                    $marketSessionDetail->start_time = $market->start_date;
                    $marketSessionDetail->end_time = $market->end_date;
                    $marketSessionDetail->wheel_slot = 0;
                    $marketSessionDetail->save();
                }
                else if($market->type == 'weekly')
                {
                    $marketSessionDetail = [];
                    $dateInterval = $request->period;
                    for($i = 0; $i < count($dateInterval); $i++){
                        $start    = new DateTime($startTime);
                        $end      = new DateTime($endSessionTime);
                        $interval = DateInterval::createFromDateString('1 day');
                        $period   = new DatePeriod($start, $interval, $end);

                        foreach ($period as $dt) {
                            if ($dt->format("N") == $dateInterval[$i]) {
                                $time = $dt->format("Y-m-d").' '.date('H:i:s', strtotime($startTime));
                                $marketSessionDetail[] = [
                                    'market_id' => $market->id,
                                    'start_time' => $time,
                                    'end_time' => date("Y-m-d H:i:s", strtotime('+'.$request->duration.' minutes', strtotime($time))),
                                    'wheel_slot' => 0,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                            }
                        }
                    }
                    MarketSessionDetail::insert($marketSessionDetail);
                }
                else if($market->type == 'monthly')
                {
                    $marketSessionDetail = [];
                    for($i = 0; $i <= $this->diffMonth($startTime, $endSessionTime); $i++){
                        $time = new DateTime( $startTime );
                        $time = $time->modify( '+'.($i).' month' );
                        $time = $time->format('Y-m-d H:i:s');
                        $marketSessionDetail[] = [
                            'market_id' => $market->id,
                            'start_time' => $time,
                            'end_time' => date("Y-m-d H:i:s", strtotime('+'.$request->duration.' minutes', strtotime($time))),
                            'wheel_slot' => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                    MarketSessionDetail::insert($marketSessionDetail);
                }

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
            $sellers = MarketSessionJoiner::where('market_detail_id', $request->session_id)->paginate(15);
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
        $endSessionTime = date("Y-m-d", strtotime(str_replace("/", "-", $request->end_session_date)));
        
        $postData = [
            'agenda' => $request->name,
            'duration' => $request->duration,
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
            $market->duration = $request->duration;
            $market->end_date = date("Y-m-d H:i:s", strtotime('+'.$request->duration.' minutes', strtotime($startTime)));
            $market->end_session_date = $endSessionTime;

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

    private function diffMonth($date1, $date2)
    {
        $begin = new DateTime( $date1 );
        $end = new DateTime( $date2 );
        $end = $end->modify( '+1 day' );

        $interval = DateInterval::createFromDateString('1 month');

        $period = new DatePeriod($begin, $interval, $end);
        $counter = iterator_count($period);
        return $counter;
    }

    private function diffWeek($date1, $date2)
    {
        $begin = new DateTime( $date1 );
        $end = new DateTime( $date2 );
        $end = $end->modify( '+1 day' );

        $interval = DateInterval::createFromDateString('1 week');

        $period = new DatePeriod($begin, $interval, $end);
        $counter = iterator_count($period);
        return $counter;
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

        $open_vieo = Upload::where('id', $request->open_video)->first();
        $slider_video = Upload::where('id', $request->slider_video)->first();

        $seller->open_video = $open_vieo->file_name;
        $seller->slider_video = $slider_video->file_name;

        if($seller->save()){
            return 1;
        }
        return 0;
    }   
    
    public function gift(Request $request)
    {
        $searchDate = null;
        $lang = $request->lang;
        $marketSessions = MarketSessionDetail::where('market_id', $request->id);

        if($request->start_date){
            $marketSessions = $marketSessions->whereRaw('DATE(start_date) = '.$request->start_date);
        }

        $marketSessions = $marketSessions->paginate(15);
        return view('MarketSession::GiftConfig.index', compact('marketSessions', 'searchDate', 'lang'));
    }

    public function getConfigGift(Request $request)
    {
        $lang = $request->lang;
        $marketDetail = MarketSessionDetail::find($request->id);
        return view('MarketSession::GiftConfig.add_gift', compact('marketDetail', 'lang'));
    }

    public function postConfigGift(Request $request)
    {
        $dataGift = [];
        $totalGift = 0;
        for($i = 0; $i < count($request->gift_names); $i++){
            $dataGift[] = [
                'image' => $request->gift_images[$i],
                'name' => $request->gift_names[$i],
                'amount' => $request->gift_amounts[$i],
            ];
            $totalGift += $request->gift_amounts[$i]?$request->gift_amounts[$i]:0;
        }
        $marketDetail = MarketSessionDetail::find($request->id);
        $marketDetail->gift = json_encode($dataGift);
        $marketDetail->total_gift = $totalGift;
        if($marketDetail->save())
        {
            flash('Cập nhật thành công')->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            $searchDate = null;
            $lang = $request->lang;
            $marketSessions = MarketSessionDetail::where('market_id', $request->id);

            if($request->start_date){
                $marketSessions = $marketSessions->whereRaw('DATE(start_date) = '.$request->start_date);
            }

            $marketSessions = $marketSessions->paginate(15);
            return redirect()->route('market-session');
        }
        flash('Đã có lỗi xảy ra')->error();
        return back();
    }

    public function getWinningPrize(Request $request, $id){
        $hotOrderGift = HotOrderGift::where('market_id', $id)->first();
        $gifts = [];
        if($hotOrderGift){
            if($hotOrderGift->wheel){
                $gifts = json_decode($hotOrderGift->wheel, true);
            }
        }
        $total = count($gifts);
        $perPage = 15;
        $gifts = array_chunk($gifts, $perPage);

        $giftData = collect([]);
        if(!empty($gifts)){
            if(!$request->page){
                $giftData = collect($gifts[0]);
            }
            else{
                if(isset($gifts[$request->page - 1])){
                    $giftData = collect($gifts[$request->page - 1]);
                }
                elseif(isset($gifts[0])){
                    $giftData = collect($gifts[0]);
                }
                else{
                    $giftData = collect([]);
                }
            }
        }

        $links = $this->makeLengthAware($giftData, $total, $perPage);
        return view('MarketSession::GiftConfig.gift_send', compact('giftData', 'links', 'total', 'perPage'));
    }

    public function makeLengthAware($collection, $total, $perPage, $appends = null)
    {
        $paginator = new LengthAwarePaginator(
            $collection, 
            $total, 
            $perPage, 
            Paginator::resolveCurrentPage(), 
            ['path' => Paginator::resolveCurrentPath()]
        );

        if($appends) $paginator->appends($appends);

        return $paginator->render();
    }

    public function marketStatistic(Request $request)
    {

    }
}
