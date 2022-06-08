<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Order;
use App\Models\VirtualAssistant;
use App\Models\OrderDetail;
use App\Models\Video;
use App\Models\Upload;
use Illuminate\Support\Facades\Hash;
use App\Notifications\EmailVerificationNotification;
use Cache;
use Mail;
use Illuminate\Support\Str;
use App\Mail\EmailManager;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $approved = null;
        $sellers = Seller::whereIn('user_id', function ($query) {
            $query->select('id')
                ->from(with(new User)->getTable());
        })->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'seller')->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
            $sellers = $sellers->where(function ($seller) use ($user_ids) {
                $seller->whereIn('user_id', $user_ids);
            });
        }
        if ($request->approved_status != null) {
            $approved = $request->approved_status;
            $sellers = $sellers->where('verification_status', $approved);
        }
        $sellers = $sellers->paginate(15);

        foreach($sellers as &$seller){
            $products = Product::with('category')->where('user_id', $seller->user_id)->get();
            $productCategory = [];
            $productCategoryId = [];
    
            foreach($products as $product){
                if($product->category){
                    if(!in_array($product->category->id, $productCategoryId)){
                        $productCategory[] = $product->category->name;
                        $productCategoryId[] = $product->category->id;
                    }
                }
            }
    
            $seller->category = implode(', ', $productCategory);
        }
        
        return view('backend.sellers.index', compact('sellers', 'sort_search', 'approved'));
    }

    public function filter(Request $request)
    {
        $sort_search = null;
        $approved = null;
        $sellers = Seller::whereIn('user_id', function ($query) {
            $query->select('id')
                ->from(with(new User)->getTable());
        })->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'seller')->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
            $sellers = $sellers->where(function ($seller) use ($user_ids) {
                $seller->whereIn('user_id', $user_ids);
            });
        }
        if ($request->approved_status != null) {
            $approved = $request->approved_status;
            $sellers = $sellers->where('verification_status', $approved);
        }
        $sellers = $sellers->paginate(15);

        foreach($sellers as &$seller){
            $products = Product::with('category')->where('user_id', $seller->user_id)->get();
            $productCategory = [];
            $productCategoryId = [];
    
            foreach($products as $product){
                if($product->category){
                    if(!in_array($product->category->id, $productCategoryId)){
                        $productCategory[] = $product->category->name;
                        $productCategoryId[] = $product->category->id;
                    }
                }
            }
    
            $seller->category = implode(', ', $productCategory);
        }
        return view('backend.sellers.inc.seller_body', compact('sellers', 'sort_search', 'approved'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (User::where('email', $request->email)->first() != null) {
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            if (get_setting('email_verification') != 1) {
                $user->email_verified_at = date('Y-m-d H:m:s');
            } else {
                $user->notify(new EmailVerificationNotification());
            }
            $user->save();

            $seller = new Seller;
            $seller->user_id = $user->id;

            if ($seller->save()) {
                if($request->open_video_360){
                    $open_video = Upload::where('id', $request->open_video_360)->first();

                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 360;
                    $video->url = $open_video->file_name;
                    $video->file_id = $open_video->id;
                    $video->type = "seller_video";
                    $video->save();
                }

                if($request->open_video_480){
                    $open_video = Upload::where('id', $request->open_video_480)->first();

                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 480;
                    $video->url = $open_video->file_name;
                    $video->file_id = $open_video->id;
                    $video->type = "seller_video";
                    $video->save();
                }

                if($request->open_video_720){
                    $open_video = Upload::where('id', $request->open_video_720)->first();

                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 720;
                    $video->url = $open_video->file_name;
                    $video->file_id = $open_video->id;
                    $video->type = "seller_video";
                    $video->save();
                }

                if($request->open_video_1080){
                    $open_video = Upload::where('id', $request->open_video_1080)->first();

                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 1080;
                    $video->url = $open_video->file_name;
                    $video->file_id = $open_video->id;
                    $video->type = "seller_video";
                    $video->save();
                }

                $shop = new Shop;
                $shop->user_id = $user->id;
                $shop->name = $request->shop_name;
                $shop->address = $request->address;
                $shop->phone = $request->phone;
                $shop->meta_title = $request->shop_name;
                $shop->meta_description = $request->meta_description;
                $shop->slug = Str::slug($request->shop_name) . '-' . $user->id;
                $shop->save();

                flash(translate('Seller has been inserted successfully'))->success();
                return redirect()->route('sellers.index');
            }
        }
        flash(translate('Something went wrong'))->error();
        return back();
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
    public function edit($id)
    {
        $open_video_360 = "";
        $open_video_480 = "";
        $open_video_720 = "";
        $open_video_1080 = "";
        $virtual_assistant_360 = "";
        $virtual_assistant_480 = "";
        $virtual_assistant_720 = "";
        $virtual_assistant_1080 = "";

        $seller = Seller::findOrFail(decrypt($id));

        $open_video_360 = Video::where('seller_id', $seller->id)->where('name', '360')->where('type', 'seller_video')->first();
        if($open_video_360){
            $open_video_360 = $open_video_360->file_id;
        }
        $open_video_480 = Video::where('seller_id', $seller->id)->where('name', '480')->where('type', 'seller_video')->first();
        if($open_video_480){
            $open_video_480 = $open_video_480->file_id;
        }
        $open_video_720 = Video::where('seller_id', $seller->id)->where('name', '720')->where('type', 'seller_video')->first();
        if($open_video_720){
            $open_video_720 = $open_video_720->file_id;
        }
        $open_video_1080 = Video::where('seller_id', $seller->id)->where('name', '1080')->where('type', 'seller_video')->first();
        if($open_video_1080){
            $open_video_1080 = $open_video_1080->file_id;
        }

        $virtual_assistant = VirtualAssistant::where('id', $seller->virtual_assistant_id)->first();

        if($virtual_assistant){
            $virtual_assistant_360 = Video::where('seller_id', $seller->id)->where('name', '360')->where('type', 'virtual_video')->first();
            if($virtual_assistant_360){
                $virtual_assistant_360 = $virtual_assistant_360->file_id;
            }
            $virtual_assistant_480 = Video::where('seller_id', $seller->id)->where('name', '480')->where('type', 'virtual_video')->first();
            if($virtual_assistant_480){
                $virtual_assistant_480 = $virtual_assistant_480->file_id;
            }
            $virtual_assistant_720 = Video::where('seller_id', $seller->id)->where('name', '720')->where('type', 'virtual_video')->first();
            if($virtual_assistant_720){
                $virtual_assistant_720 = $virtual_assistant_720->file_id;
            }
            $virtual_assistant_1080 = Video::where('seller_id', $seller->id)->where('name', '1080')->where('type', 'virtual_video')->first();
            if($virtual_assistant_1080){
                $virtual_assistant_1080 = $virtual_assistant_1080->file_id;
            }
        }
        return view('backend.sellers.edit', compact(
            'seller', 
            'virtual_assistant', 
            'open_video_360', 
            'open_video_480', 
            'open_video_720', 
            'open_video_1080',
            'virtual_assistant_360',
            'virtual_assistant_480',
            'virtual_assistant_720',
            'virtual_assistant_1080'
        ));
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
        $seller = Seller::findOrFail($id);
        $user = $seller->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->shop->meta_description = $request->meta_description;
        $user->shop->background_img = $request->background_img;

        if($request->open_video_360){
            $video_360 = Video::where('seller_id', $seller->id)->where('name', '360')->where('type', 'seller_video')->where('file_id', $request->open_video_360)->first();
            if($video_360){
                $video_360->file_id = $request->open_video_360;
                $video_360->save();
            }else{
                $open_video = Upload::where('id', $request->open_video_360)->first();

                $video = new Video();
                $video->seller_id = $seller->id;
                $video->name = 360;
                $video->url = $open_video->file_name;
                $video->file_id = $open_video->id;
                $video->type = "seller_video";
                $video->save();
            }
        }else{
            $video_360 = Video::where('seller_id', $seller->id)->where('name', '360')->where('type', 'seller_video')->first();
            if($video_360){
                $video_360->delete();
            }
        }

        if($request->open_video_480){
            $video_480 = Video::where('seller_id', $seller->id)->where('name', '480')->where('type', 'seller_video')->where('file_id', $request->open_video_480)->first();
            if($video_480){
                $video_480->file_id = $request->open_video_480;
                $video_480->save();
            }else{
                $open_video = Upload::where('id', $request->open_video_480)->first();

                $video = new Video();
                $video->seller_id = $seller->id;
                $video->name = 480;
                $video->url = $open_video->file_name;
                $video->file_id = $open_video->id;
                $video->type = "seller_video";
                $video->save();
            }
        }else{
            $video_480 = Video::where('seller_id', $seller->id)->where('name', '480')->where('type', 'seller_video')->first();
            if($video_480){
                $video_480->delete();
            }
        }

        if($request->open_video_720){
            $video_720 = Video::where('seller_id', $seller->id)->where('name', '720')->where('type', 'seller_video')->where('file_id', $request->open_video_720)->first();
            if($video_720){
                $video_720->file_id = $request->open_video_720;
                $video_720->save();
            }else{
                $open_video = Upload::where('id', $request->open_video_720)->first();

                $video = new Video();
                $video->seller_id = $seller->id;
                $video->name = 720;
                $video->url = $open_video->file_name;
                $video->file_id = $open_video->id;
                $video->type = "seller_video";
                $video->save();
            }
        }else{
            $video_720 = Video::where('seller_id', $seller->id)->where('name', '720')->where('type', 'seller_video')->first();
            if($video_720){
                $video_720->delete();
            }
        }

        if($request->open_video_1080){
            $video_1080 = Video::where('seller_id', $seller->id)->where('name', '1080')->where('type', 'seller_video')->where('file_id', $request->open_video_1080)->first();
            if($video_1080){
                $video_1080->file_id = $request->open_video_1080;
                $video_1080->save();
            }else{
                $open_video = Upload::where('id', $request->open_video_1080)->first();

                $video = new Video();
                $video->seller_id = $seller->id;
                $video->name = 1080;
                $video->url = $open_video->file_name;
                $video->file_id = $open_video->id;
                $video->type = "seller_video";
                $video->save();
            }
        }else{
            $video_1080 = Video::where('seller_id', $seller->id)->where('name', '1080')->where('type', 'seller_video')->first();
            if($video_1080){
                $video_1080->delete();
            }
        }

        $virtual_assistant = VirtualAssistant::where('id', $seller->virtual_assistant_id)->first();
        if($virtual_assistant){
            $virtual_assistant->seller_id = $seller->id;
            $virtual_assistant->video = $request->virtual_assistant?$request->virtual_assistant:'';
            $virtual_assistant->description = $request->description;
            $virtual_assistant->save();
            $seller->virtual_assistant_id = $virtual_assistant->id;

            if($request->virtual_assistant_360){
                $virtual_360 = Video::where('seller_id', $seller->id)->where('name', '360')->where('type', 'virtual_video')->where('file_id', $request->virtual_assistant_360)->first();
                if($virtual_360){
                    $virtual_360->file_id = $request->virtual_assistant_360;
                    $virtual_360->save();
                }else{
                    $virtual_assistant_360 = Upload::where('id', $request->virtual_assistant_360)->first();

                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 360;
                    $video->url = $virtual_assistant_360->file_name;
                    $video->file_id = $virtual_assistant_360->id;
                    $video->type = "virtual_video";
                    $video->save();
                }
            }else{
                $virtual_360 = Video::where('seller_id', $seller->id)->where('name', '360')->where('type', 'virtual_video')->first();
                if($virtual_360){
                    $virtual_360->delete();
                }
            }
    
            if($request->virtual_assistant_480){
                $virtual_480 = Video::where('seller_id', $seller->id)->where('name', '480')->where('type', 'virtual_video')->where('file_id', $request->virtual_assistant_480)->first();
                if($virtual_480){
                    $virtual_480->file_id = $request->virtual_assistant_480;
                    $virtual_480->save();
                }else{
                    $virtual_assistant_480 = Upload::where('id', $request->virtual_assistant_480)->first();

                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 480;
                    $video->url = $virtual_assistant_480->file_name;
                    $video->file_id = $virtual_assistant_480->id;
                    $video->type = "virtual_video";
                    $video->save();
                }
            }else{
                $virtual_480 = Video::where('seller_id', $seller->id)->where('name', '480')->where('type', 'virtual_video')->first();
                if($virtual_480){
                    $virtual_480->delete();
                }
            }
    
            if($request->virtual_assistant_720){
                $virtual_720 = Video::where('seller_id', $seller->id)->where('name', '720')->where('type', 'virtual_video')->where('file_id', $request->virtual_assistant_720)->first();
                if($virtual_720){
                    $virtual_720->file_id = $request->virtual_assistant_720;
                    $virtual_720->save();
                }else{
                    $virtual_assistant_720 = Upload::where('id', $request->virtual_assistant_720)->first();

                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 720;
                    $video->url = $virtual_assistant_720->file_name;
                    $video->file_id = $virtual_assistant_720->id;
                    $video->type = "virtual_video";
                    $video->save();
                }
            }else{
                $virtual_720 = Video::where('seller_id', $seller->id)->where('name', '720')->where('type', 'virtual_video')->first();
                if($virtual_720){
                    $virtual_720->delete();
                }
            }
    
            if($request->virtual_assistant_1080){
                $virtual_1080 = Video::where('seller_id', $seller->id)->where('name', '1080')->where('type', 'virtual_video')->where('file_id', $request->virtual_assistant_1080)->first();
                if($virtual_1080){
                    $virtual_1080->file_id = $request->virtual_assistant_1080;
                    $virtual_1080->save();
                }else{
                    $virtual_assistant_1080 = Upload::where('id', $request->virtual_assistant_1080)->first();

                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 1080;
                    $video->url = $virtual_assistant_1080->file_name;
                    $video->file_id = $virtual_assistant_1080->id;
                    $video->type = "virtual_video";
                    $video->save();
                }
            }else{
                $virtual_1080 = Video::where('seller_id', $seller->id)->where('name', '1080')->where('type', 'virtual_video')->first();
                if($virtual_1080){
                    $virtual_1080->delete();
                }
            }

            if(!$request->virtual_assistant_360 && !$request->virtual_assistant_480 && !$request->virtual_assistant_720 && !$request->virtual_assistant_1080 && !$request->description){
                $virtual_ = VirtualAssistant::where('seller_id', $seller->id)->first();
                if($virtual_){
                    $virtual_->delete();
                }
                $seller->virtual_assistant_id = null;
            }

        }else {
            if(!$request->virtual_assistant_360 && !$request->virtual_assistant_480 && !$request->virtual_assistant_720 && !$request->virtual_assistant_1080 && !$request->description){
                $virtual_ = VirtualAssistant::where('seller_id', $seller->id)->first();
                if($virtual_){
                    $virtual_->delete();
                }
                $seller->virtual_assistant_id = null;
            }else{
                $virtual_assistant = new VirtualAssistant;
                $virtual_assistant->seller_id = $seller->id;
                $virtual_assistant->video = $request->virtual_assistant?$request->virtual_assistant:'';
                $virtual_assistant->description = $request->description;
                $virtual_assistant->save();
                $seller->virtual_assistant_id = $virtual_assistant->id;
    
                if($request->virtual_assistant_360){
                    $virtual_assistant_360 = Upload::where('id', $request->virtual_assistant_360)->first();
    
                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 360;
                    $video->url = $virtual_assistant_360->file_name;
                    $video->file_id = $virtual_assistant_360->id;
                    $video->type = "virtual_video";
                    $video->save();
                }else{
                    $virtual_360 = Video::where('seller_id', $seller->id)->where('name', '360')->where('type', 'virtual_video')->first();
                    if($virtual_360){
                        $virtual_360->delete();
                    }
                }
    
                if($request->virtual_assistant_480){
                    $virtual_assistant_480 = Upload::where('id', $request->virtual_assistant_480)->first();
    
                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 480;
                    $video->url = $virtual_assistant_480->file_name;
                    $video->file_id = $virtual_assistant_480->id;
                    $video->type = "virtual_video";
                    $video->save();
                }else{
                    $virtual_480 = Video::where('seller_id', $seller->id)->where('name', '480')->where('type', 'virtual_video')->first();
                    if($virtual_480){
                        $virtual_480->delete();
                    }
                }
    
                if($request->virtual_assistant_720){
                    $virtual_assistant_720 = Upload::where('id', $request->virtual_assistant_720)->first();
    
                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 720;
                    $video->url = $virtual_assistant_720->file_name;
                    $video->file_id = $virtual_assistant_720->id;
                    $video->type = "virtual_video";
                    $video->save();
                }else{
                    $virtual_720 = Video::where('seller_id', $seller->id)->where('name', '720')->where('type', 'virtual_video')->first();
                    if($virtual_720){
                        $virtual_720->delete();
                    }
                }
    
                if($request->virtual_assistant_1080){
                    $virtual_assistant_1080 = Upload::where('id', $request->virtual_assistant_1080)->first();
    
                    $video = new Video();
                    $video->seller_id = $seller->id;
                    $video->name = 1080;
                    $video->url = $virtual_assistant_1080->file_name;
                    $video->file_id = $virtual_assistant_1080->id;
                    $video->type = "virtual_video";
                    $video->save();
                }else{
                    $virtual_1080 = Video::where('seller_id', $seller->id)->where('name', '1080')->where('type', 'virtual_video')->first();
                    if($virtual_1080){
                        $virtual_1080->delete();
                    }
                }
            }
        }
        
        $seller->save();

        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if ($user->save()) {
            $user->shop->save();
            if ($seller->save()) {
                flash(translate('Seller has been updated successfully'))->success();
                return redirect()->route('sellers.index');
            }
        }

        flash(translate('Something went wrong'))->error();
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
        $seller = Seller::findOrFail($id);

        Shop::where('user_id', $seller->user_id)->delete();

        Product::where('user_id', $seller->user_id)->delete();

        $orders = Order::where('user_id', $seller->user_id)->get();

        foreach ($orders as $key => $order) {
            OrderDetail::where('order_id', $order->id)->delete();
        }

        Order::where('user_id', $seller->user_id)->delete();

        User::destroy($seller->user->id);

        if (Seller::destroy($id)) {
            flash(translate('Seller has been deleted successfully'))->success();
            return redirect()->route('sellers.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_seller_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $seller_id) {
                $this->destroy($seller_id);
            }
        }

        return 1;
    }

    public function show_verification_request($id)
    {
        $seller = Seller::findOrFail($id);
        return view('backend.sellers.verification', compact('seller'));
    }

    public function approve_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 1;
        if ($seller->save()) {

            Cache::forget('verified_sellers_id');
            flash(translate('Seller has been approved successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function reject_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 0;
        $seller->verification_info = null;
        if ($seller->save()) {
            Cache::forget('verified_sellers_id');
            flash(translate('Seller verification request has been rejected successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }


    public function payment_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('backend.sellers.payment_modal', compact('seller'));
    }

    public function profile_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('backend.sellers.profile_modal', compact('seller'));
    }

    public function updateApproved(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        $seller->verification_status = $request->status;
        if ($seller->save()) {
            if($request->status == 1){
                if(!$seller->user->password){
                    $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
                    $password = substr($random, 0, 10);
                    $seller->user->password = Hash::make($password);
                    $seller->user->save();

                    try {
                        $array['view'] = 'mail';
                        $array['subject'] = env('MAIL_FROM_NAME');
                        $array['from'] = env('MAIL_FROM_ADDRESS');
                        $array['email'] = $seller->user->email;
                        $array['password'] = $password;
                        Mail::to($seller->user->email)->queue(new EmailManager($array));
                    } catch (\Throwable $th) {
                        $seller->verification_status = 0;
                        return 0;
                    }
                }
                $seller->isVerified = $request->status;
                $seller->save();
            }
            Cache::forget('verified_sellers_id');
            return 1;
        }
        return 0;
    }

    public function login($id)
    {
        $seller = Seller::findOrFail(decrypt($id));

        $user  = $seller->user;

        auth()->login($user, true);

        return redirect()->route('dashboard');
    }

    public function ban($id)
    {
        $seller = Seller::findOrFail($id);

        if ($seller->user->banned == 1) {
            $seller->user->banned = 0;
            flash(translate('Seller has been unbanned successfully'))->success();
        } else {
            $seller->user->banned = 1;
            flash(translate('Seller has been banned successfully'))->success();
        }

        $seller->user->save();
        return back();
    }
}
