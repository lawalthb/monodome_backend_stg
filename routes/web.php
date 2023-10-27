<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});




Route::prefix('adminpanel')->name('adminpanel.')->group(function () {
    Route::get('/', function () {
        return view('adminpanel.login');
    });
    Route::get('/agents', function () {
        return view('adminpanel.agents.index');
    });


});


require __DIR__ . '/auth.php';
