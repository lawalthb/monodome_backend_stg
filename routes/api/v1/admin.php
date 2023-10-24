<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\admin\RoleController;
use App\Http\Controllers\Api\v1\Admin\AgentController;
use App\Http\Controllers\Api\v1\Admin\BrokerController;
use App\Http\Controllers\Api\v1\Admin\DriverController;
use App\Http\Controllers\Api\v1\Admin\SettingController;
use App\Http\Controllers\Api\v1\Admin\CustomerController;
use App\Http\Controllers\Api\v1\Admin\AdminAuthController;
use App\Http\Controllers\api\v1\admin\DashboardController;
use App\Http\Controllers\Api\v1\admin\LoadBoardController;
use App\Http\Controllers\api\v1\admin\PermissionController;
use App\Http\Controllers\api\v1\admin\DriverManagerController;
use App\Http\Controllers\api\v1\admin\ShippingCompanyController;
use App\Http\Controllers\api\v1\admin\SpecializedShipmentController;

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
        //setting route group


        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index']);
            Route::get('/{id}', [DashboardController::class, 'show']);
            Route::delete('/{id}', [DashboardController::class, 'delete']);
            Route::post('/store', [DashboardController::class, 'store']);
            Route::post('/update/{id}', [DashboardController::class, 'update']);

        });

        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [SettingController::class, 'index']);
            Route::get('/{id}', [SettingController::class, 'show']);
            Route::delete('/{id}', [SettingController::class, 'delete']);
            Route::post('/store', [SettingController::class, 'store']);
            Route::post('/update/{id}', [SettingController::class, 'update']);

        });



    //roles and permission Route group
    Route::group(['prefix' => 'roles'], function () {

        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{role}', [RoleController::class, 'show']);
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::delete('/{role}', [RoleController::class, 'destroy']);

        Route::get('permissions', [PermissionController::class, 'index']);
        Route::post('permissions', [PermissionController::class, 'store']);
        Route::get('permissions/{permission}', [PermissionController::class, 'show']);
        Route::put('permissions/{permission}', [PermissionController::class, 'update']);
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy']);
    });


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
    Route::group(['prefix' => 'driver-manager'], function () {
        Route::get('/', [DriverManagerController::class, 'index']);
        Route::post('/store', [DriverManagerController::class, 'store']);
        Route::get('/search', [DriverManagerController::class, 'search']);
        Route::post('/status/{id}', [DriverManagerController::class, 'setStatus']);
        Route::get('/show/{id}', [DriverManagerController::class, 'show']);
        Route::post('/update/{id}', [DriverManagerController::class, 'update']);
        Route::delete('/destroy/{id}', [DriverManagerController::class, 'destroy']);
    });

    // shipping-company route group
    Route::group(['prefix' => 'shipping-company'], function () {
        Route::get('/', [ShippingCompanyController::class, 'index']);
        Route::post('/store', [ShippingCompanyController::class, 'store']);
        Route::get('/search', [ShippingCompanyController::class, 'search']);
        Route::post('/status/{id}', [ShippingCompanyController::class, 'setStatus']);
        Route::get('/show/{id}', [ShippingCompanyController::class, 'show']);
        Route::post('/update/{id}', [ShippingCompanyController::class, 'update']);
        Route::delete('/destroy/{id}', [ShippingCompanyController::class, 'destroy']);
    });


    // load-board route group
    Route::group(['prefix' => 'load-board'], function () {

    Route::get('/', [LoadBoardController::class, 'index']);
    Route::post('/', [LoadBoardController::class, 'store']);
    Route::get('/{id}', [LoadBoardController::class, 'show']);
    Route::post('/{loadBulk}', [LoadBoardController::class, 'update']);
    Route::delete('/{id}', [LoadBoardController::class, 'destroy']);

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


     // driver route group
     Route::group(['prefix' => 'customer'], function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/store', [CustomerController::class, 'store']);
        Route::get('/search', [CustomerController::class, 'search']);
        Route::post('/status/{id}', [CustomerController::class, 'setStatus']);
        Route::get('/show/{id}', [CustomerController::class, 'show']);
        Route::post('/update/{id}', [CustomerController::class, 'update']);
        Route::delete('/destroy/{id}', [CustomerController::class, 'destroy']);
    });


      // specialized-shipment route group
      Route::group(['prefix' => 'specialized-shipment'], function () {
        Route::get('/', [SpecializedShipmentController::class, 'index']);
        Route::post('/store', [SpecializedShipmentController::class, 'store']);
        Route::get('/search', [SpecializedShipmentController::class, 'search']);
        Route::post('/status/{id}', [SpecializedShipmentController::class, 'setStatus']);
        Route::get('/show/{id}', [SpecializedShipmentController::class, 'show']);
       // Route::post('/update/{id}', [SpecializedShipmentController::class, 'update']);
       // Route::delete('/destroy/{id}', [SpecializedShipmentController::class, 'destroy']);
    });



});

});
