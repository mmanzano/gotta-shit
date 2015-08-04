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

// Authentication and Registration routes
Route::group(['middleware' => ['guest']], function()
{
    Route::get('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
    Route::post('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);
});

// Routes for authenticate users
Route::group(['middleware' => ['auth']], function(){
    // Logout
    Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

    // Place for a user
    Route::get('/place/user', ['as' => 'user_places', 'uses' => 'PlaceController@placesForUser']);

    // Create a place
    Route::get('/place/create', ['as' => 'create_place', 'uses' => 'PlaceController@create']);
    Route::post('/place', ['uses' => 'PlaceController@store']);

    // Update Stars Rate for a place
    Route::put('place/{place}/stars', ['uses' => 'StarController@update']);

    // Post a Comment
    Route::post('/place/{place}/comment', ['uses' => 'CommentController@store']);
});

// Edit, update, delete place
Route::group(['middleware' => ['isAuthor']], function(){
    Route::get('/place/{place}/edit', ['uses' => 'PlaceController@edit']);
    Route::put('/place/{place}', ['uses' => 'PlaceController@update']);
    Route::delete('/place/{place}', ['uses' => 'PlaceController@destroy']);
});

// Comments
Route::group(['middleware' => ['isAuthorComment']], function()
{
    Route::get('/place/{place}/comment/{comment}/edit', ['uses' => 'CommentController@edit']);
});

Route::group(['middleware' => ['auth']], function()
{
    Route::put('/place/{place}/comment/{comment}', ['uses' => 'CommentController@update']);
    Route::delete('/place/{place}/comment/{comment}', ['uses' => 'CommentController@destroy']);
});

// Home
Route::get('/', ['as' => 'home', 'uses' => 'PlaceController@index']);

// Display a place
Route::get('/place/{place}', ['as' => 'place', 'uses' => 'PlaceController@show']);