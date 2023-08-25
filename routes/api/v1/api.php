<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\auth\AuthController;
use App\Http\Controllers\api\v1\auth\EmailVerificationController;

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1'], function () {


    // user registration namespace
    Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/social-login', [AuthController::class, 'handleProviderCallback']);

        Route::post('/forgot-password', [EmailVerificationController::class, 'reset_password_request']);
        Route::post('/send-otp', [EmailVerificationController::class, 'send_otp']);
        Route::post('/verify-otp', [EmailVerificationController::class, 'otp_verification_submit']);
        Route::post('/check-email', [EmailVerificationController::class, 'check_if_email_exist']);

    });

    Route::group(['prefix' => 'customer', 'middleware'=>'auth:api'], function () {

        Route::get('/profile', [AuthController::class, 'me']);
        Route::post('/update-profile', [AuthController::class, 'updateProfile']);

});

});
