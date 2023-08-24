<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\auth\AuthController;


Route::group(['namespace' => 'api\v1', 'prefix' => 'v1'], function () {


    // user registration namespace
    Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);


});


});

?>
