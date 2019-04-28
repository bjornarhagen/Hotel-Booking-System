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


Route::prefix('kontrollpanel')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    
    Route::prefix('admin')->group(function () {
        Route::prefix('hoteller')->group(function () {
            Route::get('/', 'HotelController@index')->name('admin.hotel.index');
            Route::get('ny', 'HotelController@create')->name('admin.hotel.create');
            Route::post('lagre', 'HotelController@store')->name('admin.hotel.store');
            Route::get('{hotel}/rediger', 'HotelController@edit')->name('admin.hotel.edit');
            Route::patch('{hotel}/oppdater', 'HotelController@update')->name('admin.hotel.update');
            Route::get('{hotel}/fjern', 'HotelController@delete')->name('admin.hotel.delete');
            Route::delete('{hotel}/slett', 'HotelController@destroy')->name('admin.hotel.destroy');
        });
    });
});

Route::prefix('hoteller')->group(function () {
    Route::prefix('{hotel_slug}')->group(function () {
        Route::get('/', 'HotelController@show')->name('hotel.show');

        Route::prefix('booking')->group(function () {
            Route::get('steg-1', 'BookingController@show_step_1')->name('hotel.booking.step-1');
            Route::get('steg-2', 'BookingController@show_step_2')->name('hotel.booking.step-2');
        });
});
});