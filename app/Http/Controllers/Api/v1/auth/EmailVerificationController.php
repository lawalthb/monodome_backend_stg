<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Models\User;
use App\Traits\Verification;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    use Verification, ApiStatusTrait;

    public function reset_password_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'otp' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'], // Make sure to add 'confirmed'
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        // Verify OTP (you need to implement this part)
        if (!$this->verifyOTPCode($request->email, $request->otp)) {
            return $this->error('', 'Invalid OTP', 422);
        }

        // Update password
        $user = User::where("email", $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->success('', 'Password reset successful');
    }

    public function send_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        if (!$this->email_exist($request)) {
            return $this->error('', "Email address couldn't be found", 422);
        }

        if ($this->sendVerificationCode($request->email)) {
            return $this->success('', 'Code sent to your email or phone number');
        } else {
            return $this->error('', 'Code sending error, try again', 422);
        }
    }

    public function email_exist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $user = User::where("email", $request->email)->first();

        return $user ? true : false;
    }


    public function check_if_email_exist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $user = User::where("email", $request->email)->first();

        if ($user) {
            return $this->success('', 'Email Exist');
        } else {
            return $this->error('', "Email address doesn't Exist", 422);
        }
    }

    public function otp_verification_submit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'otp' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        // Verify OTP (you need to implement this part)
        if (!$this->verifyOTPCode($request->email, $request->otp)) {
            return $this->error('', 'Invalid OTP', 422);
        }

        return $this->success('', 'OTP Code is valid!');
    }
}
