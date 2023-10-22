<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Admin\AgentController;
use App\Http\Controllers\Api\v1\Admin\AdminAuthController;
use App\Http\Controllers\Api\v1\Admin\BrokerController;
use App\Http\Controllers\Api\v1\Admin\DriverController;

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1/admin', 'middleware' => 'return-json'], function () {

    Route::get('/', function () {

        return response()->json(['message' => "v1 admin Server is up and running"]);
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


    Route::group(['middleware' => ['auth:api', 'superadmin'] ], function () {

    // agent route group
    Route::group(['prefix' => 'agent'], function () {

        Route::get('/', [AgentController::class, 'index']);
        Route::post('/store', [AgentController::class, 'store']);
        Route::get('/search', [AgentController::class, 'search']);
        Route::post('/status/{id}', [AgentController::class, 'setStatus']);
        Route::get('/show/{id}', [AgentController::class, 'show']);
        Route::post('/update/{id}', [AgentController::class, 'update']);
        Route::delete('/destroy/{id}', [AgentController::class, 'destroy']);
    });


      // driver route group
      Route::group(['prefix' => 'driver'], function () {
        Route::get('/', [DriverController::class, 'index']);
        Route::post('/store', [DriverController::class, 'store']);
        Route::get('/search', [DriverController::class, 'search']);
        Route::post('/status/{id}', [DriverController::class, 'setStatus']);
        Route::get('/show/{id}', [DriverController::class, 'show']);
        Route::post('/update/{id}', [DriverController::class, 'update']);
        Route::delete('/destroy/{id}', [DriverController::class, 'destroy']);
    });


      // driver route group
      Route::group(['prefix' => 'broker'], function () {
        Route::get('/', [BrokerController::class, 'index']);
        Route::post('/store', [BrokerController::class, 'store']);
        Route::get('/search', [BrokerController::class, 'search']);
        Route::post('/status/{id}', [BrokerController::class, 'setStatus']);
        Route::get('/show/{id}', [BrokerController::class, 'show']);
        Route::post('/update/{id}', [BrokerController::class, 'update']);
        Route::delete('/destroy/{id}', [BrokerController::class, 'destroy']);
    });



});

});
