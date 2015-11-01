<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/* ADMIN */
Route::group(['prefix' => 'admin', 'middleware'=> 'auth'], function () {

	// Admin home 
	Route::get('/', ['as'=>'admin.index', 'uses' => 'Admin\AdminController@index']);

	// Pages management
    Route::resource('pages', 'Admin\PagesComponent');

    // Files management
 	Route::post('files/store',['as' => 'admin.files.store', 'uses' => 'Admin\FilesComponent@store']);

});
 

/* SITE */
Route::get('/file/{id}',['as' => 'file', 'uses' => 'FilesController@index']);

Route::group(['prefix' => '/', 'middleware'=> 'pages'], function () {

	Route::get('{slug?}',['as' => 'page', 'uses' => 'Site\PagesController@index']);

});



// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');