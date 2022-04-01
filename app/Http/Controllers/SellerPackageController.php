<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerPackage;
use App\Models\SellerPackageTranslation;
use App\Models\SellerPackagePayment;
use App\Models\Seller;
use App\Models\Order;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Utility\PayfastUtility;
use Auth;
use Session;
use Carbon\Carbon;
use Validator;

class SellerPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller_packages = SellerPackage::all();
        return view('seller_packages.index',compact('seller_packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seller_packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller_package = new SellerPackage;
        $seller_package->name = $request->name;
        $seller_package->amount = $request->amount;
        $seller_package->product_upload_limit = $request->product_upload_limit;
        $seller_package->duration = $request->duration;
        $seller_package->logo = $request->logo;
        $seller_package->discount = $request->discount;
        $seller_package->discount_type = $request->discount_type;
        $seller_package->type = $request->type;
        if($seller_package->save()){

            $seller_package_translation = SellerPackageTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'seller_package_id' => $seller_package->id]);
            $seller_package_translation->name = $request->name;
            $seller_package_translation->save();

            flash(translate('Package has been inserted successfully'))->success();
            return redirect()->route('seller_packages.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
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
    public function edit(Request $request, $id)
    {
        $lang   = $request->lang;
        $seller_package = SellerPackage::findOrFail($id);
        return view('seller_packages.edit', compact('seller_package','lang'));
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
        $seller_package = SellerPackage::findOrFail($id);
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $seller_package->name = $request->name;
        }
        $seller_package->amount = $request->amount;
        $seller_package->product_upload_limit = $request->product_upload_limit;
        $seller_package->duration = $request->duration;
        $seller_package->logo = $request->logo;
        $seller_package->discount = $request->discount;
        $seller_package->discount_type = $request->discount_type;
        $seller_package->type = $request->type;
        if($seller_package->save()){
            $seller_package_translation = SellerPackageTranslation::firstOrNew(['lang' => $request->lang, 'seller_package_id' => $seller_package->id]);
            $seller_package_translation->name = $request->name;
            $seller_package_translation->save();
            flash(translate('Package has been inserted successfully'))->success();
            return redirect()->route('seller_packages.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller_package = SellerPackage::findOrFail($id);
        foreach ($seller_package->seller_package_translations as $key => $seller_package_translation) {
            $seller_package_translation->delete();
        }
        SellerPackage::destroy($id);
        flash(translate('Package has been deleted successfully'))->success();
        return redirect()->route('seller_packages.index');
    }


    //FrontEnd
    //@index
    public function seller_packages_list()
    {
        $seller_packages = SellerPackage::all();
        return view('seller_packages.frontend.seller_packages_list',compact('seller_packages'));
    }

    public function purchase_package(Request $request)
    {
        $data['seller_package_id'] = $request->seller_package_id;
        $data['payment_method'] = $request->payment_option;

        $request->session()->put('payment_type', 'seller_package_payment');
        $request->session()->put('payment_data', $data);

        $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);

        if($seller_package->amount == 0){
            return $this->purchase_payment_done(Session::get('payment_data'), null);
        }
        elseif (Auth::user()->seller->seller_package != null && $seller_package->product_upload_limit < Auth::user()->seller->seller_package->product_upload_limit){
            flash(translate('You have more uploaded products than this package limit. You need to remove excessive products to downgrade.'))->warning();
            return back();
        }

        if($request->payment_option == 'paypal'){
            $paypal = new PaypalController;
            return $paypal->getCheckout();
        }
        elseif ($request->payment_option == 'stripe') {
            $stripe = new StripePaymentController;
            return $stripe->stripe();
        }
        elseif ($request->payment_option == 'mercadopago') {
            $mercadopago = new MercadopagoController;
            return $mercadopago->paybill();
        }
		elseif ($request->payment_option == 'toyyibpay') {
            $toyyibpay = new ToyyibpayController;
            return $toyyibpay->createbill();
        }
        elseif ($request->payment_option == 'sslcommerz') {
            $sslcommerz = new PublicSslCommerzPaymentController;
            return $sslcommerz->index($request);
        }
        elseif ($request->payment_option == 'instamojo') {
            $instamojo = new InstamojoController;
            return $instamojo->pay($request);
        }
        elseif ($request->payment_option == 'razorpay') {
            $razorpay = new RazorpayController;
            return $razorpay->payWithRazorpay($request);
        }
        elseif ($request->payment_option == 'paystack') {
            $paystack = new PaystackController;
            return $paystack->redirectToGateway($request);
        }
		elseif ($request->payment_option == 'ngenius') {
            $ngenius = new NgeniusController();
            return $ngenius->pay();
        } 
		else if ($request->payment_option == 'iyzico') {
            $iyzico = new IyzicoController();
            return $iyzico->pay();
        }
		else if ($request->payment_option == 'nagad') {
            $nagad = new NagadController();
            return $nagad->getSession();
        } 
		else if ($request->payment_option == 'bkash') {
            $bkash = new BkashController();
            return $bkash->pay();
        }
		elseif ($request->payment_option == 'aamarpay') {
            $aamarpay = new AamarpayController;
            return $aamarpay->index();
        }
		elseif ($request->payment_option == 'mpesa') {
            $mpesa = new MpesaController();
            return $mpesa->pay();
        }
		elseif ($request->payment_option == 'flutterwave') {
            $flutterwave = new FlutterwaveController();
            return $flutterwave->pay();
        }
		elseif ($request->payment_option == 'payfast') {
            $user_id = Auth::user()->id;
            $package_id = $request->seller_package_id;
            $amount = $seller_package->amount;

            return PayfastUtility::create_seller_package_form($user_id, $package_id, $amount);
        }
        
    }

    public function purchase_payment_done($payment_data, $payment){
        $seller = Auth::user()->seller;
        $seller->seller_package_id = Session::get('payment_data')['seller_package_id'];
        $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
        $seller->invalid_at = date('Y-m-d', strtotime( $seller->invalid_at. ' +'. $seller_package->duration .'days'));
        $seller->save();

        $seller_package = new SellerPackagePayment;
        $seller_package->user_id = Auth::user()->id;
        $seller_package->seller_package_id = Session::get('payment_data')['seller_package_id'];
        $seller_package->payment_method = null;
        $seller_package->payment_details = null;
        $seller_package->approval = 1;
        $seller_package->offline_payment = 0;
        $seller_package->reciept = null;
        $seller_package->save();

        flash(translate('Package purchasing successful'))->success();
        return redirect()->route('dashboard');
    }

    public function unpublish_products(Request $request){
        foreach (Seller::all() as $seller) {
            if($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                foreach ($seller->user->products as $product) {
                    $product->published = 0;
                    $product->save();
                }
                $seller->seller_package_id = null;
                $seller->save();
            }
        }
    }

    public function purchase_package_offline(Request $request){
        $seller_package = SellerPackage::findOrFail($request->package_id);

        if (Auth::user()->seller->seller_package != null && $seller_package->product_upload_limit < Auth::user()->seller->seller_package->product_upload_limit){
            flash(translate('You have more uploaded products than this package limit. You need to remove excessive products to downgrade.'))->warning();
            return redirect()->route('seller_packages_list');
        }
        $seller_package = new SellerPackagePayment;
        $seller_package->user_id = Auth::user()->id;
        $seller_package->seller_package_id = $request->package_id;
        $seller_package->payment_method = $request->payment_option;
        $seller_package->payment_details = $request->trx_id;
        $seller_package->approval = 0;
        $seller_package->offline_payment = 1;
        $seller_package->reciept = $request->photo;
        $seller_package->save();
        flash(translate('Offline payment has been done. Please wait for response.'))->success();
        return redirect()->route('seller.products');
    }

    //Api
    //@index
    public function seller_packages_list_api()
    {
        $seller_packages = SellerPackage::paginate(15);
        return response()->json($seller_packages);
    }

    public function purchase_package_api(Request $request)
    {   
        // $data['payment_method'] = $request->payment_option;
        $type = [
            "jpg"=>"image",
            "jpeg"=>"image",
            "png"=>"image",
            "svg"=>"image",
            "webp"=>"image",
            "gif"=>"image",
        ];
        
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['seller_package_id'] = $request->seller_package_id;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'seller_package_id' => 'required',
            'identity_card' => 'required'
        ]);

        $upload_identity_card = null;
        $upload_business_license = null;
        
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 401);
        }else{
            $identity_card = $request->identity_card;
            $business_license = $request->business_license;

            $identity_card_name = $request->identity_card_name;
            $business_license_name = $request->business_license_name;

            if($identity_card && $identity_card_name || $identity_card != "null" && $identity_card_name != "null"){
                $real_identity_card = base64_decode($identity_card);
                $dir_identity_card = public_path('uploads/all');
                $full_path_identity_card = "$dir_identity_card/$identity_card_name";
                $file_put_identity_card = file_put_contents($full_path_identity_card, $real_identity_card);
                
                if ($file_put_identity_card == false) {
                    return response()->json([
                        'result' => false,
                        'message' => "File uploading error"
                    ]);
                }
            
                $upload_identity_card = new Upload;
                $extension_identity_card = strtolower(File::extension($full_path_identity_card));
                $size_identity_card = File::size($full_path_identity_card);
                
                if (!isset($type[$extension_identity_card])) {
                    unlink($full_path_identity_card);
                    return response()->json([
                        'result' => false,
                        'message' => "Only image can be uploaded"
                    ]);
                }

                $upload_identity_card->file_original_name = null;
                $arr_identity_card = explode('.', File::name($full_path_identity_card));
                
                for ($i = 0; $i < count($arr_identity_card) - 1; $i++) {
                    if ($i == 0) {
                        $upload_identity_card->file_original_name .= $arr_identity_card[$i];
                    } else {
                        $upload_identity_card->file_original_name .= "." . $arr_identity_card[$i];
                    }
                }
                
                //unlink and upload again with new name
                unlink($full_path_identity_card);
                $newFileName_identity_card = rand(10000000000, 9999999999) . date("YmdHis") . "." . $extension_identity_card;
                $newFullPath_identity_card = "$dir_identity_card/$newFileName_identity_card";
                $file_put_identity_card = file_put_contents($newFullPath_identity_card, $real_identity_card);
                
                if ($file_put_identity_card == false) {
                    return response()->json([
                        'result' => false,
                        'message' => "Uploading error"
                    ]);
                }

                $newPath_identity_card = "uploads/all/$newFileName_identity_card";
                
                if (env('FILESYSTEM_DRIVER') == 's3') {
                    Storage::disk('s3')->put($newPath_identity_card, file_get_contents(base_path('public/') . $newPath_identity_card));
                    Storage::disk('s3')->put($newPath_business_license, file_get_contents(base_path('public/') . $newPath_business_license));
                    unlink(base_path('public/') . $newPath_identity_card);
                    unlink(base_path('public/') . $newPath_business_license);
                }

                $upload_identity_card->extension = $extension_identity_card;
                $upload_identity_card->file_original_name = $identity_card_name;
                $upload_identity_card->file_name = $newPath_identity_card;
                $upload_identity_card->user_id = Auth::user()->id;
                $upload_identity_card->type = $type[$upload_identity_card->extension];
                $upload_identity_card->file_size = $size_identity_card;
            }

            if($business_license && $business_license_name || $business_license != "null" && $business_license_name != "null"){
                $real_business_license = base64_decode($business_license);
                $dir_business_license = public_path('uploads/all');
                
                $full_path_business_license = "$dir_business_license/$business_license_name";
                $file_put_business_license = file_put_contents($full_path_business_license, $real_business_license);

                if ($file_put_business_license == false) {
                    return response()->json([
                        'result' => false,
                        'message' => "File uploading error"
                    ]);
                }

                $upload_business_license = new Upload;
                $extension_business_license = strtolower(File::extension($full_path_business_license));
                $size_business_license = File::size($full_path_business_license);

                if (!isset($type[$extension_business_license])) {
                    unlink($full_path_business_license);
                    return response()->json([
                        'result' => false,
                        'message' => "Only image can be uploaded"
                    ]);
                }

                $upload_business_license->file_original_name = null;
                $arr_business_license = explode('.', File::name($full_path_business_license));

                for ($i = 0; $i < count($arr_business_license) - 1; $i++) {
                    if ($i == 0) {
                        $upload_business_licens->file_original_name .= $arr_business_license[$i];
                    } else {
                        $upload_business_licens->file_original_name .= "." . $arr_business_license[$i];
                    }
                }

                unlink($full_path_business_license);
                $newFileName_business_license = rand(10000000000, 9999999999) . date("YmdHis") . "." . $extension_business_license;
                $newFullPath_business_license = "$dir_business_license/$newFileName_business_license";
                $file_put_business_license = file_put_contents($newFullPath_business_license, $real_business_license);
                $newPath_business_license = "uploads/all/$newFileName_business_license";
            
                if (env('FILESYSTEM_DRIVER') == 's3') {
                    Storage::disk('s3')->put($newPath_business_license, file_get_contents(base_path('public/') . $newPath_business_license));
                    unlink(base_path('public/') . $newPath_business_license);
                }

                $upload_business_license->extension = $extension_identity_card;
                $upload_business_license->file_original_name = $business_license_name;
                $upload_business_license->file_name = $newPath_identity_card;
                $upload_business_license->user_id = Auth::user()->id;
                $upload_business_license->type = $type[$upload_business_license->extension];
                $upload_business_license->file_size = $size_identity_card;
            }
            
            // if($request->file('identity_card')){
            //     $extension_ = strtolower($request->file('identity_card')->getClientOriginalExtension());
            //     $identity_card = $request->file('identity_card')->store('uploads/all');
            //     $identity_card_size = $request->file('identity_card')->getSize();
            //     $original_name_ = $request->file('identity_card')->getClientOriginalName();

            //     $upload_identity_card = new Upload;
            //     $upload_identity_card->extension = $extension_;
            //     $upload_identity_card->file_original_name = $original_name_;
            //     $upload_identity_card->file_name = $identity_card;
            //     $upload_identity_card->user_id = Auth::user()->id;
            //     $upload_identity_card->type = $type[$upload_identity_card->extension];
            //     $upload_identity_card->file_size = $identity_card_size;
            // }
            // if($request->file('business_license')){
            //     $extension__ = strtolower($request->file('business_license')->getClientOriginalExtension());
            //     $business_license = $request->file('business_license')->store('uploads/all');
            //     $business_license_size = $request->file('business_license')->getSize();
            //     $original_name__ = $request->file('business_license')->getClientOriginalName();

            //     $upload_business_license = new Upload;
                
            //     $upload_business_license->extension = $extension__;
            //     $upload_business_license->file_original_name = $original_name__;
            //     $upload_business_license->file_name = $business_license;
            //     $upload_business_license->user_id = Auth::user()->id;
            //     $upload_business_license->type = $type[$upload_business_license->extension];
            //     $upload_business_license->file_size = $business_license_size;
            // }
        }
        
        $seller_package = SellerPackage::findOrFail($data['seller_package_id']);

        // if(Auth::user()->seller){
        //     if (Auth::user()->seller->seller_package != null && $seller_package->product_upload_limit < Auth::user()->seller->seller_package->product_upload_limit){
        //         return response()->json([
        //             'success' => false,
        //             'message' => translate('You have more uploaded products than this package limit. You need to remove excessive products to downgrade.')
        //         ]); 
        //     }
        // }

        $upload_identity_card->save();
        if($business_license && $business_license_name){
            $upload_business_license->save();
            $data['business_license'] = $upload_business_license->id;
        }

        $data['identity_card'] = $upload_identity_card->id;

        if(strtotime(Auth::user()->seller->invalid_at) > strtotime(date('Y-m-d'))){
            DB::table('users')
            ->where('id', Auth::user()->id)
            ->update([
                'identity_card' => $upload_identity_card->id,
                'business_license' => $upload_business_license?$upload_business_license->id:null,
                'started_at' => Carbon::now(),
            ]);
        }else {
            DB::table('users')
            ->where('id', Auth::user()->id)
            ->update([
                'identity_card' => $upload_identity_card->id,
                'business_license' => $upload_business_license?$upload_business_license->id:null
            ]);
        }
        
        $seller = Seller::where('user_id', Auth::user()->id)->first();
        
        if(!$seller){
            DB::table('sellers')
            ->where('user_id', Auth::user()->id)
            ->insert([
                'user_id' => Auth::user()->id,
            ]);
        }
        return $this->purchase_payment_done_api($data, null);
    }

    public function purchase_payment_done_api($payment_data, $payment){
        $seller = Auth::user()->seller;
        $seller->seller_package_id = $payment_data['seller_package_id'];
        $seller_package = SellerPackage::findOrFail($payment_data['seller_package_id']);

        if($seller_package->type == "seller"){
            $package_type = "seller";
        }elseif($seller_package->type == "pro"){
            $package_type = "pro";
        }

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update([
                'user_type' => $package_type,
                'finished_at' => $seller->invalid_at,
            ]);
        if(strtotime(Auth::user()->seller->invalid_at) > strtotime(date('Y-m-d'))){
            $seller->invalid_at = date('Y-m-d', strtotime( $seller->invalid_at. ' +'. $seller_package->duration .'days'));
            $seller->save();

            $seller_package = new SellerPackagePayment;
            $seller_package->user_id = Auth::user()->id;
            $seller_package->seller_package_id = $payment_data['seller_package_id'];
            $seller_package->payment_method = null;
            $seller_package->payment_details = null;
            $seller_package->approval = 1;
            $seller_package->offline_payment = 0;
            $seller_package->reciept = null;
            $seller_package->save();

            return response()->json([
                'success' => true,
                'message' => translate('Package extended successful')
            ]); 
        }else {
            $seller->invalid_at = date('Y-m-d', strtotime( $seller->invalid_at. ' +'. $seller_package->duration .'days'));
            $seller->save();
    
            $seller_package = new SellerPackagePayment;
            $seller_package->user_id = Auth::user()->id;
            $seller_package->seller_package_id = $payment_data['seller_package_id'];
            $seller_package->payment_method = null;
            $seller_package->payment_details = null;
            $seller_package->approval = 1;
            $seller_package->offline_payment = 0;
            $seller_package->reciept = null;
            $seller_package->save();
            
            return response()->json([
                'success' => true,
                'message' => translate('Package purchasing successful')
            ]); 
        }
    }
}
