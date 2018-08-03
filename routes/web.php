<?php

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
    return view('index');
});

Route::post('csv/process','CsvController@process');
Route::get('csv/{id}','CsvController@getResult');
Route::get('make/{id}','MakeController@getMake');
Route::get('makes','MakeController@getMakes');