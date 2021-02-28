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
					
					Route::get('tak/adapilar/{id?}','TAKController@adaPilar')->name('admin.tak.adapilar');
					Route::get('tak/adakegiatan/{id?}','TAKController@adaKegiatan')->name('admin.tak.adakegiatan');
					Route::get('tak/adapartisipasi/{id?}','TAKController@adaPartisipasi')->name('admin.tak.adapartisipasi');
					
					Route::get('tak/pilartak/cek', 'TAKController@cekPilar')->name('admin.tak.pilartak.cek');
					Route::get('tak/kategoritak/cek', 'TAKController@cekKategori')->name('admin.tak.kategoritak.cek');
					Route::get('tak/kegiatantak/cek', 'TAKController@cekKegiatan')->name('admin.tak.kegiatantak.cek');
					Route::get('tak/partisipasitak/cek', 'TAKController@cekPartisipasi')->name('admin.tak.partisipasitak.cek');
					

					Route::post('tak/kategoritak/tambah', 'TAKController@tambahKategori')->name('admin.tak.kategoritak.tambah');
					Route::get('tak/kategoritak','TAKController@tbKategori')->name('admin.tak.kategoritak');
					Route::get('tak/kategoritak/{id}/edit','TAKController@editKategori')->name('admin.tak.kategoritak.edit');
					Route::delete('tak/kategoritak/tambah/{id}','TAKController@deleteKategori')->name('admin.tak.kategoritak.destroy');

					
					Route::post('tak/pilartak/tambah', 'TAKController@tambahPilar')->name('admin.tak.pilartak.tambah');
					Route::get('tak/pilartak','TAKController@tbPilar')->name('admin.tak.pilartak');
					Route::get('tak/pilartak/{id}/edit','TAKController@editPilar')->name('admin.tak.pilartak.edit');
					Route::delete('tak/pilartak/tambah/{id}','TAKController@deletePilar')->name('admin.tak.pilartak.destroy');

					Route::post('tak/kegiatantak/tambah', 'TAKController@tambahKegiatan')->name('admin.tak.kegiatantak.tambah');
					Route::get('tak/kegiatantak','TAKController@tbKegiatan')->name('admin.tak.kegiatantak');
					Route::get('tak/kegiatantak/{id}/edit','TAKController@editKegiatan')->name('admin.tak.kegiatantak.edit');
					Route::delete('tak/kegiatantak/tambah/{id}','TAKController@deleteKegiatan')->name('admin.tak.kegiatantak.destroy');
					
				
					Route::post('tak/partisipasitak/tambah', 'TAKController@tambahPartisipasi')->name('admin.tak.partisipasitak.tambah');
					Route::get('tak/partisipasitak','TAKController@tbPartisipasi')->name('admin.tak.partisipasitak');
					Route::get('tak/partisipasitak/{id}/edit','TAKController@editPartisipasi')->name('admin.tak.partisipasitak.edit');
					Route::delete('tak/partisipasitak/tambah/{id}','TAKController@deletePartisipasi')->name('admin.tak.partisipasitak.destroy');
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