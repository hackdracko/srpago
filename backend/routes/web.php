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
$version = '/apiv1';

Route::get('/', function () {
    return view('welcome');
});

Route::get($version . '/saveZipCodes', 'GasStationController@saveZipCodes');
Route::get($version . '/states', 'GasStationController@getStates');
Route::get($version . '/municipalities/{state}', 'GasStationController@getMunicipalities');
Route::get($version . '/zip-codes/{state}/{municipality}', 'GasStationController@getZipCodes');
Route::get($version . '/gasStations', 'GasStationController@index');
