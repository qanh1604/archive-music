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
        // $root_categories = Category::where('level', 0)->get();

        // $cached_graph_data = Cache::remember('cached_graph_data', 86400, function() use ($root_categories){
        //     $num_of_sale_data = null;
        //     $qty_data = null;
        //     foreach ($root_categories as $key => $category){
        //         $category_ids = \App\Utility\CategoryUtility::children_ids($category->id);
        //         $category_ids[] = $category->id;

        //         $products = Product::with('stocks')->whereIn('category_id', $category_ids)->get();
        //         $qty = 0;
        //         $sale = 0;
        //         foreach ($products as $key => $product) {
        //             $sale += $product->num_of_sale;
        //             foreach ($product->stocks as $key => $stock) {
        //                 $qty += $stock->qty;
        //             }
        //         }
        //         $qty_data .= $qty.',';
        //         $num_of_sale_data .= $sale.',';
        //     }
        //     $item['num_of_sale_data'] = $num_of_sale_data;
        //     $item['qty_data'] = $qty_data;

        //     return $item;
        // });

        $marketSessions = MarketSessionDetail::get();
        $totalSession = count($marketSessions);

        $totalCustomer = User::whereIn('user_type', ['customer', 'seller'])->count();
        $totalProduct = Product::where('added_by', 'seller')->where('auction_product',0)
                    ->where('wholesale_product',0)->count();

        $revenueOrder = Order::where('payment_status', 'paid')->sum('grand_total');
        $revenueHotOrder = HotOrder::where('payment_status', 'paid')->sum('grand_total');
        $totalRevenue = $revenueOrder + $revenueHotOrder;

        $sellers = Shop::select('user_id', 'name')->get();

        return view('backend.dashboard', compact(
            'totalSession', 
            'totalCustomer', 
            'totalProduct',
            'totalRevenue',
            'sellers',
            'marketSessions'
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
                    $chartData['package']['data'][$order->payment_status][] = $order->total;
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

    function clearCache(Request $request)
    {
        Artisan::call('cache:clear');
        flash(translate('Cache cleared successfully'))->success();
        return back();
    }
}
