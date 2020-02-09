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
    return redirect()->route('admin.auth.signin');
});

// ADMIN PATH
Route::group(['prefix' => 'admin'], function() {

    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('/', ['as' => 'admin.dashboard.index', 'uses' => 'DashboardController@index'])->middleware('auth.shiza');
    });

    Route::group(['prefix' => 'auth'], function() {
        Route::get('/', ['as' => 'admin.auth.signin', 'uses' => 'AuthController@signIn']);
        Route::post('/', ['as' => 'admin.auth.signin.process', 'uses' => 'AuthController@signInProcess']);
        Route::get('/signout', ['as' => 'admin.auth.signout', 'uses' => 'AuthController@signOut']);
    });
    
});
