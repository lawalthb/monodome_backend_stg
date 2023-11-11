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
use App\Http\Controllers\api\v1\admin\ManageUserController;
use App\Http\Controllers\api\v1\admin\PermissionController;
use App\Http\Controllers\api\v1\admin\DriverManagerController;
use App\Http\Controllers\api\v1\admin\ShippingCompanyController;
use App\Http\Controllers\Api\v1\Admin\Support\SupportController;
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
        Route::get('/is-login', [AdminAuthController::class, 'isLogin']);
        //setting route group
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index']);
            Route::get('/{id}', [DashboardController::class, 'show']);
            Route::delete('/{id}', [DashboardController::class, 'delete']);
            Route::post('/store', [DashboardController::class, 'store']);
            Route::post('/update/{id}', [DashboardController::class, 'update']);

        });

        Route::group(['prefix' => 'user'], function () {

        Route::get('/', [ManageUserController::class, 'index']);
        Route::post('/', [ManageUserController::class, 'store']);
        Route::get('/{id}', [ManageUserController::class, 'show']);
        Route::delete('/{id}', [ManageUserController::class, 'delete']);
        Route::post('/update/{id}', [ManageUserController::class, 'update']);
        Route::get('/user-with-role', [ManageUserController::class, 'user_role_auth']);
        Route::get('/user-with-role/{user}', [ManageUserController::class, 'user_role']);
        Route::post('/change-password/{user}', [ManageUserController::class, 'change_password']);
    });

        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [SettingController::class, 'index']);
            Route::get('/{id}', [SettingController::class, 'show']);
            Route::delete('/{id}', [SettingController::class, 'delete']);
            Route::post('/store', [SettingController::class, 'store']);
            Route::post('/update/{id}', [SettingController::class, 'update']);

        });


        Route::group(['prefix' => 'price'], function () {
            Route::get('/', [SettingController::class, 'price']);
            Route::get('/distance', [SettingController::class, 'distance']);
            Route::delete('/distance/{id}', [SettingController::class, 'deleteDistance']);
            Route::delete('/{id}', [SettingController::class, 'deletePrice']);
            Route::post('/store', [SettingController::class, 'store']);
            Route::post('/create-price', [SettingController::class, 'createPrice']);
            Route::post('/create-distance', [SettingController::class, 'storeDistance']);
            Route::post('/update/{id}', [SettingController::class, 'update']);

        });


        Route::group(['prefix' => 'support', 'middleware' => 'auth:api'], function () {

            Route::get('/get', [SupportController::class, 'index']);
            Route::get('/pending-ticket', [SupportController::class, 'pendingTicket']);
            Route::get('/close-ticket', [SupportController::class, 'closeTicket']);
            Route::get('/answered-ticket', [SupportController::class, 'answeredTicket']);
          //  Route::get('/get/{id}', [SupportController::class, 'index']);
        //    Route::post('/store', [SupportController::class, 'store']);
            Route::get('/reply/{id}', [SupportController::class, 'ticketReply']);
            Route::post('/create-reply/{id}', [SupportController::class, 'store']);
            Route::delete('/delete/{id}', [SupportController::class, 'destroy']);
            Route::get('/show/{id}', [SupportController::class, 'show']);
            Route::get('/download/{ticket}', [SupportController::class, 'ticketDownload']);

        });



    //roles and permission Route group
    Route::group(['prefix' => 'roles'], function () {

        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{role}', [RoleController::class, 'show']);
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::delete('/{role}', [RoleController::class, 'destroy']);
        Route::post('/change-role', [RoleController::class, 'changeRole']);
        Route::post('/permission-to-role/{role}', [RoleController::class, 'givePermissionToRole']);
        Route::post('/remove-permission-to-role/{role}', [RoleController::class, 'removePermissionToRole']);
        Route::get('/user/{user}', [RoleController::class, 'user_role']);

    });

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index']);
        Route::post('/', [PermissionController::class, 'store']);
        Route::get('/{permission}', [PermissionController::class, 'show']);
        Route::put('/{permission}', [PermissionController::class, 'update']);
        Route::delete('/{permission}', [PermissionController::class, 'destroy']);
    });

    // agent route group
    Route::group(['prefix' => 'agent'], function () {

        Route::get('/', [AgentController::class, 'index']);
        Route::post('/store', [AgentController::class, 'store']);
        Route::get('/search', [AgentController::class, 'search']);
        Route::get('/pending', [AgentController::class, 'pending']);
        Route::post('/status/{id}', [AgentController::class, 'setStatus']);
        Route::get('/show/{id}', [AgentController::class, 'show']);
        Route::post('/update/{id}', [AgentController::class, 'update']);
        Route::delete('/destroy/{id}', [AgentController::class, 'destroy']);
        Route::get('/status/type', [AgentController::class, 'statusType']);
    });

      // driver route group
      Route::group(['prefix' => 'driver'], function () {
        Route::get('/', [DriverController::class, 'index']);
        Route::post('/store', [DriverController::class, 'store']);
        Route::get('/search', [DriverController::class, 'search']);
        Route::get('/pending', [DriverController::class, 'pending']);
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
        Route::get('/pending', [DriverManagerController::class, 'pending']);
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
