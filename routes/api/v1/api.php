<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'api\v1', 'prefix' => 'v1'], function () {


    // user registration namespace
    Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {


});


});

?>
