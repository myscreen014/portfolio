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


use App\Models\PageModel;

/* ADMIN */
Route::group(['prefix' => 'admin', 'middleware'=> ['auth', 'auth_administrator']], function () {

	// Admin home 
	Route::get('/', ['as'=>'admin.index', 'uses' => 'Admin\AdminController@index']);

	// Pages management
	Route::get('pages/{id}/delete', array('as' => 'admin.pages.delete', 'uses' => 'Admin\PagesComponent@delete'));
    Route::resource('pages', 'Admin\PagesComponent');

    // Galleries management
    Route::get('galleries/{id}/delete', array('as' => 'admin.galleries.delete', 'uses' => 'Admin\GalleriesComponent@delete'));
    Route::get('galleries/categories/{id}/delete', array('as' => 'admin.galleries.categories.delete', 'uses' => 'Admin\GalleriesCategoriesComponent@delete'));
    Route::resource('galleries/categories', 'Admin\GalleriescategoriesComponent');
    Route::resource('galleries', 'Admin\GalleriesComponent');

    // Administrators management
    Route::get('administrators/{id}/delete', array('as' => 'admin.administrators.delete', 'uses' => 'Admin\AdministratorsComponent@delete'));
    Route::resource('administrators', 'Admin\AdministratorsComponent');

    // Files management
    Route::get('files/{id}/edit',['as' => 'admin.files.edit', 'uses' => 'Admin\FilesComponent@editAjax']);
    Route::put('files/{id}/update',['as' => 'admin.files.update', 'uses' => 'Admin\FilesComponent@updateAjax']);
    Route::get('files/{id}/show',['as' => 'admin.files.show', 'uses' => 'Admin\FilesComponent@showAjax']);
    Route::get('files/{id}/delete',['as' => 'admin.files.delete', 'uses' => 'Admin\FilesComponent@deleteAjax']);
    Route::post('files/getitemfilebrowser',['as' => 'admin.files.getitemfilebrowser', 'uses' => 'Admin\FilesComponent@getitemfilebrowserAjax']);
    Route::post('files/reorder',['as' => 'admin.files.reorder', 'uses' => 'Admin\FilesComponent@reorderAjax']);
    Route::delete('files/{id}/destroy',['as' => 'admin.files.destroy', 'uses' => 'Admin\FilesComponent@destroyAjax']);
 	Route::post('files/store',['as' => 'admin.files.store', 'uses' => 'Admin\FilesComponent@store']);


    // Models management
     Route::post('models/reorder',['as' => 'admin.models.reorder', 'uses' => 'Admin\ModelsController@reorderAjax']);

});
 

/* SITE */
Route::get('sitemap.xml', 'Site\SitemapController@index');

Route::get('files/{thumbnail}/{name}',['as' => 'picture', 'uses' => 'Site\FilesController@picture']);
Route::get('files/{name}',['as' => 'file', 'uses' => 'Site\FilesController@file']);

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/register/message', ['as' => 'register.message', 'uses' => 'Auth\AuthController@registerMessage']);
Route::get('auth/confirmation/{id}/{key}', ['as' => 'auth.confirmation', 'uses' => 'Auth\AuthController@confirmation']);
 
// Public
Route::group(['prefix' => '/', 'middleware'=> 'site'], function () {
    
    // Pages
    Route::get('',['as' => 'page', 'uses' => 'Site\PagesController@index']);
    Route::get('{slug?}/{params?}',array(
        'as' => 'page', 
        'uses' => 'Site\PagesController@index'
    ))->where('params', '(.*)');
   

});

