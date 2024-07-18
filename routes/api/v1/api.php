<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
// use App\Http\Controllers\Api\v1\Customers\LoadTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MapApiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Api\v1\CountryController;
use App\Http\Controllers\Api\v1\auth\AuthController;
use App\Http\Controllers\Api\v1\Blog\BlogController;
use App\Http\Controllers\Api\v1\Chat\ChatController;
use App\Http\Controllers\Api\v1\Admin\PlanController;
use App\Http\Controllers\Api\v1\Order\OrderController;
use App\Http\Controllers\Api\v1\Truck\TruckController;
use App\Http\Controllers\Api\v1\Wallet\BankController;
use App\Http\Controllers\Api\v1\Wallet\CardController;
use App\Http\Controllers\Api\v1\Agents\AgentController;
use App\Http\Controllers\Api\v1\Blog\CategoryController;
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

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1'], function () {

    Route::get('/', function (Request $request) {

         return response()->json(['message' =>"v1 Server is up and running"]);
        //return "here is the user";
    });

    Route::get('/auth', function (Request $request) {

        return response()->json(['message' =>"v1 Server is up and running"]);
       //return "here is the user";
   });

    // user registration namespace
    Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('{provider}', [AuthController::class, 'redirectToProvider']);
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
        Route::post('/update-password', [AuthController::class, 'updatePassword']);
        Route::post('/update-profile', [AuthController::class, 'updateProfile']);

        Route::get('user-delete',[AuthController::class,'delete_user']);
    });

    // customer Route
    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {


        Route::group(['prefix' => 'plans'], function () {
            Route::get('/', [PlanController::class, 'index']);
            Route::get('/{plan}', [PlanController::class, 'show']);
        });

        //load type route
        Route::post('/bePremium', [AuthController::class, 'bePremium']);

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
        Route::post('/pay-load/fee/{order}', [LoadPackageController::class, 'delivery_fee']);

        // load Bulk route
        Route::get('/load-bulk', [LoadBulkController::class, 'index']);
        Route::post('/load-bulk', [LoadBulkController::class, 'store']);
        Route::get('/load-bulk/{id}', [LoadBulkController::class, 'show']);
        Route::post('/load-bulk/{loadBulk}', [LoadBulkController::class, 'update']);
        Route::post('/load-bulk/fee/{loadBulk}', [LoadBulkController::class, 'delivery_fee']);
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
        Route::post('/order-assign', [LoadBoardController::class, 'orderAssign']);
        Route::post('/load-board/print-barcode', [LoadBoardController::class, 'barCode']);
        Route::get('/load-board/{id}', [LoadBoardController::class, 'show']);
        Route::post('/load-board/{loadBulk}', [LoadBoardController::class, 'update']);
        Route::delete('/load-board/{id}', [LoadBoardController::class, 'destroy']);
        Route::get('/load-board/accept/{loadBoard}', [LoadBoardController::class, 'accept']);

    });

    Route::group(['prefix' => 'bid', 'middleware' => 'auth:api'], function () {
        Route::post('/load-board/accept-bid', [LoadBoardController::class, 'acceptBidByCustomer']);
        Route::post('/load-board/accept-order', [LoadBoardController::class, 'accept']);
        Route::post('/load-board/{loadBoard}', [LoadBoardController::class, 'bidStore']);
        Route::get('/load-board/{loadBoard}', [LoadBoardController::class, 'getAllBidsByLoadBoard']);
        Route::get('/load-board/customer/{id}', [LoadBoardController::class, 'getAllBidsByOrder']);
    });
    Route::group(['prefix' => 'chat', 'middleware' => 'auth:api'], function () {

        Route::post('/get', [ChatController::class, 'index']);
        Route::post('/store', [ChatController::class, 'store']);
        Route::delete('/delete/{id}', [ChatController::class, 'destroy']);
        Route::get('/show/{id}', [ChatController::class, 'show']);
        Route::post('/update/{id}', [ChatController::class, 'update']);

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

    Route::group(['prefix' => 'order/tracking'], function () {

        Route::get('/', [TrackingController::class, 'index']);
        Route::post('/', [TrackingController::class, 'store'])->middleware('auth:api');
        Route::get('/{id}', [TrackingController::class, 'show']);
        Route::post('/{id}', [TrackingController::class, 'update'])->middleware('auth:api');
        Route::delete('/{id}', [TrackingController::class, 'destroy'])->middleware('auth:api');

    });


    Route::group(['prefix' => 'order', 'middleware' => 'auth:api'], function () {

        //load type route
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::post('/cancel', [OrderController::class, 'cancelOrder']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::post('/{id}', [OrderController::class, 'update']);
        Route::delete('/{id}', [OrderController::class, 'destroy']);
        Route::get('/price/get-weight', [OrderController::class, 'weight']);
        Route::get('/price/get-weight-bulk', [OrderController::class, 'weightBulk']);
        Route::get('/price/get-distance', [OrderController::class, 'distancePrice']);
        Route::post('/price/calculate', [OrderController::class, 'calculatePrice']);
        Route::post('/price/calculateCarClearing', [OrderController::class, 'calculateCarClearing']);
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

        Route::post('/store', [CompanyController::class, 'store']);
        ///  Route::post('/update/{id}', [CompanyController::class, 'update']);
        //   Route::delete('/destroy/{id}', [CompanyController::class, 'destroy']);

        Route::group(['middleware' => 'auth:api' ,'role:Company Transport'], function(){
            Route::get('/', [CompanyController::class, 'index']);

            Route::get('/my-info', [CompanyController::class, 'my_info']);
            Route::get('/delete-account', [CompanyController::class, 'deleteAccount']);

            Route::get('/drivers', [CompanyController::class, 'driver']);
            Route::get('/truck', [TruckController::class, 'truck']);

            Route::get('/my-drivers', [CompanyController::class, 'my_drivers']);
            Route::get('/remove-driver', [CompanyController::class, 'remove_driver']);
            Route::get('/available-drivers', [CompanyController::class, 'available_drivers']);
            Route::get('/my-truck', [CompanyController::class, 'my_truck']);
            Route::get('/available-truck', [CompanyController::class, 'available_truck']);
            Route::post('/send-request', [CompanyController::class, 'sendRequest']);


            Route::post('/assign-driver-truck', [CompanyController::class, 'assignDriverToTruck']);
            Route::post('/order-to-driver', [CompanyController::class, 'assignOrderToDriver']);

            // Route::get('/order', [CompanyController::class, 'order']);
            Route::get('/order', [LoadBoardController::class, 'order']);
            Route::post('/accept-order', [LoadBoardController::class, 'acceptOrder']);
            Route::post('/reject-order', [LoadBoardController::class, 'rejectOrder']);

            Route::get('/all-driver-truck', [CompanyController::class, 'driverWithTruck']);

            Route::post('/order-assign', [LoadBoardController::class, 'orderAssign']);
            Route::post('/order-re-assign', [LoadBoardController::class, 'orderReAssign']);

            Route::get('/all-driver-assign-orders', [LoadBoardController::class, 'allDriverAssignOrders']);

            Route::get('/broadcast', [CompanyController::class, 'broadcast']);
            Route::get('/broadcast/{id}', [CompanyController::class, 'singleBroadcast']);

            Route::delete('/delete', [CompanyController::class, 'destroy']);
            Route::post('/addUser', [CompanyController::class, 'createUser']);
            Route::get('/myUsers', [CompanyController::class, 'myUsers']);
            Route::post('/changeRole', [CompanyController::class, 'changeRole']);

            Route::post('/create-truck', [CompanyController::class, 'createTruck']);
            Route::post('/create-driver', [CompanyController::class, 'createDriver']);
            Route::post('/move-truck-workshop', [CompanyController::class, 'moveTruckToWorkshop']);
            Route::get('/move-truck-workshop', [CompanyController::class, 'truckInWorkshop']);


               // load package route
            Route::get('/load-package', [LoadPackageController::class, 'index']);
            Route::post('/load-package', [CompanyController::class, 'privateLoadPackageStore']);
            Route::get('/load-package/{id}', [LoadPackageController::class, 'show']);
            Route::post('/load-package/{id}', [LoadPackageController::class, 'update']);
            Route::delete('/load-package/{id}', [LoadPackageController::class, 'destroy']);

            // load Bulk route
            Route::get('/load-bulk', [LoadBulkController::class, 'index']);
            Route::post('/load-bulk', [CompanyController::class, 'privateLoadBulkStore']);
            Route::get('/load-bulk/{id}', [LoadBulkController::class, 'show']);
            Route::post('/load-bulk/{loadBulk}', [LoadBulkController::class, 'update']);
            Route::delete('/load-bulk/{id}', [LoadBulkController::class, 'destroy']);

        });
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

            Route::get('/request', [DriverController::class, 'pendingRequest']);
            Route::post('/request', [DriverController::class, 'acceptRequest']);
            Route::get('/broadcast', [DriverController::class, 'broadcast']);
            Route::post('/profile/change-image', [DriverController::class, 'changeImage']);
            Route::post('/profile/update-details', [DriverController::class, 'updateProfile']);
            Route::get('/order', [DriverController::class, 'order']);
            Route::get('/order/build-route', [DriverController::class, 'routeBuild']);
            Route::post('/order/build-route', [DriverController::class, 'storeRouteBuild']);
            Route::post('/accept-order', [LoadBoardController::class, 'acceptOrder']);
            Route::post('/reject-order', [DriverController::class, 'rejectOrder']);
            Route::post('/upload-photo/{order_no}', [DriverController::class, 'upload_photo']);

            Route::post('/payment-status/status', [DriverController::class, 'paymentOrderStatus']);
            //Route::post('/approve-order/status', [DriverController::class, 'approveOrderStatus']);
            Route::post('/loadBoard-order/status', [DriverController::class, 'loadBoardOrderStatus']);


        });
    });

    Route::group(['prefix' => 'clearing-agent','middleware' => 'auth:api','role:agent'], function () {

        Route::get('/order', [ClearingAgentController::class, 'my_order']);
        Route::post('/store', [ClearingAgentController::class, 'store'])->withoutMiddleware("auth:api");
        Route::post('/order-assign', [ClearingAgentController::class, 'orderAssign']);
        Route::post('/accept-order', [ClearingAgentController::class, 'acceptOrder']);
        Route::post('/upload-docs', [ClearingAgentController::class, 'uploadDocs']);
        Route::post('/order-reassign', [ClearingAgentController::class, 'orderReAssign']);
        Route::get('/broadcast', [ClearingAgentController::class, 'broadcast']);
        Route::get('/broadcast/{id}', [ClearingAgentController::class, 'singleBroadcast']);

        // Route::get('/accept-order/{id}', [ClearingAgentController::class, 'accept_order']);

    });


    Route::group(['prefix' => 'driver-manager'], function () {
        Route::post('/store', [DriverMangerController::class, 'store']);

         // Route::get('/request', [DriverMangerController::class, 'updateRequest']);
        Route::get('/request/{driverID}/{managerID}/{status}', [DriverMangerController::class, 'updateRequest']);

        Route::middleware(['auth:api'])->group(function () {
       //  Route::get('/your-url', function () {

           Route::get('/', [DriverMangerController::class, 'index']);

           Route::get('/my-drivers', [DriverMangerController::class, 'my_drivers']);
           Route::get('/delete-account', [DriverMangerController::class, 'deleteUserAndDriver']);
           Route::get('/available-drivers', [DriverMangerController::class, 'available_drivers']);
           Route::get('/my-truck', [DriverMangerController::class, 'my_truck']);
           Route::get('/available-truck', [DriverMangerController::class, 'available_truck']);
           Route::post('/send-request', [DriverMangerController::class, 'sendRequest']);

           Route::get('/order', [LoadBoardController::class, 'order']);
           Route::post('/reject-order', [LoadBoardController::class, 'rejectOrder']);
           Route::get('/all-driver-assign-orders', [LoadBoardController::class, 'allDriverAssignOrders']);
           Route::get('/all-driver-truck', [DriverMangerController::class, 'driverWithTruck']);
           Route::post('/assign-driver-truck', [DriverMangerController::class, 'assignDriverToTruck']);
           Route::post('/driver-truck', [DriverMangerController::class, 'singleDriverTrucks']);
        //    Route::post('/assign-driver-truck', [LoadBoardController::class, 'assignDriverToTruck']);
           Route::post('/re-assign-driver-truck', [LoadBoardController::class, 'reAssignDriverToTruck']);
           Route::post('/accept-order', [LoadBoardController::class, 'acceptOrder']);
           Route::post('/order-assign', [LoadBoardController::class, 'orderAssign']);
           Route::post('/order-re-assign', [LoadBoardController::class, 'orderReAssign']);
           Route::post('/remove-order', [LoadBoardController::class, 'removeOrder']);
           Route::post('/remove-truck', [LoadBoardController::class, 'removeTruck']);
           Route::post('/order-reassign', [DriverMangerController::class, 'orderReAssign']);
           Route::get('/broadcast', [DriverMangerController::class, 'broadcast']);
           Route::get('/broadcast/{id}', [DriverMangerController::class, 'singleBroadcast']);
           Route::get('/driver-orders/{user}', [LoadBoardController::class, 'allUserOrder']);
           // Route::get('/show/{id}', [DriverMangerController::class, 'show']);
           Route::post('/update/{id}', [DriverMangerController::class, 'update']);
           // Route::delete('/destroy/{id}', [DriverMangerController::class, 'destroy']);


           //   });
        });

    });

    Route::group(['prefix' => 'transfer/nomba', 'middleware' => 'auth:api'], function () {
        Route::get('/bank/list', [BankController::class, 'list'])->name('nomba.bank.list');
        Route::post('/bank/lookup', [BankController::class, 'lookup'])->name('nomba.bank.lookup');
        Route::post('/bank/submit', [BankController::class, 'submit'])->name('nomba.bank.submit');
    });


    Route::group(['prefix' => 'transfer/paystack', 'middleware' => 'auth:api'], function () {
        Route::get('/bank/list', [BankController::class, 'list'])->name('paystack.bank.list');
        Route::post('/bank/lookup', [BankController::class, 'lookup'])->name('paystack.bank.lookup');
        Route::post('/bank/submit', [BankController::class, 'submit'])->name('paystack.bank.submit');
        Route::post('/bank/finalize-transfer', [BankController::class, 'finalizeTransfer'])->name('paystack.bank.finalizeTransfer');

        Route::post('/bank/resend-otp', [BankController::class, 'resendOtp'])->name('paystack.transfer.resendOtp');
        Route::get('/bank/disable-otp', [BankController::class, 'disableOtp'])->name('paystack.transfer.disableOtp');
        Route::post('/bank/disable-otp-finalize', [BankController::class, 'disableOtpFinalize'])->name('paystack.transfer.disableOtpFinalize');
        Route::get('/bank/{transferCode}', [BankController::class, 'getTransferByCode'])->name('paystack.transfer.code');
        Route::get('/bank/verify/{reference}', [BankController::class, 'getTransferByReference'])->name('paystack.transfer.reference');
    });

    Route::group(['prefix' => 'notification', 'middleware' => 'auth:api'], function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/read/{id}', [NotificationController::class, 'readNotification']);

    });
    Route::group(['prefix' => 'settings', 'middleware' => 'auth:api'], function () {
         Route::get('/', [SettingController::class, 'index']);
         Route::get('/{id}', [SettingController::class, 'show']);
    });


    Route::get('paystack/webhooks', [PaymentController::class, 'paystackWebhooks']);
    Route::post('paystack/webhooks', [PaymentController::class, 'paystackWebhooks']);
    Route::post('nomba/webhooks', [PaymentController::class, 'nombaWebhooks']);
    // wallet route group


    Route::group(['prefix' => 'wallet', 'middleware' => 'auth:api'], function () {

        // Wallet endpoints
        Route::get('/', [WalletController::class, 'index']);
        Route::get('/check-pin', [WalletController::class, 'checkPinExists']);
        Route::post('/topup', [WalletController::class, 'topUpWallet']);
        Route::post('/fetch-user', [WalletController::class, 'fetchContact']);
        Route::post('/validate-pin', [WalletController::class, 'validate_pin']);
        Route::post('/update-pin', [WalletController::class, 'update_pin']);
        Route::get('/wallet-history', [WalletController::class, 'wallet_history']);
        Route::post('/request-money', [WalletController::class, 'requestMoney']);
        Route::post('/wallets-transfer', [WalletController::class, 'transfer_balance']);
        Route::get('/request-inbox', [WalletController::class, 'requestInbox']);
        Route::get('/sent-request', [WalletController::class, 'sendRequest']);
        Route::get('/all-money-request', [WalletController::class, 'allMoneyRequest']);
        Route::post('/approve-request-money/{id}', [WalletController::class, 'approveRequest']);

        // Card endpoints
        Route::group(['prefix' => 'cards'], function () {
            Route::post('/', [CardController::class, 'store']);
            Route::get('/', [CardController::class, 'index']);
            Route::get('/{id}', [CardController::class, 'show']);
            Route::put('/{id}', [CardController::class, 'update']);
            Route::delete('/{id}', [CardController::class, 'destroy']);
        });

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
        Route::get('get-api-key', [MapApiController::class,'getKey']);
        Route::post('place-api-autocomplete', [MapApiController::class,'place_api_autocomplete']);
        Route::post('distance-api', [MapApiController::class, 'distance_api']);
        Route::post('place-api-details', [MapApiController::class,'place_api_details']);
        Route::post('geocode-api', [MapApiController::class,'geocode_api']);
    });

    //categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
      //  Route::post('/', [CategoryController::class, 'store']);
        Route::get('/{category}', [CategoryController::class, 'show']);
     //   Route::put('/{category}', [CategoryController::class, 'update']);
       // Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });

    Route::group(['prefix' => 'blog'], function () {

        Route::get('/', [BlogController::class, 'index']);
        Route::get('/{id}', [BlogController::class, 'show']);

        Route::get('/comment', [BlogController::class, 'getComments']);
        Route::get('/comment/{id}', [BlogController::class, 'getComments']);
        Route::get('/{category}/related', [BlogController::class, 'getRelatedBlogs']);

        });

    Route::group(['prefix' => 'blog','middleware' => 'auth:api'], function () {

        Route::post('/', [BlogController::class, 'store']);
        Route::put('/{id}', [BlogController::class, 'update']);
        Route::delete('/{id}', [BlogController::class, 'destroy']);
        Route::post('/comment', [BlogController::class, 'storeComment']);
      //  Route::put('/comment/{id}', [BlogController::class, 'updateComment']);
       // Route::delete('/comment/{id}', [BlogController::class, 'destroyComment']);

        Route::get('/pending', [BlogController::class, 'pendingBlog']);
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

