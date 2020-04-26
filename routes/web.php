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
    Route::get('/home', 'HomeController@index')->name('home');

    // route hari efektif
    Route::group(["prefix" => "hari-efektif","as" => "hari-efektif."],function() {
      Route::get('/','HariEfektifController@index')->name('index');
      Route::put('/update/{data}','HariEfektifController@update')->name('update');
    });
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
});