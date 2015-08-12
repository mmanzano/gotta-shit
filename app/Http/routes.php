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
    // Authentication routes
    Route::get('/{language}/login', ['as' => 'user_login', 'uses' => 'Auth\SessionsController@login']);
    Route::post('/{language}/login', ['as' => 'user_login', 'uses' => 'Auth\SessionsController@postLogin']);

    // Registration routes
    Route::get('/{language}/register', ['as' => 'user_register', 'uses' => 'Auth\RegistrationController@register']);
    Route::post('/{language}/register', ['as' => 'user_register', 'uses' => 'Auth\RegistrationController@postRegister']);
    Route::get('/{language}/register/confirm/{token}', ['as' => 'user_register_confirm', 'uses' => 'Auth\RegistrationController@confirmEmail']);

    // Password reset link request routes
    Route::get('/{language}/password/email', ['as' => 'user_password_email', 'uses' => 'Auth\PasswordController@getLocaleEmail']);
    Route::post('/{language}/password/email', ['as' => 'user_password_email', 'uses' => 'Auth\PasswordController@postLocaleEmail']);

    // Password reset routes
    Route::get('/{language}/password/reset/{token}', ['as' => 'user_password_reset', 'uses' => 'Auth\PasswordController@getLocaleReset']);
    Route::post('/{language}/password/reset', ['as' => 'user_password_reset', 'uses' => 'Auth\PasswordController@postLocaleReset']);
});

// Routes for authenticate users
Route::group(['middleware' => ['auth']], function(){
    // Edit User
    Route::get('/{language}/user/{user}/edit', ['as' => 'user_edit_form', 'uses' => 'Auth\UserController@edit']);
    // Update User
    Route::put('/{language}/user/{user}', ['as' => 'user_edit', 'uses' => 'Auth\UserController@update']);

    //Show User
    Route::get('/{language}/user/{user}', ['as' => 'user_profile', 'uses' => 'Auth\UserController@show']);

    // Logout
    Route::get('/{language}/logout', ['as' => 'user_logout', 'uses' => 'Auth\SessionsController@logout']);

    // Place for a user
    Route::get('/{language}/place/user', ['as' => 'user_places', 'uses' => 'PlaceController@placesForUser']);

    // Create a place
    Route::get('/{language}/place/create', ['as' => 'place_create_form', 'uses' => 'PlaceController@create']);
    Route::post('/{language}/place', ['as' => 'place_create', 'uses' => 'PlaceController@store']);

    // Update Stars Rate for a place
    Route::put('/{language}/place/{place}/stars', ['as' =>'place_stars_edit' , 'uses' => 'StarController@update']);
    // Delete Stars Rate for a place
    Route::delete('/{language}/place/{place}/stars', ['as' =>'place_stars_delete', 'uses' => 'StarController@destroy']);

    // Post a Comment
    Route::post('/{language}/place/{place}/comment', ['as' => 'place_comment_create', 'uses' => 'CommentController@store']);
});

// Edit, update, delete place
Route::group(['middleware' => ['isAuthor']], function(){
    Route::get('/{language}/place/{place}/edit', ['as' => 'place_edit_form', 'uses' => 'PlaceController@edit']);
});
Route::group(['middleware' => ['auth']], function(){
    Route::put('/{language}/place/{place}', ['as' => 'place_edit', 'uses' => 'PlaceController@update']);
    Route::delete('/{language}/place/{place}', ['as' => 'place_delete', 'uses' => 'PlaceController@destroy']);
});

// Comments
Route::group(['middleware' => ['isAuthorComment']], function()
{
    Route::get('/{language}/place/{place}/comment/{comment}/edit', ['as' => 'place_comment_edit_form', 'uses' => 'CommentController@edit']);
});

Route::group(['middleware' => ['auth']], function()
{
    Route::put('/{language}/place/{place}/comment/{comment}', ['as' => 'place_comment_edit', 'uses' => 'CommentController@update']);
    Route::delete('/{language}/place/{place}/comment/{comment}', ['as' => 'place_comment_delete', 'uses' => 'CommentController@destroy']);
});


Route::get('/', ['as' => 'root', 'uses' => 'HomeController@index']);
// Home
Route::get('/{language}', ['as' => 'home', 'uses' => 'HomeController@index_locale']);

// All places
Route::get('/{language}/place', ['as' => 'all_places', 'uses' => 'PlaceController@index']);

// Best Places
Route::get('/{language}/place/best', ['as' => 'best_places', 'uses' => 'PlaceController@bestPlaces']);

// Nearest Places
Route::get('/{language}/place/{lat}/{lng}/{distance}',['as' => 'nearest_places', 'uses' => 'PlaceController@nearest']);

// Display a place
Route::get('/{language}/place/{place}', ['as' => 'place', 'uses' => 'PlaceController@show']);
