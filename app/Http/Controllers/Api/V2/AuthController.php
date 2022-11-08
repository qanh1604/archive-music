<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\OTPVerificationController;
use App\Models\BusinessSetting;
use App\Models\Customer;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Address;
use App\Models\Playlist;
use App\Models\Follower;
use App\Models\SellerPackage;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\EmailManager;
use App\Notifications\AppEmailVerificationNotification;
use Validator;
use Hash;
use Mail;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        if (User::where('email', $request->email)->first() != null) {
            return response()->json([
                'success' => false,
                'message' => translate('Người dùng đã tồn tại')
            ], 201);
        }

        $random = str_shuffle('ABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        $code = substr($random, 0, 6);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verification_code' => $code,
            'role' => 4,
            'status' => 0
        ]);

        try {
            $array['view'] = 'mail';
            $array['subject'] = env('MAIL_FROM_NAME');
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['email'] = $request->email;
            $array['code'] = $code;
            Mail::to($request->email)->queue(new EmailManager($array));
        } catch (\Exception $e) {
            dd($e);
        }

        $user->save();

        $user->createToken('tokens')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => translate('Registration Successful. Please verify and log in to your account.'),
            'user_id' => $user->id
        ], 201);
    }

    public function signupPhone(Request $request)
    {
        $user_check = User::where('phone', $request->email_or_phone)->first();
        if ($user_check != null) {
            return response()->json([
                'success' => false,
                'message' => translate('User already exists.'),
                'user_id' => 0
            ], 201);
        }

        $user = new User([
            'name' => $request->name,
            'phone' => $request->email_or_phone,
            'verification_code' => rand(100000, 999999),
            'address' => $request->address,
            'country' => Country::where('id', $request->country_id)->first()->name,
            'city' => City::where('id', $request->city_id)->first()->name,
            'state' => State::where('id', $request->state_id)->first()->name,
            'poscal_code' => $request->poscal_code,
        ]);
        
        // $otpController = new OTPVerificationController();
        // $otpController->send_code($user);

        $user->save();

        $address = new Address;
        $address->user_id = $user->id;
        $address->address = $user->address;
        $address->country_id = $request->country_id;
        $address->city_id = $request->city_id;
        $address->state_id = $request->state_id;
        $address->postal_code = $user->postal_code?$user->postal_code:null;
        $address->phone = $user->phone;
        $address->set_default = 1;

        $address->save();

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();

        //create token
        $user->createToken('tokens')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => translate('Registration Successful. Please verify and log in to your account.'),
            'user_id' => $user->id
        ], 201);
    }

    public function activeByOTP(Request $request){
        $user = User::where('id', $request->user_id)->first();

        if ($request->otp == "0000") {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_code = null;
            $user->save();
            return $this->loginSuccess($user);
        } else {
            return response()->json([
                'success' => false,
                'message' => translate('Code does not match, you can request for resending the code'),
            ], 200);
        }
    }

    public function resendCode(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        $random = str_shuffle('ABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        $code = substr($random, 0, 6);
        $user->verification_code = $code;

        try {
            $array['view'] = 'mail';
            $array['subject'] = env('MAIL_FROM_NAME');
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['email'] = $user->email;
            $array['code'] = $code;
            Mail::to($user->email)->queue(new EmailManager($array));
        } catch (\Exception $e) {
            dd($e);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => translate('Verification code is sent again'),
        ], 200);
    }

    public function confirmCode(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_code = null;
            $user->status = 1;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => translate('Your account is now verified.Please login'),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => translate('Code does not match, you can request for resending the code'),
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ]);
        }else{
            $user = User::where('email', $request->email)->first();
            if($user){
                if (Hash::check($request->password, $user->password)) {
                    if ($user->email_verified_at == null) {
                        return response()->json(['message' => translate('Please verify your account'), 'user' => $user->id], 401);
                    }
                    return $this->loginSuccess($user);
                }
                else {
                    return response()->json(['result' => false, 'message' => translate('Sai mật khẩu'), 'user' => null], 401);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản không tồn tại',
                ]); 
            }
        }
    }

    public function loginOtp(Request $request)
    {
        /*$request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);*/

        if(!$request->email){
            return response()->json(['result' => false, 'message' => translate('User not found'), 'user' => null], 401);
        }

        $delivery_boy_condition = $request->has('user_type') && $request->user_type == 'delivery_boy';
        
        if ($delivery_boy_condition) {
            $user = User::whereIn('user_type', ['delivery_boy'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        } else {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        }

        if (!$delivery_boy_condition) {
            if (\App\Utility\PayhereUtility::create_wallet_reference($request->identity_matrix) == false) {
                return response()->json(['result' => false, 'message' => 'Identity matrix error', 'user' => null], 401);
            }
        }

        if ($user != null) {
            return response()->json([
                'success' => true,
                'message' => translate('Login success'),
                'user_id' => $user->id
            ], 201);
        } else {
            return response()->json(['success' => false, 'message' => translate('User not found'), 'user' => null], 401);
        }
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => translate('Successfully logged out')
        ]);
    }

    public function socialLogin(Request $request)
    {
        $existingUserByProviderId = User::where('provider_id',$request->provider)->first();

        if ($existingUserByProviderId) {
            return $this->loginSuccess($existingUserByProviderId);
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'provider_id' => $request->provider,
                'email_verified_at' => Carbon::now()
            ]);
            $user->save();
            //test
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
        }
        return $this->loginSuccess($user);
    }

    protected function loginSuccess($user)
    {
        $token = $user->createToken('API Token')->plainTextToken;
        $member = Member::where('user_id', $user->id)->first();
        return response()->json([
            'result' => true,
            'message' => translate('Successfully logged in'),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => null,
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 4,
                'avatar' => $user->avatar,
                'avatar_original' => api_asset($user->avatar_original),
                'phone' => $user->phone,
                'is_member' => Member::where('user_id', $user->id)->exists() ? 1 : 0,
                'total_playlist' => Playlist::where('user_id', $user->id)->count(),
                'following' => Follower::where('user_id', $user->id)->count(),
                'follower' => Follower::where('artist_id', $user->id)->count(),
                'current_package' => $member ? $member->package->name : "Free"
            ]
        ]);
    }
}
