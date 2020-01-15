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
    Route::get('/stop-impersonate', 'UserController@stopImpersonate')->name('users.stop-impersonate');

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
        Route::get('/trash', 'UserController@trash')->name('administrator.users.trash');
        Route::get('/delete', 'UserController@delete')->name('administrator.users.delete');
        Route::get('/restore', 'UserController@restore')->name('administrator.users.restore');
        Route::get('/{user}/impersonate', 'UserController@impersonate')->name('administrator.users.impersonate');
    });
    
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RoleController@index')->name('administrator.roles');
        Route::post('/', 'RoleController@index')->name('administrator.roles');
        Route::get('/create', 'RoleController@create')->name('administrator.roles.create');
        Route::get('/{role}/edit', 'RoleController@edit')->name('administrator.roles.edit');
        Route::post('/save', 'RoleController@save')->name('administrator.roles.save');
        Route::post('/{role}/update', 'RoleController@update')->name('administrator.roles.update');
        Route::get('/trash', 'UserController@delete')->name('administrator.roles.trash');
        Route::get('/delete', 'RoleController@delete')->name('administrator.roles.delete');
        Route::get('/restore', 'UserController@delete')->name('administrator.roles.restore');
    });
    
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', 'PermissionController@index')->name('administrator.permissions');
        Route::post('/', 'PermissionController@index')->name('administrator.permissions');
        Route::get('/create', 'PermissionController@create')->name('administrator.permissions.create');
        Route::get('/{permission}/edit', 'PermissionController@edit')->name('administrator.permissions.edit');
        Route::post('/save', 'PermissionController@save')->name('administrator.permissions.save');
        Route::post('/{permission}/update', 'PermissionController@update')->name('administrator.permissions.update');
        Route::get('/trash', 'UserController@delete')->name('administrator.permissions.trash');
        Route::get('/delete', 'PermissionController@delete')->name('administrator.permissions.delete');
        Route::get('/restore', 'UserController@delete')->name('administrator.permissions.restore');
    });
    
});
