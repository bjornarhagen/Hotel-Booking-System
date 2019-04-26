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

Route::get('/', 'SiteController@index')->name('site.index');

Auth::routes(['verify' => true]);
Route::get('epost-bekreftet', 'Auth\VerificationController@complete');

Route::get('konto', 'UserController@show')->name('user.show');
Route::post('konto', 'UserController@update')->name('user.update');

Route::get('kontrollpanel', 'DashboardController@index')->name('dashboard.index');
