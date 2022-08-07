<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Song;
use App\Models\ProductTranslation;
use App\Models\ProductStock;
use App\Models\Category;
use App\Models\FlashDealProduct;
use App\Models\ProductTax;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Album;
use App\Models\User;
use App\Models\Upload;
use App\Models\Recommendation;
use Illuminate\Support\Facades\File;
use Auth;
use Carbon\Carbon;
use Combinations;
use CoreComponentRepository;
use Validator;
use Artisan;
use Cache;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $sort_search = null;
        
        $songs = Song::with('user')->where('deleted_at', null);
        // $products = Product::where('added_by', 'admin')->where('auction_product',0)->where('wholesale_product',0);

        if ($request->col_name != null){
            $col_name = $var[0];
            $query = $var[1];
            $songs = $songs->orderBy($col_name, $query);
        }
        if ($request->search != null){
            $songs = $songs->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $songs = $songs->orderBy('created_at', 'desc')->paginate(15);

        return view('backend.product.songs.index', compact('songs', 'col_name', 'query', 'sort_search'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $products = Product::where('added_by', 'seller')->where('auction_product',0)->where('wholesale_product',0);
        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $products = $products->where('digital', 0)->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';

        return view('backend.product.products.index', compact('products','type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }

    public function all_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $sort_search = null;
        
        $songs = Song::with('user')->where('deleted_at', null);
        // $products = Product::where('added_by', 'admin')->where('auction_product',0)->where('wholesale_product',0);

        if ($request->col_name != null){
            $col_name = $var[0];
            $query = $var[1];
            $songs = $songs->orderBy($col_name, $query);
        }
        if ($request->search != null){
            $songs = $songs->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $songs = $songs->orderBy('created_at', 'desc')->paginate(15);

        return view('backend.product.songs.index', compact('songs', 'col_name', 'query', 'sort_search'));
    }

    public function filter_product(Request $request){
        // dd($request);
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $products = Product::orderBy('created_at', 'desc')->where('auction_product',0)->where('wholesale_product',0);
        
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        $products = $products->paginate(15);
        // $type = 'All';
        $type = 'Seller';

        return view('backend.product.inc.product_body', compact('products','type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CoreComponentRepository::initializeCache();

        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->get();
            
        $albums = Album::where('artist_id', Auth::user()->id)->get();

        return view('backend.product.songs.create', compact('categories', 'albums'));
    }

    public function add_more_choice_option(Request $request) {
        $all_attribute_values = AttributeValue::with('attribute')->where('attribute_id', $request->attribute_id)->get();

        $html = '';

        foreach ($all_attribute_values as $row) {
            $html .= '<option value="' . $row->value . '">' . $row->value . '</option>';
        }

        echo json_encode($html);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'song_id' => 'required',
            'category_id' => 'required',
            'photos' => 'required',
            'thumbnail_img' => 'required'
        ]);
        if ($validator->fails()) {
            flash(translate($validator->errors()->first()))->error();
            return back();
        }
        $upload = Upload::where('id', $request->song_id)->first();
        if(!$upload){
            flash("Đã có lỗi xảy ra vui lòng thử lại");
            return back();
        }

        $song = new Song;
        $song->name = $request->name;
        $song->artist_id = Auth::user()->id;
        $song->song_url = $upload->file_name;
        $song->icon = $request->thumbnail_img;
        $song->image = $request->photos;
        $song->album_id = $request->album_id;
        $song->lyric = $request->lyric;

        $song->is_publish = 1;
        if($request->button == 'unpublish') {
            $song->is_publish = 0;
        }

        $song->save();

        if ($request->has('featured')) {
            $recommendation = new Recommendation;
            $recommendation->song_id = $song->id;
            $recommendation->save();

            $song->featured = 1;
            $song->save();
        }

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff'){
            return redirect()->route('products.admin');
        }
        else{
            return redirect()->route('seller.products');
        }
    }

    public function storeMp3(Request $request){
        $mp3 = $request->file('file');
        $mp3Name = $mp3->getClientOriginalName();

        $dir = public_path('uploads/audio');
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $full_path = "$dir/$mp3Name";

        $file_put = $mp3->move($dir, $mp3Name);
        if ($file_put == false) {
            return response()->json([
                'result' => false,
                'message' => "Uploading error",
                'path' => ""
            ]);
        }
        
        $upload = new Upload;
        $extension = strtolower(File::extension($full_path));
        $size = File::size($full_path);

        $upload->file_original_name = $mp3Name;
        $arr = explode('.', File::name($full_path));
        
        for ($i = 0; $i < count($arr) - 1; $i++) {
            if ($i == 0) {
                $upload->file_original_name .= $arr[$i];
            } else {
                $upload->file_original_name .= "." . $arr[$i];
            }
        }

        $randString = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,20);
        $newFileName = $randString . date("YmdHis") . "." . $extension;
        $newFullPath = "$dir/$newFileName";
     
        rename($full_path, $newFullPath);
        
        if ($file_put == false) {
            return response()->json([
                'result' => false,
                'message' => "Uploading error",
                'path' => ""
            ]);
        }

        $newPath = "uploads/audio/$newFileName";

        $upload->extension = $extension;
        $upload->file_name = $newPath;
        $upload->user_id = $request->id;
        $upload->type = "audio";
        $upload->file_size = $size;
        $upload->save();

        return response()->json([
            'success' => true,
            'upload_id' => $upload->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function admin_product_edit(Request $request, $id)
     {
        // CoreComponentRepository::initializeCache();
        $song = Song::findOrFail($id);
        $categories = Category::get();
        $albums = Album::get();
        
        return view('backend.product.songs.edit', compact('song', 'categories', 'albums'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if($product->digital == 1) {
            return redirect('digitalproducts/' . $id . '/edit');
        }
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::all();
        return view('backend.product.products.edit', compact('product', 'categories', 'tags','lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $song = Song::findOrFail($id);
        $song->name = $request->name;
        $song->category_id = $request->category_id;
        $song->album_id = $request->album_id;
        $song->icon = $request->icon;
        $song->image = $request->image;
        $song->lyric = $request->lyric;

        if($request->song_id){
            $upload = Upload::where('id', $request->song_id)->first();
            $song->song_url = $upload->file_name;
        }

        $song->save();

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        foreach ($product->product_translations as $key => $product_translations) {
            $product_translations->delete();
        }

        foreach ($product->stocks as $key => $stock) {
            $stock->delete();
        }

        if(Product::destroy($id)){
            Cart::where('product_id', $id)->delete();

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return back();
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_product_delete(Request $request) {
        if($request->id) {
            foreach ($request->id as $product_id) {
                $this->destroy($product_id);
            }
        }

        return 1;
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request, $id)
    {
        $product = Product::find($id);

        if(Auth::user()->id == $product->user_id || Auth::user()->user_type == 'staff'){
            $product_new = $product->replicate();
            $product_new->slug = $product_new->slug.'-'.Str::random(5);
            $product_new->save();

            foreach ($product->stocks as $key => $stock) {
                $product_stock              = new ProductStock;
                $product_stock->product_id  = $product_new->id;
                $product_stock->variant     = $stock->variant;
                $product_stock->price       = $stock->price;
                $product_stock->sku         = $stock->sku;
                $product_stock->qty         = $stock->qty;
                $product_stock->save();

            }

            flash(translate('Product has been duplicated successfully'))->success();
            if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff'){
              if($request->type == 'In House')
                return redirect()->route('products.admin');
              elseif($request->type == 'Seller')
                return redirect()->route('products.seller');
              elseif($request->type == 'All')
                return redirect()->route('products.all');
            }
            else{
                if (addon_is_activated('seller_subscription') && Auth::user()->user_type == 'seller') {
                    $seller = Auth::user();
                    $seller->remaining_uploads -= 1;
                    $seller->save();
                }
                return redirect()->route('seller.products');
            }
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
    }

    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        $product->save();
        Cache::forget('todays_deal_products');
        return 1;
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;

        if($product->added_by == 'seller' && addon_is_activated('seller_subscription')){
            $seller = $product->user->seller;
            if($seller->invalid_at != null && $seller->invalid_at != '0000-00-00' && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                return 0;
            }
        }

        $product->save();
        return 1;
    }

    public function updateProductApproval(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->approved = $request->approved;

        if($product->added_by == 'seller' && addon_is_activated('seller_subscription')){
            $seller = $product->user->seller;
            if($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                return 0;
            }
        }

        $product->save();
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if($product->save()){
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return 1;
        }
        return 0;
    }

    public function updateSellerFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->seller_featured = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                // foreach (json_decode($request[$name][0]) as $key => $item) {
                foreach ($request[$name] as $key => $item) {
                    // array_push($data, $item->value);
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.product.products.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                // foreach (json_decode($request[$name][0]) as $key => $item) {
                foreach ($request[$name] as $key => $item) {
                    // array_push($data, $item->value);
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.product.products.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }

}
