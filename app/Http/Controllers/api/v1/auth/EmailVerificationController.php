<?php

namespace App\Http\Controllers\api\v1\auth;

use Illuminate\Http\Request;
use App\Traits\Users\Verification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    use Verification;
    //

    public function reset_password_request(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'otp' => ['required', 'string'],
            'new_password' => ['required', 'string'],
            're_new_password' => ['required', 'string'],
        ]);
    }

    public function send_otp(Request $request){

    }
}
