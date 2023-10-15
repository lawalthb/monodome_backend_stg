<?php

use Illuminate\Support\Facades\Route;



Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => 'return-json'], function () {

    Route::get('/', function () {

         return response()->json(['message' =>"v1 admin Server is up and running"]);
        //return "here is the user";
    });

        // user registration namespace
        Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
            Route::post('/login', [AuthController::class, 'login']);

            Route::post('/forgot-password', [EmailVerificationController::class, 'reset_password_request']);
            Route::post('/send-otp', [EmailVerificationController::class, 'send_otp']);
            Route::post('/verify-otp', [EmailVerificationController::class, 'otp_verification_submit']);
            Route::post('/check-email', [EmailVerificationController::class, 'check_if_email_exist']);
        });

});
