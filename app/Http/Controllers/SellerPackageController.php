<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerPackage;
use App\Models\SellerPackageTranslation;
use App\Models\SellerPackagePayment;
use App\Models\Seller;
use App\Models\Member;
use App\Models\Order;
use App\Models\Upload;
use App\Models\User;
use App\Models\Shop;
use App\Models\VirtualAssistant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Utility\PayfastUtility;
use Illuminate\Support\Str;
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
        $seller_package->duration = $request->duration;
        $seller_package->logo = $request->logo;
        $seller_package->price = $request->price;
        if($seller_package->save()){
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
        $seller_package->duration = $request->duration;
        $seller_package->logo = $request->logo;
        $seller_package->price = $request->price;
        if($seller_package->save()){
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
        $seller_packages = SellerPackage::get();
        foreach($seller_packages as &$package){
            $logo = Upload::where('id', $package->logo)->first();
            $package->logo = $logo?$logo->file_name:'';
        }
        return response()->json($seller_packages);
    }

    public function get_package_detail($id){
        $seller_package = SellerPackage::find($id);
        $logo = Upload::where('id', $seller_package->logo)->first();
        $seller_package->logo = $logo?$logo->file_name:'';
        return response()->json($seller_package);
    }

    public function purchase_package_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'package_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $data['email'] = Auth::user()->email;
        $data['package_id'] = $request->package_id;

        $member = Member::where('user_id', Auth::user()->id)->first();
        
        if(!$member){
            $member = new Member;
            $member->user_id = Auth::user()->id;
            $member->started_at = Carbon::now();
            $member->package_id = $data['package_id'];
            $member->save();
        }else{
            $member->started_at = Carbon::now();
            $member->package_id = $data['package_id'];
            $member->save();
        }
        return $this->purchase_payment_done_api($data, null);
    }

    public function purchase_payment_done_api($payment_data, $payment){
        $member = Auth::user()->member;
        $member->package_id = $payment_data['package_id'];
        $package = SellerPackage::findOrFail($payment_data['package_id']);

        if(strtotime(Auth::user()->member->invalid_at) > strtotime(date('Y-m-d'))){
            $member->invalid_at = date('Y-m-d', strtotime( $member->invalid_at. ' +'. $package->duration .'days'));
            $member->save();

            $seller_package = new SellerPackagePayment;
            $seller_package->user_id = Auth::user()->id;
            $seller_package->seller_package_id = $payment_data['package_id'];
            $seller_package->payment_method = null;
            $seller_package->payment_details = null;
            $seller_package->approval = 1;
            $seller_package->offline_payment = 0;
            $seller_package->reciept = null;
            $seller_package->save();
            $message = "Package extended successful";
        }else {
            $member->invalid_at = date('Y-m-d', strtotime( $member->invalid_at. ' +'. $package->duration .'days'));
            $member->save();
    
            $seller_package = new SellerPackagePayment;
            $seller_package->user_id = Auth::user()->id;
            $seller_package->seller_package_id = $payment_data['package_id'];
            $seller_package->payment_method = null;
            $seller_package->payment_details = null;
            $seller_package->approval = 1;
            $seller_package->offline_payment = 0;
            $seller_package->reciept = null;
            $seller_package->save();
            $message = "Package purchasing successfull";
        }

        $user = User::where('id', Auth::user()->id)->first();
        $user->user_type = "member";
        $user->save();

        return response()->json([
            'success' => true,
            'message' => translate($message)
        ]);
    }
}
