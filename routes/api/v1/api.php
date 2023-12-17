<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\RoleController;
// use App\Http\Controllers\Api\v1\Customers\LoadTypeController;
use App\Http\Controllers\MapApiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Api\v1\CountryController;
use App\Http\Controllers\Api\v1\auth\AuthController;
use App\Http\Controllers\Api\v1\Chat\ChatController;
use App\Http\Controllers\Api\v1\Order\OrderController;
use App\Http\Controllers\Api\v1\Truck\TruckController;
use App\Http\Controllers\Api\v1\Wallet\CardController;
use App\Http\Controllers\Api\v1\Agents\AgentController;
use App\Http\Controllers\Api\v1\Driver\DriverController;
use App\Http\Controllers\Api\v1\Wallet\WalletController;
use App\Http\Controllers\Api\v1\Brokers\BrokerController;
use App\Http\Controllers\Api\v1\Wallet\PaymentController;
use App\Http\Controllers\Api\v1\Company\CompanyController;
use App\Http\Controllers\Api\v1\Support\SupportController;
use App\Http\Controllers\Api\v1\Customers\LoadBulkController;
use App\Http\Controllers\Api\v1\Customers\LoadTypeController;
use App\Http\Controllers\Api\v1\Customers\LoadBoardController;
use App\Http\Controllers\Api\v1\Agents\ClearingAgentController;
use App\Http\Controllers\Api\v1\Customers\LoadPackageController;
use App\Http\Controllers\Api\v1\Customers\VehicleMakeController;
use App\Http\Controllers\Api\v1\Customers\VehicleTypeController;
use App\Http\Controllers\Api\v1\auth\EmailVerificationController;
use App\Http\Controllers\Api\v1\Customers\VehicleModelController;
use App\Http\Controllers\Api\v1\Customers\LoadContainerController;
use App\Http\Controllers\Api\v1\Customers\LoadCarClearingController;
use App\Http\Controllers\Api\v1\Customers\LoadSpecializedController;
use App\Http\Controllers\Api\v1\DriverManger\DriverMangerController;
use App\Http\Controllers\Api\v1\ShippingCompany\ShippingCompanyController;

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => 'return-json'], function () {

    Route::get('/', function () {

         return response()->json(['message' =>"v1 Server is up and running"]);
        //return "here is the user";
    });

    // user registration namespace
    Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/get-upline/{code}', [AuthController::class, 'getUpLineUser']);
        Route::post('/social-login', [AuthController::class, 'handleProviderCallback']);

        Route::post('/forgot-password', [EmailVerificationController::class, 'reset_password_request']);
        Route::post('/send-otp', [EmailVerificationController::class, 'send_otp']);
        Route::post('/verify-otp', [EmailVerificationController::class, 'otp_verification_submit']);
        Route::post('/check-email', [EmailVerificationController::class, 'check_if_email_exist']);
    });

    Route::group(['prefix' => 'auth', 'namespace' => 'auth', 'middleware' => 'auth:api'], function () {
        Route::get('/is-login', [AuthController::class, 'isLogin']);
        Route::get('/profile', [AuthController::class, 'me']);
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::post('/update-profile', [AuthController::class, 'updateProfile']);

        Route::post('update-delete',[AuthController::class,'delete_delete']);
    });

    // customer Route
    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {

        //load type route
        Route::get('/bePremium', [AuthController::class, 'bePremium']);

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

        // load Bulk route
        Route::get('/load-bulk', [LoadBulkController::class, 'index']);
        Route::post('/load-bulk', [LoadBulkController::class, 'store']);
        Route::get('/load-bulk/{id}', [LoadBulkController::class, 'show']);
        Route::post('/load-bulk/{loadBulk}', [LoadBulkController::class, 'update']);
        Route::delete('/load-bulk/{id}', [LoadBulkController::class, 'destroy']);

        // load Load Car Clearing  route
        Route::get('/load-car-clearing', [LoadCarClearingController::class, 'index']);
        Route::post('/load-car-clearing', [LoadCarClearingController::class, 'store']);
        Route::get('/load-car-clearing/{id}', [LoadCarClearingController::class, 'show']);
        Route::post('/load-car-clearing/{loadBulk}', [LoadCarClearingController::class, 'update']);
        Route::delete('/load-car-clearing/{id}', [LoadCarClearingController::class, 'destroy']);


        // load Load Container Shipment route
        Route::get('/load-container-shipment', [LoadContainerController::class, 'index']);
        Route::post('/load-container-shipment', [LoadContainerController::class, 'store']);
        Route::get('/load-container-shipment/{id}', [LoadContainerController::class, 'show']);
        Route::post('/load-container-shipment/{loadBulk}', [LoadContainerController::class, 'update']);
        Route::delete('/load-container-shipment/{id}', [LoadContainerController::class, 'destroy']);

        // load-specialized  route
        Route::get('/load-specialized', [LoadSpecializedController::class, 'index']);
        Route::post('/load-specialized', [LoadSpecializedController::class, 'store']);
        Route::get('/load-specialized/{id}', [LoadSpecializedController::class, 'show']);
        Route::post('/load-specialized/{loadBulk}', [LoadSpecializedController::class, 'update']);
        Route::delete('/load-specialized/{id}', [LoadSpecializedController::class, 'destroy']);

        // load board route
        Route::get('/load-board', [LoadBoardController::class, 'index']);
        Route::post('/load-board', [LoadBoardController::class, 'store']);
        Route::get('/load-board/{id}', [LoadBoardController::class, 'show']);
        Route::post('/load-board/{loadBulk}', [LoadBoardController::class, 'update']);
        Route::delete('/load-board/{id}', [LoadBoardController::class, 'destroy']);
        Route::get('/load-board/accept/{loadBoard}', [LoadBoardController::class, 'accept']);

    });


    Route::group(['prefix' => 'chat', 'middleware' => 'auth:api'], function () {

        Route::post('/get', [ChatController::class, 'index']);
        Route::post('/store', [ChatController::class, 'store']);
        Route::delete('/delete/{id}', [ChatController::class, 'destroy']);
        Route::get('/show/{id}', [ChatController::class, 'show']);

    });


    Route::group(['prefix' => 'support', 'middleware' => 'auth:api'], function () {

        Route::get('/get', [SupportController::class, 'index']);
      //  Route::get('/get/{id}', [SupportController::class, 'index']);
        Route::post('/store', [SupportController::class, 'store']);
        Route::post('/reply/{id}', [SupportController::class, 'replyTicket']);
        Route::delete('/delete/{id}', [SupportController::class, 'destroy']);
        Route::get('/show/{id}', [SupportController::class, 'show']);
        Route::get('/download/{ticket}', [SupportController::class, 'ticketDownload']);

    });

    Route::group(['prefix' => 'order', 'middleware' => 'auth:api'], function () {

        //load type route
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::post('/calculate', [OrderController::class, 'calculatePrice']);
        Route::get('/price', [OrderController::class, 'distancePrice']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::post('/{id}', [OrderController::class, 'update']);
        Route::delete('/{id}', [OrderController::class, 'destroy']);


    });
     // broker route group
    Route::group(['prefix' => 'broker'], function () {

        Route::get('/', [BrokerController::class, 'index']);
        Route::post('/store', [BrokerController::class, 'store']);
        Route::get('/show/{id}', [BrokerController::class, 'show']);
        Route::post('/update/{id}', [BrokerController::class, 'update']);
        Route::delete('/destroy/{id}', [BrokerController::class, 'destroy']);
    });

     // company route group
    Route::group(['prefix' => 'company'], function () {

        Route::get('/', [CompanyController::class, 'index']);
        Route::post('/store', [CompanyController::class, 'store']);
        Route::get('/show/{id}', [CompanyController::class, 'show']);
        Route::post('/update/{id}', [CompanyController::class, 'update']);
        Route::delete('/destroy/{id}', [CompanyController::class, 'destroy']);
    });

    // shipping company route group
    Route::group(['prefix' => 'shippingCompany'], function () {

        Route::get('/', [ShippingCompanyController::class, 'index']);
        Route::post('/store', [ShippingCompanyController::class, 'store']);
        Route::get('/show/{id}', [ShippingCompanyController::class, 'show']);
        Route::post('/update/{id}', [ShippingCompanyController::class, 'update']);
        Route::delete('/destroy/{id}', [ShippingCompanyController::class, 'destroy']);

        Route::group(['middleware' => 'auth:api','role:Shipping Company'], function () {

        Route::post('/addUser', [ShippingCompanyController::class, 'createUser']);
        Route::get('/myUsers', [ShippingCompanyController::class, 'myUsers']);
        Route::post('/changeRole', [ShippingCompanyController::class, 'changeRole']);
    });
    });

    // agent route group
    Route::group(['prefix' => 'agent'], function () {

        Route::get('/', [AgentController::class, 'index']);
        Route::post('/store', [AgentController::class, 'store']);

        Route::group(['middleware' => 'auth:api','role:agent'], function () {

        Route::get('/my-order', [AgentController::class, 'my_order']);
        Route::get('/show/{id}', [AgentController::class, 'show']);
        Route::get('/show-single-order/{id}', [AgentController::class, 'showSingleOrder']);
        Route::get('/show/{id}', [AgentController::class, 'show']);
        Route::post('/update/{id}', [AgentController::class, 'update']);
        Route::delete('/destroy/{id}', [AgentController::class, 'destroy']);
    });
    });


      // agent route group
      Route::group(['prefix' => 'truck'], function () {

        Route::get('/', [TruckController::class, 'index']);
        Route::post('/store', [TruckController::class, 'store']);
        Route::get('/show/{id}', [TruckController::class, 'show']);
        Route::post('/update/{id}', [TruckController::class, 'update']);
        Route::delete('/destroy/{id}', [TruckController::class, 'destroy']);
    });



    // driver route group
    Route::group(['prefix' => 'driver'], function () {

        Route::get('/', [DriverController::class, 'index']);
        Route::post('/store', [DriverController::class, 'store']);
        Route::post('/store', [DriverController::class, 'store']);
        Route::get('/show/{id}', [DriverController::class, 'show']);
        Route::post('/update/{id}', [DriverController::class, 'update']);
        Route::delete('/destroy/{id}', [DriverController::class, 'destroy']);
        Route::get('/broadcast/{id}', [DriverController::class, 'singleBroadcast']);

        Route::group(['middleware' => 'auth:api','role:Driver'], function () {

            Route::get('/broadcast', [DriverController::class, 'broadcast']);
            Route::post('/profile/change-image', [DriverController::class, 'changeImage']);
            Route::post('/profile/update-details', [DriverController::class, 'updateProfile']);

        });
    });

    Route::group(['prefix' => 'clearing-agent','middleware' => 'auth:api'], function () {

        Route::get('/order', [ClearingAgentController::class, 'my_order']);
        Route::post('/store', [ClearingAgentController::class, 'store'])->withoutMiddleware("auth:api");
        Route::post('/order-assign', [ClearingAgentController::class, 'orderAssign']);
        Route::post('/order-reassign', [ClearingAgentController::class, 'orderReAssign']);
        Route::get('/broadcast', [ClearingAgentController::class, 'broadcast']);
        Route::get('/broadcast/{id}', [ClearingAgentController::class, 'singleBroadcast']);
        Route::get('/accept-order/{id}', [ClearingAgentController::class, 'accept_order']);

    });


Route::group(['prefix' => 'driver-manager'], function () {
    Route::post('/store', [DriverMangerController::class, 'store']);

        Route::middleware(['auth:api'])->group(function () {
          //  Route::get('/your-url', function () {

                Route::get('/', [DriverMangerController::class, 'index']);

                Route::get('/drivers', [DriverMangerController::class, 'index']);
                Route::get('/truck', [TruckController::class, 'truck']);
                Route::get('/order', [DriverMangerController::class, 'order']);
                Route::post('/order-assign', [DriverMangerController::class, 'orderAssign']);
                Route::post('/order-reassign', [DriverMangerController::class, 'orderReAssign']);
                Route::get('/broadcast', [DriverMangerController::class, 'broadcast']);
                Route::get('/broadcast/{id}', [DriverMangerController::class, 'singleBroadcast']);
                // Route::get('/show/{id}', [DriverMangerController::class, 'show']);
                // Route::post('/update/{id}', [DriverMangerController::class, 'update']);
                // Route::delete('/destroy/{id}', [DriverMangerController::class, 'destroy']);


         //   });
        });

    });

    Route::group(['prefix' => 'notification', 'middleware' => 'auth:api'], function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/read/{id}', [NotificationController::class, 'readNotification']);

    });
    Route::group(['prefix' => 'settings', 'middleware' => 'auth:api'], function () {
         Route::get('/', [SettingController::class, 'index']);
         Route::get('/{id}', [SettingController::class, 'show']);
    });


    Route::get('paystack/webhooks', [PaymentController::class, 'webhooks']);
    Route::post('paystack/webhooks', [PaymentController::class, 'webhooks']);
    // wallet route group
    Route::group(['prefix' => 'wallet', 'middleware' => 'auth:api'], function () {

        Route::get('/', [WalletController::class, 'index']);
        Route::get('/check-pin', [WalletController::class, 'checkPinExists']);
        Route::post('/validate-pin', [WalletController::class, 'validate_pin']);
        Route::post('/update-pin', [WalletController::class, 'update_pin']);
        Route::get('/wallet-history', [WalletController::class, 'wallet_history']);


        //card endpoint here
        Route::post('/cards', [CardController::class, 'store']);
        Route::get('/cards', [CardController::class, 'index']);
        Route::get('/cards/{id}', [CardController::class, 'show']);
        Route::put('/cards/{id}', [CardController::class, 'update']);
        Route::delete('/cards/{id}', [CardController::class, 'destroy']);

    });

    //vehicle route group here
    // Route::group(['prefix' => 'vehicle', 'middleware' => 'auth:api'], function () {
     Route::group(['prefix' => 'vehicle'], function () {

        // route for vehicle make
        Route::get('/make', [VehicleMakeController::class, 'index']);
        Route::post('/make', [VehicleMakeController::class, 'store']);
        Route::get('/make/{id}', [VehicleMakeController::class, 'show']);
        Route::post('/make/{id}', [VehicleMakeController::class, 'update']);
        Route::delete('/make/{id}', [VehicleMakeController::class, 'destroy']);

        // route for vehicle model
        Route::get('/model', [VehicleModelController::class, 'index']);
        Route::post('/model', [VehicleModelController::class, 'store']);
        Route::get('/model/{id}', [VehicleModelController::class, 'show']);
        Route::post('/model/{id}', [VehicleModelController::class, 'update']);
        Route::delete('/model/{id}', [VehicleModelController::class, 'destroy']);

        // route for vehicle type
        Route::get('/type', [VehicleTypeController::class, 'index']);
        Route::post('/type', [VehicleTypeController::class, 'store']);
        Route::get('/type/{id}', [VehicleTypeController::class, 'show']);
        Route::post('/type/{id}', [VehicleTypeController::class, 'update']);
        Route::delete('/type/{id}', [VehicleTypeController::class, 'destroy']);
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

    // places route group
    Route::group(['prefix' => 'place'], function () {

        Route::get('/countries', [CountryController::class, 'getCountry']);
        Route::get('/countries/{id}',  [CountryController::class, 'singleCountry']);

        // State Routes
        Route::get('/states', [CountryController::class, 'index']);
        Route::get('/states/{country_id}', [CountryController::class, 'getStatesByCountry']);

        // City Routes
        Route::get('/cities', [CountryController::class, 'cities']);
        Route::get('/cities/{state_id}', [CountryController::class, 'getCitiesByState']);
        Route::get('/cities/{country_id}/{state_id}', [CountryController::class, 'getCitiesByCountryAndState']);

        // for nigeria
        Route::get('/nigeria/states', [CountryController::class, 'getNigeriaState']);
        Route::get('/nigeria/lga/{state_id}',  [CountryController::class, 'getLgaByState']);
    });


        //map api
    Route::group(['prefix' => 'mapapi'], function () {
        Route::post('place-api-autocomplete', [MapApiController::class,'place_api_autocomplete']);
        Route::post('distance-api', [MapApiController::class, 'distance_api']);
        Route::post('place-api-details', [MapApiController::class,'place_api_details']);
        Route::post('geocode-api', [MapApiController::class,'geocode_api']);
    });

    Route::group(['prefix' => 'wipe'], function () {
        Route::get('/', function(){

          //  Artisan::call('migrate:fresh --seed');

          Artisan::call('migrate:fresh');
          Artisan::call('db:seed');

            return response()->json([
                'message' => 'Database migrated and seeded successfully.'
            ]);
        });

    });

});

