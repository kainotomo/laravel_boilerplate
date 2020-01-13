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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    // Only authenticated users may enter...
    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['middleware' => ['verified']], function () {
        // Only verified users may enter...
        Route::get('/profile', 'HomeController@index')->name('profile');
    });

    Route::group(['middleware' => ['permission:view']], function () {
        // Only permission:view users may enter...
        Route::get('/view', 'HomeController@index')->name('profile');
    });
});

Route::group(['namespace' => 'Administrator', 'prefix' => 'administrator', 'middleware' => ['permission:administrator']], function () {
    // Only administrator users may enter...
    Route::get('/', 'HomeController@index')->name('administrator');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('administrator.users');
        Route::post('/', 'UserController@index')->name('administrator.users');
        Route::get('/create', 'UserController@create')->name('administrator.users.create');
        Route::get('/{user}/edit', 'UserController@edit')->name('administrator.users.edit');
        Route::post('/save', 'UserController@save')->name('administrator.users.save');
        Route::post('/{user}/update', 'UserController@update')->name('administrator.users.update');
        Route::get('/delete', 'UserController@delete')->name('administrator.users.delete');
    });
});
