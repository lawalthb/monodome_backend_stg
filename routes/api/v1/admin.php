<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Admin\AdminAuthController;



Route::group(['namespace' => 'api\v1', 'prefix' => 'v1/admin', 'middleware' => 'return-json'], function () {

    Route::get('/', function () {

         return response()->json(['message' =>"v1 admin Server is up and running"]);
        //return "here is the user";
    });

        // admin registration namespace
        Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
            Route::post('/login', [AdminAuthController::class, 'login']);

            Route::post('/forgot-password', [AdminAuthController::class, 'reset_password_request']);
            Route::post('/send-otp', [AdminAuthController::class, 'send_otp']);
            Route::post('/verify-otp', [AdminAuthController::class, 'otp_verification_submit']);
            Route::post('/check-email', [AdminAuthController::class, 'check_if_email_exist']);
        });

});
