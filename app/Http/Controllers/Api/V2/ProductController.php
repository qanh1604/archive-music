<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\ProductMiniCollection;
use App\Http\Resources\V2\ProductDetailCollection;
use App\Http\Resources\V2\FlashDealCollection;
use App\Models\FlashDeal;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Recommendation;
use App\Models\Color;
use App\Models\Album;
use App\Models\Song;
use App\Models\Upload;
use App\Models\ListenedSong;
use App\Models\Favourite;
use App\Models\Search;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use App\Utility\SearchUtility;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Auth;
use Cache;

class ProductController extends Controller
{
    public function index()
    {
        return new ProductMiniCollection(Song::latest()->paginate(10));
    }

    public function show($id)
    {
        return new ProductDetailCollection(Song::where('id', $id)->get());
    }

    public function admin()
    {
        return new ProductCollection(Product::where('added_by', 'admin')->latest()->paginate(10));
    }

    public function artist($id)
    {
        $songs = Song::where('artist_id', $id)->where('is_publish', 1)->get();
        
        return new ProductDetailCollection($songs);
    }

    public function seller($id, Request $request)
    {
        $shop = Shop::findOrFail($id);
        $products = Product::where('added_by', 'seller')->where('user_id', $shop->user_id);
        if ($request->name != "" || $request->name != null) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products->where('published', 1);
        
        return new ProductMiniCollection($products->latest()->paginate(10));
    }

    public function category($category_id)
    {
        $songs = Song::where('category_id', $category_id)->where('is_publish', 1)->paginate(10);
        return new ProductMiniCollection($songs);
    }

    public function albums()
    {
        $albums = Album::paginate(10);
        foreach($albums as &$album){
            $album->image = $album->image_url->file_name;
        }
        return response()->json($albums);
    }

    public function albumDetail($id){
        $songs = Song::where('album_id', $id)->where('is_publish', 1)->paginate(10);
        return new ProductMiniCollection($songs);
    }

    public function brand($id, Request $request)
    {
        $products = Product::where('brand_id', $id)->physical();
        if ($request->name != "" || $request->name != null) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }

        return new ProductMiniCollection(filter_products($products)->latest()->paginate(10));
    }

    public function todaysDeal()
    {
        return Cache::remember('app.todays_deal', 86400, function(){
            $products = Product::where('todays_deal', 1)->physical();
            return new ProductMiniCollection(filter_products($products)->limit(20)->latest()->get());
        });
    }

    public function flashDeal()
    {
        return Cache::remember('app.flash_deals', 86400, function(){
            $flash_deals = FlashDeal::where('status', 1)->where('featured', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
            return new FlashDealCollection($flash_deals);
        });
    }

    public function featured()
    {
        $products = Product::where('featured', 1)->physical();
        return new ProductMiniCollection(filter_products($products)->latest()->paginate(10));
    }

    public function bestSeller()
    {
        return Cache::remember('app.best_selling_products', 86400, function(){
            $products = Product::orderBy('num_of_sale', 'desc')->physical();
            return new ProductMiniCollection(filter_products($products)->limit(20)->get());
        });
    }

    public function related($id)
    {
        $product = Song::find($id);
        $products = Song::where('category_id', $product->category_id)->where('id', '!=', $id)->latest()->limit(10)->get();
        return new ProductMiniCollection($products);
    }

    public function topFromSeller($id)
    {
        return Cache::remember("app.top_from_this_seller_products-$id", 86400, function() use ($id){
            $product = Product::find($id);
            $products = Product::where('user_id', $product->user_id)->orderBy('num_of_sale', 'desc')->physical();

            return new ProductMiniCollection(filter_products($products)->limit(10)->get());
        });
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $type = $request->type;

        $products = Song::query();

        $products->where('is_publish', 1);

        if ($name != null && $name != "") {
            if(isset($type) && $type == "artist"){
                $products->where(function ($query) use ($name) {
                    foreach (explode(' ', trim($name)) as $word) {
                        $query->WhereHas('user', function($query) use ($word){
                            $query->where('name', 'like', '%'.$word.'%');
                        });
                    }
                });
            }
    
            if(isset($type) && $type == "album"){
                $products->where(function ($query) use ($name) {
                    foreach (explode(' ', trim($name)) as $word) {
                        $query->WhereHas('album', function($query) use ($word){
                            $query->where('name', 'like', '%'.$word.'%');
                        });
                    }
                });
            }

            if(isset($type) && $type == "category"){
                $products->where(function ($query) use ($name) {
                    foreach (explode(' ', trim($name)) as $word) {
                        $query->WhereHas('category', function($query) use ($word){
                            $query->where('name', 'like', '%'.$word.'%');
                        });
                    }
                });
            }

            if(isset($type) && $type == "all"){
                $products->where(function ($query) use ($name) {
                    foreach (explode(' ', trim($name)) as $word) {
                        $query->where('name', 'like', '%'.$word.'%')
                            ->orWhereHas('user', function($query) use ($word){
                                $query->where('name', 'like', '%'.$word.'%');
                            })->orWhereHas('album', function($query) use ($word){
                                $query->where('name', 'like', '%'.$word.'%');
                            })->orWhereHas('category', function($query) use ($word){
                                $query->where('name', 'like', '%'.$word.'%');
                            });
                    }
                });
            }
            
            $search = Search::where('query', $name)->first();

            if($search){
                $search->count++;
                $search->save();
            }else{
                $search = new Search;
                $search->user_id = Auth::user()->id;
                $search->query = $name;
                $search->save();
            }
        }

        return new ProductMiniCollection($products->paginate(10));
    }

    public function searchHistory(Request $request){
        $search = Search::where('user_id', Auth::user()->id)->latest()->limit(5)->get();

        return response()->json([
            'success' => true,
            'data' => $search
        ]);
    }

    public function topSearch(Request $request){

        $topSearches = Search::orderByRaw("CAST(count as UNSIGNED) DESC")->limit(5)->get();

        return response()->json([
            'success' => true,
            'data' => $topSearches
        ]);
    }

    public function variantPrice(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $str = '';
        $tax = 0;

        if ($request->has('color') && $request->color != "") {
            $str = Color::where('code', '#' . $request->color)->first()->name;
        }

        $var_str = str_replace(',', '-', $request->variants);
        $var_str = str_replace(' ', '', $var_str);

        if ($var_str != "") {
            $temp_str = $str == "" ? $var_str : '-' . $var_str;
            $str .= $temp_str;
        }


        $product_stock = $product->stocks->where('variant', $str)->first();
        $price = $product_stock->price;
        $stockQuantity = $product_stock->qty;


        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }

        return response()->json([
            'product_id' => $product->id,
            'variant' => $str,
            'price' => (double)convert_price($price),
            'price_string' => format_price(convert_price($price)),
            'stock' => intval($stockQuantity),
            'image' => $product_stock->image == null ? "" : api_asset($product_stock->image) 
        ]);
    }

    public function home()
    {
        return new ProductCollection(Product::inRandomOrder()->physical()->take(50)->get());
    }

    public function recommendations()
    {
        $recommendations = Recommendation::paginate(10);
        foreach($recommendations as $item){
            $icon = Upload::where('id', $item->song?$item->song->icon:'')->first();
            $imageList = explode(",", $item->song?$item->song->image:'');
            $image = Upload::select('file_name')->whereIn('id', $imageList)->get();
            $album = Album::where('id', $item->song?$item->song->album_id:'')->first();

            if($item->song){
                $item->song->icon = $icon?$icon->file_name:'';
                $item->song->image = $image;
                $item->song->artist = $item->song->user->artist?$item->song->user->artist->name:$item->song->user->name;
            }
        }
        return response()->json([
            'success' => true,
            'data' => $recommendations
        ]);
    }

    public function listen($id){
        $song = Song::find($id);

        if($song){
            $listened_song = ListenedSong::where('user_id', Auth::user()->id)->where('song_id', $id)->first();
            if($listened_song){
                $listened_song->count++;
                $listened_song->save();
            }else{
                $listened_song = new ListenedSong;
                $listened_song->user_id = Auth::user()->id;
                $listened_song->song_id = $id;
                $listened_song->count = 1;
                $listened_song->save();
            }
            $song->view++;
            $song->save();

            return response()->json([
                'success' => true,
                'data' => $listened_song
            ]);
        }
    }

    public function listenedSong(){
        $listened_song = ListenedSong::where('user_id', Auth::user()->id)->latest()->limit(5)->get();
        if($listened_song){
            $songs = Song::whereIn('id', $listened_song->pluck('song_id')->toArray())->where('is_publish', 1)->paginate(15);
        }
        return new ProductMiniCollection($songs);
    }

    public function likeSong($id){
        $song = Song::find($id); 
        if(!$song){
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy bài hát"
            ]);
        }

        $favouriteCheck = Favourite::where('user_id', Auth::user()->id)->where('song_id', $id)->first();
        if($favouriteCheck){
            $favouriteCheck->delete();
            $song->like--;
            $song->save();

            return response()->json([
                'success' => true,
                'message' => 'Hủy like thành công'
            ]);
        }

        $favourite = new Favourite;
        $favourite->user_id = Auth::user()->id;
        $favourite->song_id = $id;
        $favourite->save();
        $song->like++;
        $song->save();

        return response()->json([
            'success' => true,
            'message' => 'Like thành công'
        ]);
    }

    public function stripeTest(Request $request){
        // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));dd($stripe);
        $stripe->customers->all(['limit' => 3]);
    }
    
}
