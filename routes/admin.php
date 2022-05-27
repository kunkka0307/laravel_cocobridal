<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web & admin" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'guest'], function() {
    Route::get('/', 'AuthController@showLoginForm')->name('login');
});

Route::group(['middleware' => 'auth.admin'], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});