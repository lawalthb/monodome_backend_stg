<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\auth\AuthController;
// use App\Http\Controllers\api\v1\Customers\LoadTypeController;
use App\Http\Controllers\api\v1\Customers\LoadTypeController;
use App\Http\Controllers\api\v1\Customers\LoadPackageController;
use App\Http\Controllers\api\v1\auth\EmailVerificationController;

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => 'return-json'], function () {

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

    Route::group(['prefix' => 'auth', 'namespace' => 'auth', 'middleware' => 'auth:api'], function () {
        Route::get('/profile', [AuthController::class, 'me']);
        Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    });

    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {

        //load type route
        Route::get('/load-types', [LoadTypeController::class, 'index']);
        Route::post('/load-types', [LoadTypeController::class, 'store']);
        Route::get('/load-types/{id}', [LoadTypeController::class, 'show']);
        Route::post('/load-types/{id}', [LoadTypeController::class, 'update']);
        Route::delete('/load-types/{id}', [LoadTypeController::class, 'destroy']);

        // load package route
        Route::get('/load-package', [LoadPackageController::class, 'index']);
        Route::post('/load-package', [LoadPackageController::class, 'store']);
        Route::get('/load-package/{id}', [LoadPackageController::class, 'show']);
        Route::post('/load-package/{id}', [LoadPackageController::class, 'update']);
        Route::delete('/load-package/{id}', [LoadPackageController::class, 'destroy']);
    });
});
