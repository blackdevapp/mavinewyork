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

/** add name to all routes , to check where are they and seperate by dash (-) @by: @MAGIC 20190925 */
/** we use 'admin' or 'nonadmin' for the first name of the route @by: @MAGIC 20190925 */
/** we should use 'request.data' middleware for every request */
Route::get(config('app.admin_url'), 'adminController@home')->name('admin-home')->middleware('request.data','auth');

Route::get(config('app.admin_url').'/login', 'adminController@showLogin')->name('admin-login')->middleware('request.data','guest');
Route::post(config('app.admin_url').'/login', 'adminController@showLogin')->name('admin-login')->middleware('request.data','guest');

Route::get(config('app.admin_url').'/logout', 'adminController@logout')->name('admin-logout')->middleware('request.data','auth');



Route::view('/{path?}', 'app');
