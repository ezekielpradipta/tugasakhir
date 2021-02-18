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
		
    });
});

Route::group(['middleware' => ['auth']], function () {
	Route::namespace('Auth')->group(function(){
		Route::get('logout', 'LoginController@logout')->name('logout');
		Route::get('dashboard','LoginController@cekRole')->name('dashboard');
	});
	Route::group(['middleware'=>['admin']],function(){
		Route::namespace('Admin')->group(function(){
			Route::prefix('admin')->group(function(){
				Route::get('/', 'DashboardController@dashboard')->name('admin.dashboard.index');

				Route::prefix('data')->group(function(){
					Route::resource('dosen','DosenController',['as'=>'admin'])->except('show');
					Route::post('dosen/update', 'DosenController@updateDong')->name('admin.dosen.updateDong');
					Route::post('dosen/cekemail', 'DosenController@cekEmail')->name('admin.dosen.cekEmail');
					Route::post('dosen/cekusername', 'DosenController@cekUsername')->name('admin.dosen.cekUsername');
					Route::post('dosen/cekNIDN', 'DosenController@cekNIDN')->name('admin.dosen.cekNIDN');

					Route::resource('tak','TAKController',['as'=>'admin'])->except('show');


					Route::post('tak/kategoritak/tambah', 'TAKController@tambahKategoriTak')->name('admin.tak.kategoritak.tambah');
					Route::get('tak/kategoritak/cek', 'TAKController@cekKategoriTak')->name('admin.tak.kategoritak.cek');
					Route::get('tak/kategoritak','TAKController@tableKategoriTak')->name('admin.tak.kategoritak');
					Route::get('tak/kategoritak/{id}/edit','TAKController@editKategoriTak')->name('admin.tak.kategoritak.edit');
					Route::delete('tak/kategoritak/tambah/{id}','TAKController@destroyKategoriTak')->name('admin.tak.kategoritak.destroy');
				});
				Route::prefix('config')->group(function(){
					Route::resource('prodi','ProdiController',['as'=>'admin'])->except('show');
					Route::post('prodi/cekNamaProdi', 'ProdiController@cekNamaProdi')->name('admin.prodi.cekNamaProdi');
					Route::resource('angkatan','AngkatanController',['as'=>'admin'])->except('show');
					
				});
			});
		});
	});
	
});