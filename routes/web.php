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

Route::get('/', ['as' => 'theme.index', 'uses' => 'TemplateController@index']);
Route::get('/{slug}', ['as' => 'theme.page', 'uses' => 'TemplateController@page']);
Route::group(['prefix' => 'category'], function() {
    Route::get('/{category}', ['as' => 'theme.category', 'uses' => 'TemplateController@category']);
});

Route::group(['prefix' => 'archive'], function() {
    return 'A';
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
