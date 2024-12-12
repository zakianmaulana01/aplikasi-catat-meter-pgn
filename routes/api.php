<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/provinsi', 'Api\WilayahIDController@getProvinsi');
Route::get('/kabkota/{provinsiId}', 'Api\WilayahIDController@getKabKota');
Route::get('/kecamatan/{kabkotaId}', 'Api\WilayahIDController@getKecamatan');
Route::get('/kodepos/{kabkotaId}/{kecamatanId}', 'Api\WilayahIDController@getKodePos');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
