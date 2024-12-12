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

Route::get('/login', 'Auth\LoginController@login_view');
Route::post('/login_post', 'Auth\LoginController@login_post');
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['operator']], function (){
    Route::group(['prefix' => 'catat-meter-gas'], function () {
        Route::get('/', 'CatatMeterGasController@index');
        Route::get('/cari-data-pelanggan/{id_pelanggan}', 'CatatMeterGasController@cari_data_pelanggan');
        Route::post('/save-catat-meter', 'CatatMeterGasController@store_catat_meter');
    });
});

Route::group(['middleware' => ['admin']], function (){
    Route::get('/', 'DashboardController@index');
    Route::get('/get-data', 'DashboardController@get_data');

    Route::group(['prefix' => 'master-data'], function () {
        Route::get('/pelanggan', 'PelangganController@index');
        Route::get('/pelanggan/list-data', 'PelangganController@list_data');
        Route::post('/pelanggan/store', 'PelangganController@store');
        Route::get('/pelanggan/detail/{id}', 'PelangganController@detail');
        Route::get('/pelanggan/edit/{id}', 'PelangganController@edit');
        Route::post('/pelanggan/delete/{id}', 'PelangganController@destroy');

        Route::get('/user', 'UserController@index');
        Route::get('/user/list-data', 'UserController@list_data');
        Route::post('/user/store', 'UserController@store');
        Route::get('/user/edit/{id}', 'UserController@edit');
        Route::post('/user/delete/{id}', 'UserController@destroy');
    });
});


// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
