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
	Route::post('cekEmail', 'PublicController@cekEmail')->name('cekEmail');
	Route::post('cekUsername', 'PublicController@cekUsername')->name('cekUsername');
	Route::post('cekNidn', 'PublicController@cekNidn')->name('cekNidn');

	Route::get('getDosen', 'PublicController@getDosen')->name('getDosen');
	Route::get('getAngkatan', 'PublicController@getAngkatan')->name('getAngkatan');
	Route::get('getProdi', 'PublicController@getProdi')->name('getProdi');

	Route::get('tak/getPilar', 'PublicController@getPilarTak')->name('tak.get.pilar');
	Route::get('tak/getKategori', 'PublicController@getKategoriTak')->name('tak.get.kategori');
	Route::get('tak/getKegiatan', 'PublicController@getKegiatanTak')->name('tak.get.kegiatan');
	Route::get('tak/getPartisipasi', 'PublicController@getPartisipasiTak')->name('tak.get.partisipasi');

	Route::get('tak/getPilar/{id?}','PublicController@getPilarTakById')->name('tak.get.pilar.id');
	Route::get('tak/getKegiatan/{id?}','PublicController@getKegiatanTakById')->name('tak.get.kegiatan.id');
	Route::get('tak/getPartisipasi/{id?}','PublicController@getPartisipasiTakById')->name('tak.get.partisipasi.id');
					
Route::group(['middleware' => ['guest']], function () {  
    Route::namespace('Auth')->group(function(){  
		Route::get('login', 'LoginController@login')->name('login');
		Route::post('login', 'LoginController@ceklogin')->name('login');
		Route::post('login/daftar', 'LoginController@daftar')->name('daftar');
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
					
					Route::resource('mahasiswa','MahasiswaController',['as'=>'admin'])->except('show');
					

					Route::resource('tak','TAKController',['as'=>'admin'])->except('show');
					
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
					
					Route::resource('takkumulatif', 'TakkumulatifController',['as'=>'admin'])->except('show');
					Route::get('takkumulatif/data', 'TakkumulatifController@getData',['as'=>'admin'])->name('admin.takkumulatif.data');
			
					Route::get('slider','SliderController@index',['as'=>'admin'])->name('admin.slider.index');
					Route::post('slider/tambah','SliderController@slider_tambah',['as'=>'admin'])->name('admin.slider.inputtak.tambah');
					Route::get('slider/{id}/edit','SliderController@slider_edit',['as'=>'admin'])->name('admin.slider.inputtak.edit');
					Route::delete('slider/tambah/{id}','SliderController@slider_delete',['as'=>'admin'])->name('admin.slider.inputtak.delete');

					Route::resource('badge', 'BadgeController',['as'=>'admin'])->except('show');
					
				});
				Route::resource('profile', 'ProfileController',['as'=>'admin'])->except('show');
				Route::get('profile/data', 'ProfileController@getData',['as'=>'admin'])->name('admin.profile.data');
			});
		});
	});
	Route::group(['middleware'=>['mahasiswa']],function(){
		Route::namespace('Mahasiswa')->group(function(){
			Route::prefix('mahasiswa')->group(function(){
				Route::get('/','DashboardController@index')->name('mahasiswa.index');
				Route::get('dashboard', 'DashboardController@isiDashboard')->name('mahasiswa.dashboard');
				Route::get('dashboard/{id}/detail', 'DashboardController@DetailNotif')->name('mahasiswa.notif.detail');
				Route::get('dashboard/{id}/read', 'DashboardController@ReadNotif')->name('mahasiswa.notif.read');
				Route::get('dashboard/{id}/tutorial', 'DashboardController@DetailTutorial')->name('mahasiswa.notif.tutorial');
				Route::get('dashboard/{id}/tutorial/read', 'DashboardController@ReadTutorial')->name('mahasiswa.notif.tutorial.read');
				
				Route::get('status', 'DashboardController@DaftarMenu')->name('mahasiswa.daftarmenu');
				Route::get('dashboard/{id}/badge', 'DashboardController@changeBadge')->name('mahasiswa.notif.badge');
				Route::get('badge/tutorial', 'DashboardController@badgeTutorial')->name('mahasiswa.badge.tutorial');
				Route::get('badge', 'DashboardController@getBadge')->name('mahasiswa.badge');

				Route::resource('tutorial','TutorialController',['as'=>'mahasiswa'])->only(['index','store'])->middleware('tutorial');
				
				Route::get('slider', 'TutorialController@slider')->name('mahasiswa.slider');
				Route::resource('validasi','ValidasiController',['as'=>'mahasiswa'])->only(['index','store']);
				
				Route::resource('leaderboard', 'LeaderboardController',['as'=>'mahasiswa'])->only(['index']);

				Route::resource('inputtak','InputtakController',['as'=>'mahasiswa'])->only(['index','store'])->middleware('badge');
				
				Route::resource('daftartak','DaftartakController',['as'=>'mahasiswa'])->except('show');
			
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
				Route::get('notif', 'DashboardController@notif')->name('dosen.notif');
				Route::resource('daftarmahasiswa','DaftarMahasiswaController',['as'=>'dosen'])->except('show');
				Route::get('daftarmahasiswa/tak','DaftarMahasiswaController@tbTak')->name('dosen.daftarmahasiswa.tak');
				Route::get('daftarmahasiswa/{id}/tak','DaftarMahasiswaController@editTak')->name('dosen.daftarmahasiswa.tak.id');
				Route::get('daftarmahasiswa/{id}/bukti','DaftarMahasiswaController@getBukti')->name('dosen.daftarmahasiswa.tak.bukti');
				Route::get('daftarmahasiswa/{fileId}/cetakBukti','DaftarMahasiswaController@cetakBukti')->name('dosen.daftarmahasiswa.tak.cetakBukti');
				Route::get('daftarmahasiswa/{id}/status','DaftarMahasiswaController@gantiStatus')->name('dosen.daftarmahasiswa.tak.status');
				
				Route::resource('profile', 'ProfileController',['as'=>'dosen'])->except('show');
				Route::get('profile/data', 'ProfileController@getData',['as'=>'admin'])->name('dosen.profile.data');
				
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