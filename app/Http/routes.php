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

Route::get('/', ['as' => 'home', 'uses' => 'PlaceController@index']);

// Display a form to create a place
Route::get('/place/create', ['middleware' => 'auth', 'as' => 'create_place', 'uses' => 'PlaceController@create']);
// Display a place
Route::get('/place/{place}', ['as' => 'place', 'uses' => 'PlaceController@show']);
// Store a new place
Route::delete('/place/{place}', ['middleware' => 'isAuthor', 'uses' => 'PlaceController@destroy']);
Route::get('/place/{place}/edit', ['middleware' => 'isAuthor', 'uses' => 'PlaceController@edit']);
Route::put('/place/{place}', ['middleware' => 'isAuthor', 'uses' => 'PlaceController@update']);
Route::post('/place', ['middleware' => 'auth', 'uses' => 'PlaceController@store']);

// Authentication routes...
Route::get('/login', ['middleware' => 'guest', 'as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login', ['middleware' => 'guest', 'as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('/logout', ['middleware' => 'auth', 'as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('/register', ['middleware' => 'guest', 'as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('/register', ['middleware' => 'guest', 'as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);
