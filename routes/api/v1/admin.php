<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Admin\BlogController;
use App\Http\Controllers\Api\v1\Admin\PlanController;
use App\Http\Controllers\Api\v1\Admin\RoleController;
use App\Http\Controllers\Api\v1\Admin\AgentController;
use App\Http\Controllers\Api\v1\Admin\LoadsController;
use App\Http\Controllers\Api\v1\Admin\OrderController;
use App\Http\Controllers\Api\v1\Admin\PriceController;
use App\Http\Controllers\Api\v1\Wallet\CardController;
use App\Http\Controllers\Api\v1\Admin\BrokerController;
use App\Http\Controllers\Api\v1\Admin\DriverController;
use App\Http\Controllers\Api\v1\Admin\WalletController;
use App\Http\Controllers\Api\v1\Admin\CompanyController;
use App\Http\Controllers\Api\v1\Admin\SettingController;
use App\Http\Controllers\Api\v1\Admin\CategoryController;
use App\Http\Controllers\Api\v1\Admin\CustomerController;
use App\Http\Controllers\Api\v1\Admin\EmployeeController;
use App\Http\Controllers\Api\v1\Referral\BonusController;
use App\Http\Controllers\Api\v1\Admin\AdminAuthController;
use App\Http\Controllers\Api\v1\Admin\DashboardController;
use App\Http\Controllers\Api\v1\Admin\LoadBoardController;
use App\Http\Controllers\Api\v1\Admin\ManageUserController;
use App\Http\Controllers\Api\v1\Admin\PermissionController;
use App\Http\Controllers\Api\v1\Admin\WeightPriceController;
use App\Http\Controllers\Api\v1\Referral\ReferralController;
use App\Http\Controllers\Api\v1\Customers\LoadBulkController;
use App\Http\Controllers\Api\v1\Admin\ClearingAgentController;
use App\Http\Controllers\Api\v1\Admin\DistancePriceController;
use App\Http\Controllers\Api\v1\Admin\DriverManagerController;
use App\Http\Controllers\Api\v1\Admin\AgentCommissionController;
use App\Http\Controllers\Api\v1\Admin\ShippingCompanyController;
use App\Http\Controllers\Api\v1\Admin\Support\SupportController;
use App\Http\Controllers\Api\v1\Customers\LoadPackageController;
use App\Http\Controllers\Api\v1\Admin\ContactSubmissionController;
use App\Http\Controllers\Api\v1\Admin\OrderPriceSettingController;
use App\Http\Controllers\Api\v1\Admin\ContainerValuePriceController;
use App\Http\Controllers\Api\v1\Admin\SpecializedShipmentController;
use App\Http\Controllers\Api\v1\Admin\TruckController;

Route::group(['prefix' => 'v1/admin'], function () {

    Route::get('/', function () {

        return response()->json(['message' => "v1 admin Server is up and running"]);
        //return "here is the user";
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AdminAuthController::class, 'login']);

        Route::post('/forgot-password', [AdminAuthController::class, 'reset_password_request']);
        Route::post('/send-otp', [AdminAuthController::class, 'send_otp']);
        Route::post('/verify-otp', [AdminAuthController::class, 'otp_verification_submit']);
        Route::post('/check-email', [AdminAuthController::class, 'check_if_email_exist']);
    });


    Route::group(['middleware' => ['auth:api', 'superadmin']], function () {
        Route::get('/is-login', [AdminAuthController::class, 'isLogin']);
        //setting route group
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index']);
            Route::get('/order-transactions', [DashboardController::class, 'getOrderTransactionStats']);
            Route::get('/wallet-transactions', [DashboardController::class, 'getWalletTransactionStats']);
        });


        Route::prefix('car-country-prices')->group(function () {
            Route::get('/', [PriceController::class, 'allCarCountryPrice']);
            Route::post('/', [PriceController::class, 'CarCountryPriceStore']);
            Route::get('/{id}', [PriceController::class, 'CarCountryPriceShow']);
            Route::put('/{id}', [PriceController::class, 'CarCountryPriceUpdate']);
            Route::delete('/{id}', [PriceController::class, 'CarCountryPriceDestroy']);
            Route::put('/status/{id}', [PriceController::class, 'CarCountryPriceStatusUpdate']);
        });

        Route::prefix('car-value-prices')->group(function () {
            Route::get('/', [PriceController::class, 'allCarValuePrice']);
            Route::post('/', [PriceController::class, 'CarValuePriceStore']);
            Route::get('/{id}', [PriceController::class, 'CarValuePriceShow']);
            Route::put('/{id}', [PriceController::class, 'CarValuePriceUpdate']);
            Route::delete('/{id}', [PriceController::class, 'CarValuePriceDestroy']);
            Route::put('/status/{id}', [PriceController::class, 'CarValuePriceStatusUpdate']);
        });


        Route::prefix('container-value-prices')->group(function () {
            Route::get('/', [ContainerValuePriceController::class, 'index']);
            Route::post('/', [ContainerValuePriceController::class, 'store']);
            Route::get('/{id}', [ContainerValuePriceController::class, 'show']);
            Route::put('/{id}', [ContainerValuePriceController::class, 'update']);
            Route::delete('/{id}', [ContainerValuePriceController::class, 'destroy']);
        });

        Route::prefix('commissions')->group(function () {
            // Route::resource('agent-commissions', AgentCommissionController::class);
            Route::get('/agent-commissions', [AgentCommissionController::class, 'index']);
            Route::post('/agent-commissions', [AgentCommissionController::class, 'store']);
            Route::get('/agent-commissions/{id}', [AgentCommissionController::class, 'show']);
            Route::put('/agent-commissions/{id}', [AgentCommissionController::class, 'update']);
            Route::delete('/agent-commissions/{id}', [AgentCommissionController::class, 'destroy']);

        });

        Route::group(['prefix' => 'referrer'], function () {

            Route::get('/top-referrer', [ManageUserController::class, 'getTopReferrer']);
            Route::get('/users-with-referrers', [ManageUserController::class, 'getUsersWithReferrers']);
            Route::get('/user/{userId}', [ManageUserController::class, 'getTotalUsersByReferrer']);
            Route::get('/getUplineByUserId/{userId}', [ManageUserController::class, 'getUplineByUserId']);
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [ManageUserController::class, 'index']);
            Route::post('/', [ManageUserController::class, 'store']);
            Route::get('/bulk-upload', [ManageUserController::class, 'pending']);
            Route::get('/pending', [ManageUserController::class, 'pending']);
            Route::get('/{id}', [ManageUserController::class, 'show']);
            Route::delete('/{id}', [ManageUserController::class, 'delete']);
            Route::post('/update/{id}', [ManageUserController::class, 'update']);
            Route::get('/user-with-role', [ManageUserController::class, 'user_role_auth']);
            Route::get('/user-with-role/{user}', [ManageUserController::class, 'user_role']);
            Route::post('/change-password/{user}', [ManageUserController::class, 'change_password']);
            Route::post('/status/{user}', [ManageUserController::class, 'status']);
        });


        //for employee
        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', [EmployeeController::class, 'index']);
            Route::post('/', [EmployeeController::class, 'store']);
            Route::get('/{id}', [EmployeeController::class, 'show']);
            Route::PUT('/{id}', [EmployeeController::class, 'update']);
            Route::delete('/{id}', [EmployeeController::class, 'destroy']);
            Route::post('/make-admin', [EmployeeController::class, 'makeAdmin']);
            Route::get('/search', [EmployeeController::class, 'search']);
            Route::post('/remove-admin', [EmployeeController::class, 'removeAdmin']);
            Route::post('/remove-admin-permission', [EmployeeController::class, 'removeAdmin']);
            Route::post('/status/{id}', [EmployeeController::class, 'status']);
        });


        Route::group(['prefix' => 'plans'], function () {
            Route::get('/', [PlanController::class, 'index']);
            Route::post('/', [PlanController::class, 'store']);
            Route::get('/getTotal', [PlanController::class, 'getTotal']);

            Route::get('/{plan}', [PlanController::class, 'show']);
            Route::put('/{plan}', [PlanController::class, 'update']);
            Route::delete('/{plan}', [PlanController::class, 'destroy']);

            Route::get('/users/all', [PlanController::class, 'getAllUsersWithPlans']);

            Route::get('/{plan}/getTotalById', [PlanController::class, 'getTotalById']);
            Route::put('/{plan}/status', [PlanController::class, 'status']);

            Route::get('/{plan}/users', [PlanController::class, 'getUsersByPlan']);

            Route::get('/{plan_id}/export-users', [PlanController::class, 'exportUsersByPlan']);



        });

        //for orders
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('/{id}', [OrderController::class, 'show']);
            Route::post('/status/{id}', [OrderController::class, 'update']);
            Route::get('/user/{id}', [OrderController::class, 'all_user_orders']);
            Route::post('/payment-status/status', [OrderController::class, 'paymentOrderStatus']);
            Route::post('/payment-status/approve-refund-Order', [OrderController::class, 'approveRefundOrder']);
            Route::post('/approve-order/status', [OrderController::class, 'approveOrderStatus']);
            Route::post('/loadBoard-order/status', [OrderController::class, 'loadBoardOrderStatus']);
        });
        Route::group(['prefix' => 'transactions'], function () {
            Route::get('/', [OrderController::class, 'all_transactions']);
            Route::get('/{id}', [OrderController::class, 'single_transactions']);
        });


        Route::group(['prefix' => 'kyc', 'middleware' => 'auth:api'], function () {

            Route::get('/', [WalletController::class, 'allKycLimit']);
            Route::post('/', [WalletController::class, 'storeKycLimit']);
            Route::get('/{id)', [WalletController::class, 'showKycLimit']);
            Route::put('/{id)', [WalletController::class, 'updateKycLimit']);
            Route::delete('/{id)', [WalletController::class, 'destroyKycLimit']);

        });

        Route::group(['prefix' => 'wallet', 'middleware' => 'auth:api'], function () {

            Route::get('/', [WalletController::class, 'index']);
            Route::get('/wallet-history', [WalletController::class, 'wallet_history']);
            Route::get('/statistics', [WalletController::class, 'wallet_statistics']);
            Route::get('/list', [WalletController::class, 'list_all_wallets']);
            Route::post('/update-pin/{id}', [WalletController::class, 'update_pin']);
            Route::post('/topup-balance/{id}', [WalletController::class, 'topup_balance']);
            Route::post('/enable-disable-wallet/{id}', [WalletController::class, 'update_wallet_status']);
            Route::get('/update-pin/via-link/{id}', [WalletController::class, 'update_pin_link']);
            Route::post('/{walletId}/limits', [WalletController::class, 'updateLimits']);
            Route::get('user/{userId}/wallet-history', [WalletController::class, 'userWalletAndHistory']);


            Route::post('/wallets-transfer', [WalletController::class, 'transfer_balance']);
            Route::post('/withdraw/{id}', [WalletController::class, 'withdraw']);

            //card endpoint here
            Route::post('/cards', [CardController::class, 'store']);
            Route::get('/cards', [CardController::class, 'index']);
            Route::get('/cards/{id}', [CardController::class, 'show']);
            Route::put('/cards/{id}', [CardController::class, 'update']);
            Route::delete('/cards/{id}', [CardController::class, 'destroy']);
        });

        // for settings
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [SettingController::class, 'index']);
            Route::get('/{id}', [SettingController::class, 'show']);
            Route::delete('/{id}', [SettingController::class, 'delete']);
            Route::post('/store', [SettingController::class, 'store']);
            Route::post('/update/{id}', [SettingController::class, 'update']);
        });

        Route::group(['prefix' => 'order-price'], function () {
            Route::apiResource('settings', OrderPriceSettingController::class);
        });



        Route::group(['prefix' => 'private-load'], function () {

        Route::post('/order-to-driver', [LoadsController::class, 'assignOrderToDriver']);
        Route::post('/order-assign', [LoadsController::class, 'orderAssign']);
        Route::post('/order-re-assign', [LoadsController::class, 'orderReAssign']);
        Route::post('/remove-order', [LoadsController::class, 'removeOrder']);
        Route::post('/privateLoad-to-loadBoard', [LoadsController::class, 'sendOrderToLoadBoard']);


        });
        // for private-load
        Route::group(['prefix' => 'private-load'], function () {
            Route::get('/load-package', [LoadPackageController::class, 'index']);
            Route::post('/load-package', [LoadsController::class, 'privateLoadPackageStore']);
            Route::get('/load-package/{id}', [LoadPackageController::class, 'show']);
            Route::post('/load-package/{id}', [LoadPackageController::class, 'update']);
            Route::delete('/load-package/{id}', [LoadPackageController::class, 'destroy']);
        });


        Route::group(['prefix' => 'private-load'], function () {
            Route::get('/load-bulk', [LoadBulkController::class, 'index']);
            Route::post('/load-bulk', [LoadsController::class, 'privateLoadBulkStore']);
            Route::get('/load-bulk/{id}', [LoadBulkController::class, 'show']);
            Route::post('/load-bulk/{loadBulk}', [LoadBulkController::class, 'update']);
            Route::delete('/load-bulk/{id}', [LoadBulkController::class, 'destroy']);
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

            Route::get('/get-distance-prices/{loadTypeId}', [SettingController::class, 'getDistancePricesByLoadType']);
            Route::get('/get-weight-prices/{loadTypeId}', [SettingController::class, 'getWeightPricesByLoadType']);
        });

        Route::group(['prefix' => 'weight-prices', 'middleware' => 'auth:api'], function () {
            Route::get('/', [WeightPriceController::class, 'index']);
            Route::get('/{id}', [WeightPriceController::class, 'show']);
            Route::post('/', [WeightPriceController::class, 'store']);
            Route::put('/{id}', [WeightPriceController::class, 'update']);
            Route::delete('/{id}', [WeightPriceController::class, 'destroy']);

            Route::get('/load-prices/{id}', [WeightPriceController::class, 'getWeightPricesByLoadType']);
            Route::get('/get-weight-prices/{weight_id}/{load_type_id}', [WeightPriceController::class, 'getWeightPriceIDByLoadType']);
        });


        Route::group(['prefix' => 'distance-prices', 'middleware' => 'auth:api'], function () {
            Route::get('/', [DistancePriceController::class, 'index']);
            Route::get('/{id}', [DistancePriceController::class, 'show']);
            Route::post('/', [DistancePriceController::class, 'store']);
            Route::put('/{id}', [DistancePriceController::class, 'update']);
            Route::delete('/{id}', [DistancePriceController::class, 'destroy']);
        });

        Route::group(['prefix' => 'contact', 'middleware' => 'auth:api'], function () {
            Route::get('/', [ContactSubmissionController::class, 'index']);
            Route::get('/{id}', [ContactSubmissionController::class, 'show']);
            Route::delete('/{id}', [ContactSubmissionController::class, 'destroy']);
            Route::post('{id}/reply', [ContactSubmissionController::class, 'reply']);
            Route::post('{id}/status', [ContactSubmissionController::class, 'updateStatus']);
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
            Route::post('/percentage/update/{id}', [AgentController::class, 'percentage']);
        });

        // agent route group
        Route::group(['prefix' => 'clearing-agent'], function () {

            Route::get('/', [ClearingAgentController::class, 'index']);
            Route::post('/store', [ClearingAgentController::class, 'store']);
            Route::get('/search', [ClearingAgentController::class, 'search']);
            Route::get('/pending', [ClearingAgentController::class, 'pending']);
            Route::get('/confirmed', [ClearingAgentController::class, 'confirmed']);
            Route::post('/status/{id}', [ClearingAgentController::class, 'setStatus']);
            Route::get('/show/{id}', [ClearingAgentController::class, 'show']);
            Route::post('/update/{id}', [ClearingAgentController::class, 'update']);
            Route::delete('/destroy/{id}', [ClearingAgentController::class, 'destroy']);
            Route::get('/status/type', [ClearingAgentController::class, 'statusType']);
        });

        // driver route group
        Route::group(['prefix' => 'driver'], function () {
            Route::get('/', [DriverController::class, 'index']);
            Route::post('/store', [DriverController::class, 'store']);
            Route::post('/bulk-upload', [DriverController::class, 'bulkUpload']);
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
            Route::post('/bulk-upload', [DriverManagerController::class, 'bulkUpload']);
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
            Route::get('/export', [ShippingCompanyController::class, 'export']);
            Route::post('/store', [ShippingCompanyController::class, 'store']);
            Route::get('/search', [ShippingCompanyController::class, 'search']);
            Route::get('/pending', [ShippingCompanyController::class, 'pending']);
            Route::post('/status/{id}', [ShippingCompanyController::class, 'setStatus']);
            Route::get('/show/{id}', [ShippingCompanyController::class, 'show']);
            Route::post('/update/{id}', [ShippingCompanyController::class, 'update']);
            Route::delete('/destroy/{id}', [ShippingCompanyController::class, 'destroy']);
        });


        // driver route group
        Route::group(['prefix' => 'truck'], function () {
            Route::get('/', [TruckController::class, 'index']);
            Route::post('/store', [DriverController::class, 'store']);
            Route::post('/bulk-upload', [DriverController::class, 'bulkUpload']);
            Route::get('/search', [TruckController::class, 'search']);
            Route::get('/pending', [DriverController::class, 'pending']);
            Route::post('/status/{id}', [DriverController::class, 'setStatus']);
            Route::get('/show/{id}', [DriverController::class, 'show']);
            Route::post('/update/{id}', [DriverController::class, 'update']);
            Route::delete('/destroy/{id}', [DriverController::class, 'destroy']);
        });


        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::get('/{category}', [CategoryController::class, 'show']);
            Route::put('/{category}', [CategoryController::class, 'update']);
            Route::delete('/{category}', [CategoryController::class, 'destroy']);
        });


        Route::group(['prefix' => 'blog', 'middleware' => 'auth:api'], function () {

            Route::get('/', [BlogController::class, 'index']);
            Route::post('/', [BlogController::class, 'store']);
            Route::get('/{id}', [BlogController::class, 'show']);
            Route::put('/{id}', [BlogController::class, 'update']);
            Route::delete('/{id}', [BlogController::class, 'destroy']);
            Route::post('status/{id}', [BlogController::class, 'setStatus']);

            Route::get('/comment', [BlogController::class, 'getComments']);
            Route::get('/comment/{id}', [BlogController::class, 'getComments']);
            Route::post('/comment', [BlogController::class, 'storeComment']);
            Route::put('/comment/{id}', [BlogController::class, 'updateComment']);
            Route::delete('/comment/{id}', [BlogController::class, 'destroyComment']);

            Route::get('/pending', [BlogController::class, 'pendingBlog']);
            Route::get('/{category}/related', [BlogController::class, 'getRelatedBlogs']);
            Route::post('/comment/status/{id}', [BlogController::class, 'setStatus']);
        });


        // company-transporter route group
        Route::group(['prefix' => 'company-transporter'], function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::get('/private-load-bulk', [CompanyController::class, 'privateLoadBulkGet']);
            Route::get('/private-load-package', [CompanyController::class, 'privateLoadPackageGet']);
            Route::post('/store', [CompanyController::class, 'store']);
            Route::get('/search', [CompanyController::class, 'search']);
            Route::get('/pending', [CompanyController::class, 'pending']);
            Route::post('/status/{id}', [CompanyController::class, 'setStatus']);
            Route::get('/show/{id}', [CompanyController::class, 'show']);
            Route::post('/update/{id}', [CompanyController::class, 'update']);
            Route::delete('/destroy/{id}', [CompanyController::class, 'destroy']);
        });

        // load-board route group
        Route::group(['prefix' => 'load-board'], function () {

            Route::get('/', [LoadBoardController::class, 'index']);
            Route::post('/', [LoadBoardController::class, 'store']);
            Route::get('/{id}', [LoadBoardController::class, 'show']);
            Route::post('/order-assign', [LoadBoardController::class, 'orderAssign']);
            Route::post('/{load_boards}', [LoadBoardController::class, 'update']);
            Route::delete('/{load_boards}', [LoadBoardController::class, 'destroy']);
            Route::get('/status/{load_boards}', [LoadBoardController::class, 'status']);
        });


        // driver route group
        Route::group(['prefix' => 'broker'], function () {
            Route::get('/', [BrokerController::class, 'index']);
            Route::post('/store', [BrokerController::class, 'store']);
            Route::get('/search', [BrokerController::class, 'search']);
            Route::get('/pending', [AgentController::class, 'pending']);
            Route::post('/status/{id}', [BrokerController::class, 'setStatus']);
            Route::get('/show/{id}', [BrokerController::class, 'show']);
            Route::post('/update/{id}', [BrokerController::class, 'update']);
            Route::delete('/destroy/{id}', [BrokerController::class, 'destroy']);
        });


        // driver route group
        Route::group(['prefix' => 'customer'], function () {
            Route::get('/', [CustomerController::class, 'index']);
            Route::post('/store', [CustomerController::class, 'store']);
            Route::post('/bulk-upload', [CustomerController::class, 'bulkUpload']);
            Route::get('/search', [CustomerController::class, 'search']);
            Route::get('/pending', [CustomerController::class, 'pending']);
            Route::get('/confirmed', [CustomerController::class, 'confirmed']);
            Route::get('/banned', [CustomerController::class, 'banned']);
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
            Route::get('/send-to-loadboard/{id}', [SpecializedShipmentController::class, 'sendToLoadBoard']);
            Route::get('/show/{id}', [SpecializedShipmentController::class, 'show']);
            Route::post('/price/{id}', [SpecializedShipmentController::class, 'price']);
            // Route::post('/update/{id}', [SpecializedShipmentController::class, 'update']);
            Route::delete('/destroy/{id}', [SpecializedShipmentController::class, 'destroy']);
        });



        Route::group(['prefix' => 'referral'], function () {

            Route::get('list', [ReferralController::class, 'listReferrals']);
            Route::get('show/{user_id}', [ReferralController::class, 'viewRefeeres']);
        });
    });
});
