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
    return view('auth.login');
});
Route::group(['middleware' => ['guest']], function () {  
    Route::namespace('Auth')->group(function(){  
	Route::get('login', 'LoginController@login')->name('login');
	Route::post('login', 'LoginController@ceklogin')->name('login');
	Route::get('register', 'RegisterController@register')->name('register');
	Route::post('register', 'RegisterController@daftar')->name('register');
    });
});