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

Route::get(config('app.admin_url'), 'adminController@index');
Route::get(config('app.admin_url').'/login', 'adminController@showLogin');

Route::view('/{path?}', 'app');