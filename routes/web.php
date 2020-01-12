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
    });