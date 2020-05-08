<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'confirm' => false, // Password Confirm Routes...
  'verify' => false, // Email Verification Routes...
]);


Route::group(['middleware' => 'auth'],function(){
    Route::get('/', function () {
        return view('welcome');
    });


    Route::group(['middleware' => 'Roles:Super Admin'], function () {
      // route hari efektif
      Route::group(['prefix' => 'hari-efektif', 'as' => 'hari-efektif.'],function() {
        Route::get('/', 'HariEfektifController@index')
          ->name('index');
        Route::put('/update/{data}', 'HariEfektifController@update')
          ->name('update');
      });
  
      // route jurusan
      Route::resource('jurusan', 'JurusanController')->except([
        'show'
      ]);
  
      // route user
      Route::resource('/user', 'UserController');
  
      // route user role
      Route::get('/user/{user}/addrole', 'UserController@addRole')
        ->name('user.add-role');
      Route::post('/user/{user}/storerole', 'UserController@storeRole')
        ->name('user.store-role');
      Route::delete('/user/{user}/removerole/{userRole}', 'UserController@removeRole')
        ->name('user.remove-role');
      Route::post('/user/{user}/reset-password', 'UserController@resetPassword')
        ->name('user.reset-password');
  
      //route kategori point
      Route::resource('kategori-point', 'KategoriPointController');
  
      // route point
      Route::get('/kategori-point/{kategori_point}/point', 'PointController@create')
        ->name('kategori-point.show.create');
      Route::post('/kategori-point/{kategori_point}/point', 'PointController@store')
        ->name('kategori-point.show.store');
      Route::get('/kategori-point/{kategori_point}/point/{point}/edit', 'PointController@edit')
        ->name('kategori-point.show.edit');
      Route::patch('/kategori-point/{kategori_point}/point/{point}/update', 'PointController@update')
        ->name('kategori-point.show.update');
      Route::delete('/kategori-point/{kategori_point}/point/{point}', 'PointController@destroy')
        ->name('kategori-point.show.destroy');

      //route hari tidak efektif
      Route::resource('hari-tidak-efektif', 'HariTidakEfektifController')->except([
        'show'
      ]);
        
    });




    // route kelas
    Route::resource('kelas', 'KelasController')->parameters([
      'kelas' => 'kelas'
    ])->middleware('Roles:Super Admin|Wali Kelas');

    // route siswa
    Route::resource('/kelas/{kelas}/siswa', 'SiswaController')->except([
      'index'
    ])->middleware('Roles:Super Admin|Wali Kelas');

    // route kasus
    Route::resource('/kasus', 'KasusController')
      ->middleware('Roles:Super Admin|Petugas Konseling');
    Route::post('kasus/get_siswa/{siswa}', 'KasusController@getSiswa')
      ->middleware('Roles:Super Admin|Petugas Konseling');
    Route::post('kasus/get_point/{point}', 'KasusController@getPoint')
      ->middleware('Roles:Super Admin|Petugas Konseling');
    Route::put('kasus/{kasus}/rollback', 'KasusController@rollback')
      ->middleware('Roles:Super Admin|Petugas Konseling')
      ->name('kasus.rollback');

    //  route absensi
    Route::get('/absensi', 'AbsensiController@index')
      ->middleware('Roles:Super Admin|Petugas Absensi')
      ->name('absensi.index');
    Route::get('/absensi/{kelas}', 'AbsensiController@showKelas')
      ->middleware('Roles:Super Admin|Petugas Absensi')
      ->name('absensi.show-kelas');
    Route::get('/absensi/{kelas}/create', 'AbsensiController@create')
      ->middleware('Roles:Super Admin|Petugas Absensi')
      ->name('absensi.create');
    Route::POST('/absensi/{kelas}/store', 'AbsensiController@store')
      ->middleware('Roles:Super Admin|Petugas Absensi')
      ->name('absensi.store');
    Route::get('/absensi/{kelas}/edit', 'AbsensiController@edit')
      ->middleware('Roles:Super Admin')
      ->name('absensi.edit');
    Route::POST('/absensi/{kelas}/edit/get-data', 'AbsensiController@getDataSiswa')
      ->middleware('Roles:Super Admin|Petugas Absensi')
      ->name('absensi.edit.get-data');
    Route::PUT('/absensi/{kelas}/update', 'AbsensiController@update')
      ->middleware('Roles:Super Admin|Petugas Absensi')
      ->name('absensi.update');
});




/*
|--------------------------------------------------------------------------
| Web Routes Data Tables
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware'=> 'auth', 'prefix' => 'datatables', 'as' => 'datatables.'],function(){
    Route::get('hari-efektif/json', 'HariEfektifController@json')
      ->middleware('Roles:Super Admin')
      ->name('hari-efektif');

    Route::get('jurusan/json', 'JurusanController@json')
      ->middleware('Roles:Super Admin')
      ->name('jurusan');

    Route::get('kelas/json', 'KelasController@json')
      ->middleware('Roles:Super Admin|Wali Kelas')
      ->name('kelas');

    Route::get('kelas/{kelas}/siswa/json', 'SiswaController@json')
      ->middleware('Roles:Super Admin|Wali Kelas')
      ->name('kelas.show.siswa');

    Route::get('/kelas/{kelas}/siswa/{siswa}/pelanggaran/json', 'SiswaController@getPelanggaran')
      ->middleware('Roles:Super Admin|Wali Kelas')
      ->name('kelas.show.siswa.pelanggaran');

    Route::get('/kelas/{kelas}/siswa/{siswa}/penghargaan/json', 'SiswaController@getPenghargaan')
      ->middleware('Roles:Super Admin|Wali Kelas')
      ->name('kelas.show.siswa.penghargaan');

    Route::get('/users/json', 'UserController@json')
      ->middleware('Roles:Super Admin')
      ->name('user');

    Route::get('/hari-tidak-efektif/json', 'HariTidakEfektifController@json')
      ->middleware('Roles:Super Admin')
      ->name('hari-tidak-efektif');

    Route::get('/kategori-point/json', 'KategoriPointController@json')
      ->middleware('Roles:Super Admin')
      ->name('kategori-point');

    Route::get('kategori-point/{kategori_point}/point/json', 'PointController@json')
      ->middleware('Roles:Super Admin')
      ->name('kategori-point.show.point');

    Route::get('/kasus/json', 'KasusController@json')
      ->middleware('Roles:Super Admin|Petugas Konseling')
      ->name('kasus');

    Route::get('absensi/json', 'AbsensiController@json')
      ->middleware('Roles:Super Admin|Petugas Absensi')
      ->name('absensi');

    Route::get('absensi/{kelas}/json', 'AbsensiController@jsonSiswa')
      ->middleware('Roles:Super Admin|Petugas Absensi')
      ->name('absensi.siswa');

});




/*
|--------------------------------------------------------------------------
| Web Routes Select 2
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => 'auth', 'prefix' => 'select2', 'as' => 'select2.'],function(){
    Route::post('/kasus/kelas/{kelas}/siswa', 'KasusController@siswa')
      ->middleware('Roles:Super Admin|Petugas Konseling')
      ->name('kasus.siswa');

    Route::post('/kasus/{kategori_point}/point', 'KasusController@point')
      ->middleware('Roles:Super Admin|Petugas Konseling')
      ->name('kasus.point');

    Route::post('kelas/guru/json', 'KelasController@guru')
      ->middleware('Roles:Super Admin')
      ->name('kelas.guru');

});
