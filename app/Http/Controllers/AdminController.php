<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Artisan;
use Cache;
use CoreComponentRepository;
use Modules\MarketSession\Models\MarketSessionDetail;
use Modules\MarketSession\Models\HotOrder;
use App\Models\User;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Song;
use App\Models\Artist;
use App\Models\SellerPackage;
use App\Models\SellerPackagePayment;
use App\Models\Seller;
use DB;
use DatePeriod;
use DateTime;
use DateInterval;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard(Request $request)
    {   
        CoreComponentRepository::initializeCache();

        $marketSessions = MarketSessionDetail::get();
        $totalSession = count($marketSessions);

        $totalCustomer = User::whereIn('user_type', ['customer', 'artist'])->count();
        $totalProduct = Song::count();

        $revenueOrder = Order::where('payment_status', 'paid')->sum('grand_total');
        $revenueHotOrder = HotOrder::where('payment_status', 'paid')->sum('grand_total');
        $totalRevenue = $revenueOrder + $revenueHotOrder;

        $sellers = Shop::select('user_id', 'name')->get();

        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');

        $sellerPackagePayment = DB::SELECT("
            SELECT id, created_at, seller_package_id, approval
            FROM seller_package_payments
            WHERE DATE(created_at) >= '".$startDate."' AND DATE(created_at) <= '".$endDate."'
        ");
        
        $sellerPackage = SellerPackage::get()->pluck('amount', 'id')->toArray();

        $chartData = [];

        $orderPeriod = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($endDate)
        );

        foreach($orderPeriod as $period){
            $date = $period->format('Y-m-d');
            $dateFormated = $period->format('d/m/Y');
            $chartData['admin_package']['labels'][] = $dateFormated;
            $chartData['revenue']['labels'][] = $dateFormated;
            foreach($sellerPackagePayment as $order){
                $orderDate = new DateTime($order->created_at);
                $orderDateFormat = $orderDate->format('Y-m-d');

                if(!isset($chartData['admin_package']['data'][$order->approval][strtotime($date)])){
                    $chartData['admin_package']['data'][$order->approval][strtotime($date)] = 0;
                }
                if(!isset($chartData['revenue']['data'][strtotime($date)])){
                    $chartData['revenue']['data'][strtotime($date)] = 0;
                }
                
                if($orderDateFormat == $date){
                    $chartData['admin_package']['data'][$order->approval][strtotime($date)] += 1;
                    $chartData['revenue']['data'][strtotime($date)] += $sellerPackage[$order->seller_package_id];
                }
                else{
                    $chartData['admin_package']['data'][$order->approval][strtotime($date)] += 0;
                    $chartData['revenue']['data'][strtotime($date)] += 0;
                }
            }
        }

        if(!isset($chartData['admin_package']['data'][1])){
            $chartData['admin_package']['data'][1] = [];
        }
        if(!isset($chartData['admin_package']['data'][0])){
            $chartData['admin_package']['data'][0] = [];
        }
        if(!isset($chartData['revenue']['data'][0])){
            $chartData['revenue']['data'][0] = [];
        }

        $chartData = json_encode($chartData);

        $topSellPackage = DB::SELECT("
            SELECT
                COUNT(*) AS total, logo, name, file_name
            FROM
                seller_package_payments
            LEFT JOIN seller_packages ON seller_packages.id = seller_package_payments.seller_package_id
            LEFT JOIN uploads ON uploads.id = seller_packages.logo
            WHERE
                approval = 1
            GROUP BY seller_package_id
            ORDER BY total DESC
            LIMIT 6
        ");

        $topFollowArtist = Artist::orderByRaw("CAST(follower as UNSIGNED) DESC")->limit(6)->get();
        $topSongs = Song::orderBy('like', 'DESC')->limit(6)->get();

        return view('backend.dashboard', compact(
            'totalSession', 
            'totalCustomer', 
            'totalProduct',
            'totalRevenue',
            'sellers',
            'marketSessions',
            'chartData',
            'topSellPackage',
            'topFollowArtist',
            'topSongs'
        ));
    }

    public function getChart(Request $request){
        $chartData = [
            'package' => [
                'labels' => [],
                'data' => [
                    'paid' => [], 
                    'unpaid' => []
                ]
            ],
            'revenue' => [
                'labels' => [],
                'data' => []
            ]
        ];

        $packageDate = explode(' - ',$request->date_package);
        $startPackageDate = date("Y-m-d", strtotime(str_replace("/", "-", $packageDate[0])));
        $endPackageDate = date("Y-m-d", strtotime(str_replace("/", "-", $packageDate[1])));

        $revenueDate = explode(' - ',$request->date_revenue);
        $startRevenueDate = date("Y-m-d", strtotime(str_replace("/", "-", $revenueDate[0])));
        $endRevenueDate = date("Y-m-d", strtotime(str_replace("/", "-", $revenueDate[1])));

        $query = '';
        if($request->group == 'seller'){
            $query = "AND seller_id = ".$request->select_value."";

            $numOfSale = Product::with(['category', 'thumbnailImage'])->where('user_id', $request->select_value)
                        ->where('auction_product', 0)->where('approved', 1)
                        ->select('name', 'category_id', 'num_of_sale', 'thumbnail_img', 'id')->orderBy('num_of_sale', 'DESC')->limit(6)->get();
            
            $chartData['top_product'] = $numOfSale;
        }
        else if($request->group == 'market'){
            $query = "AND market_id = ".$request->select_value."";
        }

        $orders = DB::SELECT("
            SELECT sum(count) AS total, DATE(order_date) AS order_date, payment_status FROM 
            (
                (
                    SELECT count(*) AS count, DATE(created_at) AS order_date, payment_status FROM orders 
                    WHERE DATE(created_at) >= '".$startPackageDate."' AND DATE(created_at) <= '".$endPackageDate."'
                        ".$query."
                    GROUP BY DATE(created_at), payment_status
                )
                UNION
                (
                    SELECT count(*) AS count, DATE(order_at) AS order_date, payment_status FROM hot_orders 
                    WHERE DATE(order_at) >= '".$startPackageDate."' AND DATE(order_at) <= '".$endPackageDate."'
                        ".$query."
                    GROUP BY DATE(order_at), payment_status
                )
            ) a
            GROUP BY DATE(order_date), payment_status
            ORDER BY DATE(order_date)
        ");
        $orderPeriod = new DatePeriod(
            new DateTime($startPackageDate),
            new DateInterval('P1D'),
            new DateTime($endPackageDate)
        );
        foreach($orderPeriod as $period){
            $date = $period->format('Y-m-d');
            $dateFormated = $period->format('d/m/Y');
            $chartData['package']['labels'][] = $dateFormated;
            foreach($orders as $order){
                if($order->order_date == $date){
                    $chartData['package']['data'][$order->payment_status][] = intval($order->total);
                }
                else{
                    $chartData['package']['data'][$order->payment_status][] = 0;
                }
            }
        }
        
        $revenues = DB::SELECT("
            SELECT sum(total) AS total, DATE(order_date) AS order_date FROM 
            (
                (
                    SELECT sum(grand_total) as total, DATE(created_at) AS order_date FROM orders 
                    WHERE DATE(created_at) >= '".$startRevenueDate."' AND DATE(created_at) <= '".$endRevenueDate."' 
                        AND payment_status = 'paid'
                        ".$query."
                    GROUP BY DATE(created_at), payment_status
                )
                UNION
                (
                    SELECT sum(grand_total) as total, DATE(order_at) AS order_date FROM hot_orders 
                    WHERE DATE(order_at) >= '".$startRevenueDate."' AND DATE(order_at) <= '".$endRevenueDate."' 
                        AND payment_status = 'paid'
                        ".$query."
                    GROUP BY DATE(order_at)
                )
            ) a
            GROUP BY DATE(order_date)
        ");

        $revenuePeriod = new DatePeriod(
            new DateTime($startRevenueDate),
            new DateInterval('P1D'),
            new DateTime($endRevenueDate)
        );
        foreach($revenuePeriod as $period){
            $date = $period->format('Y-m-d');
            $dateFormated = $period->format('d/m/Y');
            $chartData['revenue']['labels'][] = $dateFormated;
            foreach($revenues as $revenue){
                if($revenue->order_date == $date){
                    $chartData['revenue']['data'][] = $revenue->total;
                }
                else{
                    $chartData['revenue']['data'][] = 0;
                }
            }
        }

        return response()->json(['data' => $chartData]);
    }

    public function getAdminChart(Request $request)
    {

        $adminDate = explode(' - ',$request->date);
        $startDate = date("Y-m-d", strtotime(str_replace("/", "-", $adminDate[0])));
        $endDate = date("Y-m-d", strtotime(str_replace("/", "-", $adminDate[1])));

        $sellerPackagePayment = DB::SELECT("
            SELECT id, created_at, seller_package_id, approval
            FROM seller_package_payments
            WHERE DATE(created_at) >= '".$startDate."' AND DATE(created_at) <= '".$endDate."'
        ");
        
        $sellerPackage = SellerPackage::get()->pluck('amount', 'id')->toArray();

        $chartData = [];

        $orderPeriod = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($endDate)
        );

        foreach($orderPeriod as $period){
            $date = $period->format('Y-m-d');
            $dateFormated = $period->format('d/m/Y');
            $chartData['admin_package']['labels'][] = $dateFormated;
            $chartData['revenue']['labels'][] = $dateFormated;
            foreach($sellerPackagePayment as $order){
                $orderDate = new DateTime($order->created_at);
                $orderDateFormat = $orderDate->format('Y-m-d');

                if(!isset($chartData['admin_package']['data'][$order->approval][strtotime($date)])){
                    $chartData['admin_package']['data'][$order->approval][strtotime($date)] = 0;
                }
                if(!isset($chartData['revenue']['data'][strtotime($date)])){
                    $chartData['revenue']['data'][strtotime($date)] = 0;
                }
                
                if($orderDateFormat == $date){
                    $chartData['admin_package']['data'][$order->approval][strtotime($date)] += 1;
                    $chartData['revenue']['data'][strtotime($date)] += $sellerPackage[$order->seller_package_id];
                }
                else{
                    $chartData['admin_package']['data'][$order->approval][strtotime($date)] += 0;
                    $chartData['revenue']['data'][strtotime($date)] += 0;
                }
            }
        }

        if(!isset($chartData['admin_package']['data'][1])){
            $chartData['admin_package']['data'][1] = [];
        }
        if(!isset($chartData['admin_package']['data'][0])){
            $chartData['admin_package']['data'][0] = [];
        }

        return response()->json(['data' => $chartData]);
    }

    function clearCache(Request $request)
    {
        Artisan::call('cache:clear');
        flash(translate('Cache cleared successfully'))->success();
        return back();
    }
}
