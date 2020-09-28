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
    return view('welcome');
});

Route::get('/saveZipCodes', 'GasStationController@saveZipCodes');
Route::get('/states', 'GasStationController@getStates');
Route::get('/municipalities/{state}', 'GasStationController@getMunicipalities');
Route::get('/zip-codes/{state}/{municipality}', 'GasStationController@getZipCodes');
Route::get('/gasStations', 'GasStationController@index');
