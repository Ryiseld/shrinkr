<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');
	
Route::post('/url/create', 'UrlController@create');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', 'DashboardController@index');

	Route::get('/dashboard/{hash}', 'DashboardController@show');
	Route::get('/dashboard/{hash}/delete', 'DashboardController@delete');
});

Route::get('/{hash}', 'UrlController@show');
