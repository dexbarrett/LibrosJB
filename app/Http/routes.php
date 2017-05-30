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
Route::get('author-search', 'SearchController@findByAuthorName');
Route::get('publisher-search', 'SearchController@findByPublisherName');

Route::get('login', 'SessionController@showUserLogin')
    ->middleware(['alreadyLoggedIn']);

Route::get('login/authenticate', 'SessionController@authUserLogin');
Route::get('login/callback', 'SessionController@processUserLogin');

Route::get('logout', 'SessionController@logout');

Route::get('/{sortBy?}/{direction?}', 'BookController@index')
->where(['sortBy' => 'titulo|precio|autor', 'direction' => 'asc|desc']);

Route::get('books/{slug}', 'BookController@show');

Route::group(['middleware' => 'auth'], function(){
    Route::get('me/conversations', 'MessagesController@listConversations');
    Route::post('conversations/{bookID}/create', 'MessagesController@createConversation');
    Route::get('conversations/{conversationID}',
     ['uses' => 'MessagesController@showConversation', 'middleware' => ['clearUnreadMessages']]);
    Route::post('messages/{conversationID}/create', 'MessagesController@createMessage');
    Route::post('me/settings/email_notifications', 'SettingsController@updateEmailNotifications');
});

/* Admin Routes */
Route::get('adminlogin', 'SessionController@showAdminLogin')
    ->middleware(['alreadyLoggedIn']);
Route::post('adminlogin', 'SessionController@authAdminLogin');

Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin']], function(){
    Route::get('books/create', 'BookController@create');
    Route::post('books/create', 'BookController@store');
    Route::get('books/edit/{uuid}', 'BookController@edit');
    Route::post('books/update/{uuid}', 'BookController@update');
    Route::post('books/status', 'BookController@changeStatus')
        ->where(['id' => '\d+', 'status' => 'true|false']);
    Route::get('books/{uuid}/photos', 'BookPhotosController@create');
    Route::post('books/{uuid}/photos', 'BookPhotosController@store');
    Route::delete('photos/delete', 'BookPhotosController@delete');
    Route::get('dashboard', 'DashboardController@index');
});