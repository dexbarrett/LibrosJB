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

Route::get('/{sortBy?}/{direction?}', 'BookController@index')
->where(['sortBy' => 'titulo|precio|autor', 'direction' => 'asc|desc']);

Route::get('books/{slug}', 'BookController@show');

Route::get('author-search', 'SearchController@findByAuthorName');

Route::get('publisher-search', 'SearchController@findByPublisherName');

Route::get('adminlogin', 'SessionController@showAdminLogin');
Route::post('adminlogin', 'SessionController@authAdminLogin');
Route::get('logout', 'SessionController@logout');

Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin']], function(){
    Route::get('books/create', 'BookController@create');
    Route::post('books/create', 'BookController@store');
    Route::get('books/edit/{id}', 'BookController@edit');
    Route::post('books/update/{id}', 'BookController@update');
    Route::post('books/status/{id}/{status}', 'BookController@changeStatus')
        ->where(['id' => '\d+', 'status' => 'true|false']);
    Route::get('dashboard', 'DashboardController@index');
});