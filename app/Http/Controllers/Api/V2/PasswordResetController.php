<?php

namespace App\Http\Controllers\Api\V2;

use App\Notifications\AppEmailVerificationNotification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;
use Illuminate\Support\Str;
use App\Mail\EmailManager;
use App\Http\Controllers\OTPVerificationController;
use Mail;
use Hash;

class PasswordResetController extends Controller
{
    public function forgetRequest(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => translate('User is not found')], 404);
        }

        if ($user) {
            $random = str_shuffle('ABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
            $code = substr($random, 0, 6);
            $user->verification_code = $code;
            
            try {
                $array['view'] = 'mail';
                $array['subject'] = env('MAIL_FROM_NAME');
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['email'] = $request->email;
                $array['code'] = $code;
                Mail::to($request->email)->queue(new EmailManager($array));
            } catch (\Exception $e) {
            }

            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => translate('A code is sent')
        ], 200);
    }

    public function confirmReset(Request $request)
    {
        $user = User::where('verification_code', $request->verification_code)->first();

        if ($user != null) {
            $user->verification_code = null;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'success' => true,
                'message' => translate('Your password is reset.Please login'),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => translate('No user is found'),
            ], 200);
        }
    }

    public function resendCode(Request $request)
    {
        if ($request->verify_by == 'email') {
            $user = User::where('email', $request->email_or_phone)->first();
        } else {
            $user = User::where('phone', $request->email_or_phone)->first();
        }


        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => translate('User is not found')], 404);
        }

        $user->verification_code = rand(100000, 999999);
        $user->save();

        if ($request->verify_by == 'email') {
            $user->notify(new AppEmailVerificationNotification());
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }



        return response()->json([
            'success' => true,
            'message' => translate('A code is sent again'),
        ], 200);
    }
}
