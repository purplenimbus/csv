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

Auth::routes();
Route::get('/logout' , 'Auth\LoginController@logout'); //logout hack

Route::get('/', 'HomeController@index')->name('home');
Route::post('upload','WordpressController@processFile');
Route::get('/user/{uuid}/files', 'WordpressController@getFiles')->name('files');

