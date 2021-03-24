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
Route::get('test', function () {
	event(new App\Events\TakMasuk('Someone'));
	return "Event has been sent!";
});
Route::group(['middleware' => ['guest']], function () {  
    Route::namespace('Auth')->group(function(){  
		Route::get('login', 'LoginController@login')->name('login');
		Route::post('login', 'LoginController@ceklogin')->name('login');
		Route::post('login/daftar', 'LoginController@daftar')->name('daftar');
		Route::post('login/cekEmail', 'LoginController@cekEmail')->name('login.cekEmail');
		Route::post('login/cekUsername', 'LoginController@cekUsername')->name('login.cekUsername');
		Route::get('login/cekDosen', 'LoginController@cekDosen')->name('login.cekDosen');
		Route::get('login/cekAngkatan', 'LoginController@cekAngkatan')->name('login.cekAngkatan');
		Route::get('login/cekProdi', 'LoginController@cekProdi')->name('login.cekProdi');

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

					Route::resource('mahasiswa','MahasiswaController',['as'=>'admin'])->except('show');
					Route::post('mahasiswa/cekemail', 'MahasiswaController@cekEmail')->name('admin.mahasiswa.cekEmail');
					Route::post('mahasiswa/cekusername', 'MahasiswaController@cekUsername')->name('admin.mahasiswa.cekUsername');
					Route::get('mahasiswa/cekDosen', 'MahasiswaController@cekDosen')->name('admin.mahasiswa.cekDosen');
					Route::get('mahasiswa/cekAngkatan', 'MahasiswaController@cekAngkatan')->name('admin.mahasiswa.cekAngkatan');
					Route::get('mahasiswa/cekProdi', 'MahasiswaController@cekProdi')->name('admin.mahasiswa.cekProdi');


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
	Route::group(['middleware'=>['mahasiswa']],function(){
		Route::namespace('Mahasiswa')->group(function(){
			Route::prefix('mahasiswa')->group(function(){
				Route::get('/','DashboardController@index')->name('mahasiswa.index');
				Route::resource('inputtak','InputtakController',['as'=>'mahasiswa'])->only(['index','store']);
				Route::get('tak/cekKegiatan/{id?}','InputtakController@cekKegiatan')->name('mahasiswa.tak.cekKegiatan');
				Route::get('tak/cekPilar/{id?}','InputtakController@cekPilar')->name('mahasiswa.tak.cekPilar');
				Route::get('tak/cekPartisipasi/{id?}','InputtakController@cekPartisipasi')->name('mahasiswa.tak.cekPartisipasi');
				
				Route::resource('daftartak','DaftartakController',['as'=>'mahasiswa'])->except('show');
				Route::get('daftartak/pilartak/cek', 'DaftartakController@cekPilar')->name('mahasiswa.daftartak.pilartak.cek');
				Route::get('daftartak/kategoritak/cek', 'DaftartakController@cekKategori')->name('mahasiswa.daftartak.kategoritak.cek');
				Route::get('daftartak/kegiatantak/cek', 'DaftartakController@cekKegiatan')->name('mahasiswa.daftartak.kegiatantak.cek');
				Route::get('daftartak/partisipasitak/cek', 'DaftartakController@cekPartisipasi')->name('mahasiswa.daftartak.partisipasitak.cek');
			
				Route::get('daftartak/adapilar/{id?}','DaftartakController@adaPilar')->name('mahasiswa.daftartak.adapilar');
				Route::get('daftartak/adakegiatan/{id?}','DaftartakController@adaKegiatan')->name('mahasiswa.daftartak.adakegiatan');
				Route::get('daftartak/adapartisipasi/{id?}','DaftartakController@adaPartisipasi')->name('mahasiswa.daftartak.adapartisipasi');
				
				Route::get('daftartak/{id}/bukti','DaftartakController@getBukti')->name('mahasiswa.bukti');
				Route::get('daftartak/{fileId}/cetakBukti','DaftartakController@cetakBukti')->name('mahasiswa.cetakBukti');
				Route::get('daftartak/{id}/editBukti','DaftartakController@editBukti')->name('mahasiswa.editBukti');
				Route::post('daftartak/tambahBukti','DaftartakController@tambahBukti')->name('mahasiswa.tambahBukti');
			});
		});
	});
	Route::group(['middleware'=>['dosen']],function(){
		Route::namespace('Dosen')->group(function(){
			Route::prefix('dosen')->group(function(){
				Route::get('/', 'DashboardController@dashboard')->name('dosen.dashboard.index');
				
				Route::resource('daftarmahasiswa','DaftarMahasiswaController',['as'=>'dosen'])->except('show');
				Route::get('daftarmahasiswa/tak','DaftarMahasiswaController@tbTak')->name('dosen.daftarmahasiswa.tak');
				Route::get('daftarmahasiswa/{id}/tak','DaftarMahasiswaController@editTak')->name('dosen.daftarmahasiswa.tak.id');
				Route::get('daftarmahasiswa/{id}/bukti','DaftarMahasiswaController@getBukti')->name('dosen.daftarmahasiswa.tak.bukti');
				Route::get('daftarmahasiswa/{fileId}/cetakBukti','DaftarMahasiswaController@cetakBukti')->name('dosen.daftarmahasiswa.tak.cetakBukti');
				Route::get('daftarmahasiswa/{id}/status','DaftarMahasiswaController@gantiStatus')->name('dosen.daftarmahasiswa.tak.status');
				
				Route::resource('takmasuk','TakMasukController',['as'=>'dosen'])->except('show');
				Route::get('takmasuk/{id}/bukti','TakMasukController@getBukti')->name('dosen.takmasuk.bukti');
				Route::get('takmasuk/{fileId}/cetakBukti','TakMasukController@cetakBukti')->name('dosen.takmasuk.cetakBukti');
				Route::get('takmasuk/{id}/status','TakMasukController@gantiStatus')->name('dosen.takmasuk.status');
				Route::get('takmasuk/adapilar/{id?}','TakMasukController@adaPilar')->name('dosen.takmasuk.adapilar');
				Route::get('takmasuk/adakegiatan/{id?}','TakMasukController@adaKegiatan')->name('dosen.takmasuk.adakegiatan');
				Route::get('takmasuk/adapartisipasi/{id?}','TakMasukController@adaPartisipasi')->name('dosen.takmasuk.adapartisipasi');
				Route::get('daftartak/kategoritak/cek', 'TakMasukController@cekKategori')->name('dosen.takmasuk.kategoritak.cek');
				
				
			});
		});
	});
	
});