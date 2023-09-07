<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CountryController;
use App\Http\Controllers\Api\v1\auth\AuthController;
// use App\Http\Controllers\Api\v1\Customers\LoadTypeController;
use App\Http\Controllers\Api\v1\Agents\AgentController;
use App\Http\Controllers\Api\v1\Customers\LoadBulkController;
use App\Http\Controllers\Api\v1\Customers\LoadTypeController;
use App\Http\Controllers\Api\v1\Customers\LoadBoardController;
use App\Http\Controllers\Api\v1\Customers\LoadPackageController;
use App\Http\Controllers\Api\v1\customers\VehicleMakeController;
use App\Http\Controllers\Api\v1\customers\VehicleTypeController;
use App\Http\Controllers\Api\v1\auth\EmailVerificationController;
use App\Http\Controllers\Api\v1\customers\VehicleModelController;
use App\Http\Controllers\Api\v1\Customers\LoadCarClearingController;

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
        Route::get('/logout', [AuthController::class, 'logout']);
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



        // load-specialized  route
        Route::get('/load-specialized', [LoadBulkController::class, 'index']);
        Route::post('/load-specialized', [LoadBulkController::class, 'store']);
        Route::get('/load-specialized/{id}', [LoadBulkController::class, 'show']);
        Route::post('/load-specialized/{loadBulk}', [LoadBulkController::class, 'update']);
        Route::delete('/load-specialized/{id}', [LoadBulkController::class, 'destroy']);

        // load board route
        Route::get('/load-board', [LoadBoardController::class, 'index']);
        Route::post('/load-board', [LoadBoardController::class, 'store']);
        Route::get('/load-board/{id}', [LoadBoardController::class, 'show']);
        Route::post('/load-board/{loadBulk}', [LoadBoardController::class, 'update']);
        Route::delete('/load-board/{id}', [LoadBoardController::class, 'destroy']);
    });

    Route::group(['prefix' => 'agent'], function () {

        Route::get('/', [AgentController::class, 'index']);
        Route::post('/store', [AgentController::class, 'store']);
        Route::get('/show/{id}', [AgentController::class, 'show']);
        Route::post('/update/{id}', [AgentController::class, 'update']);
        Route::delete('/destroy/{id}', [AgentController::class, 'destroy']);
    });

    //vehicle route group here
    Route::group(['prefix' => 'vehicle', 'middleware' => 'auth:api'], function () {

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
});
