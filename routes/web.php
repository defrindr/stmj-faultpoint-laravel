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

    // route hari efektif
    Route::group(["prefix" => "hari-efektif","as" => "hari-efektif."],function() {
      Route::get('/','HariEfektifController@index')->name('index');
      Route::put('/update/{data}','HariEfektifController@update')->name('update');
    });
    // route jurusan
    Route::resource('jurusan','JurusanController')->except([
      'show'
    ]);
    // route kelas
    Route::resource('kelas','KelasController')->parameters([
      'kelas' => 'kelas'
    ]);
    Route::post('kelas/guru/json','KelasController@guru')->name('kelas.guru');
    // route siswa
    Route::resource('/kelas/{kelas}/siswa','SiswaController')->except([
      'index'
    ]);
    // route user
    Route::resource('/user','UserController');
    // route user role
    Route::get('/user/{user}/addrole','UserController@addRole')->name('user.add-role');
    Route::post('/user/{user}/storerole','UserController@storeRole')->name('user.store-role');
    Route::delete('/user/{user}/removerole/{userRole}','UserController@removeRole')->name('user.remove-role');
    Route::post('/user/{user}/reset-password','UserController@resetPassword')->name('user.reset-password');
    //route hari tidak efektif
    Route::resource('hari-tidak-efektif','HariTidakEfektifController')->except([
      'show'
    ]);
    //route kategori point
    Route::resource('kategori-point','KategoriPointController');
    // route point
    Route::get('/kategori-point/{kategori_point}/point','PointController@create')->name('kategori-point.show.create');
    Route::post('/kategori-point/{kategori_point}/point','PointController@store')->name('kategori-point.show.store');
    Route::get('/kategori-point/{kategori_point}/point/{point}/edit','PointController@edit')->name('kategori-point.show.edit');
    Route::patch('/kategori-point/{kategori_point}/point/{point}/update','PointController@update')->name('kategori-point.show.update');
    Route::delete('/kategori-point/{kategori_point}/point/{point}','PointController@destroy')->name('kategori-point.show.destroy');
    // route kasus
    Route::resource('/kasus','KasusController');
    Route::post('kasus/get_siswa/{siswa}', 'KasusController@getSiswa');
    Route::post('kasus/get_point/{point}', 'KasusController@getPoint');
});




/*
|--------------------------------------------------------------------------
| Web Routes Data Tables
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["middleware"=> "auth","prefix" => "datatables","as" => "datatables."],function(){
    Route::get("hari-efektif/json","HariEfektifController@json")->name("hari-efektif");
    Route::get("jurusan/json","JurusanController@json")->name("jurusan");
    Route::get("kelas/json","KelasController@json")->name("kelas");
    Route::get('kelas/{kelas}/siswa/json','SiswaController@json')->name('kelas.show.siswa');
    Route::get('/kelas/{kelas}/siswa/{siswa}/pelanggaran/json','SiswaController@getPelanggaran')->name('kelas.show.siswa.pelanggaran');
    Route::get('/kelas/{kelas}/siswa/{siswa}/penghargaan/json','SiswaController@getPenghargaan')->name('kelas.show.siswa.penghargaan');
    Route::get('/users/json','UserController@json')->name('user');
    Route::get('/hari-tidak-efektif/json','HariTidakEfektifController@json')->name('hari-tidak-efektif');
    Route::get('/kategori-point/json','KategoriPointController@json')->name('kategori-point');
    Route::get('kategori-point/{kategori_point}/point/json','PointController@json')->name('kategori-point.show.point');
    Route::get('/kasus/json','KasusController@json')->name('kasus');
});




/*
|--------------------------------------------------------------------------
| Web Routes Data Tables
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth', 'prefix' => 'select2', 'as' => 'select2.'],function(){
    Route::post('/kasus/kelas/{kelas}/siswa','KasusController@siswa')->name('kasus.siswa');
    Route::post('/kasus/{kategori_point}/point','KasusController@point')->name('kasus.point');
});
