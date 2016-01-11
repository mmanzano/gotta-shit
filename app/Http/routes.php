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

Route::group(['prefix' => '{language}'], function () {
    // Best Places
    Route::get('place/best',
      ['as' => 'best_places', 'uses' => 'PlaceController@bestPlaces']);

    // Place for a user
    Route::get('place/user',
      ['as' => 'user_places', 'uses' => 'PlaceController@placesForUser']);

    // Nearest Places
    Route::get('place/{lat}/{lng}/{distance}',
      ['as' => 'nearest_places', 'uses' => 'PlaceController@nearest']);

    Route::resource('place', 'PlaceController', [
      'names' => [
        'index'   => 'place.index',
        'create'  => 'place.create',
        'store'   => 'place.store',
        'show'    => 'place.show',
        'edit'    => 'place.edit',
        'update'  => 'place.update',
        'destroy' => 'place.destroy',
      ]
    ]);

    Route::post('place/{place}/restore',
      ['as' => 'place.restore', 'uses' => 'PlaceController@restore']);

    Route::resource('place.comment', 'CommentController', [
      'names' => [
        'index'   => 'place.comment.index',
        'create'  => 'place.comment.create',
        'store'   => 'place.comment.store',
        'show'    => 'place.comment.show',
        'edit'    => 'place.comment.edit',
        'update'  => 'place.comment.update',
        'destroy' => 'place.comment.destroy',
      ]
    ]);

    Route::resource('place.stars', 'StarController', [
      'names' => [
        'index'   => 'place.stars.index',
        'create'  => 'place.stars.create',
        'store'   => 'place.stars.store',
        'show'    => 'place.stars.show',
        'edit'    => 'place.stars.edit',
        'update'  => 'place.stars.update',
        'destroy' => 'place.stars.destroy',
      ]
    ]);

    // Authentication routes
    Route::get('login',
      ['as' => 'user_login', 'uses' => 'Auth\SessionsController@login']);
    Route::post('login',
      ['as' => 'user_login', 'uses' => 'Auth\SessionsController@postLogin']);
    Route::get('logout',
      ['as' => 'user_logout', 'uses' => 'Auth\SessionsController@logout']);


});



// Authentication and Registration routes
Route::group(['middleware' => ['guest']], function () {

    // Registration routes
    Route::get('/{language}/register', [
        'as' => 'user_register',
        'uses' => 'Auth\RegistrationController@register'
    ]);
    Route::post('/{language}/register', [
        'as' => 'user_register',
        'uses' => 'Auth\RegistrationController@postRegister'
    ]);
    // Password reset link request routes
    Route::get('/{language}/password/email', [
        'as' => 'user_password_email',
        'uses' => 'Auth\PasswordController@getLocaleEmail'
    ]);
    Route::post('/{language}/password/email', [
        'as' => 'user_password_email',
        'uses' => 'Auth\PasswordController@postLocaleEmail'
    ]);

    // Password reset routes
    Route::get('/{language}/password/reset/{token}', [
        'as' => 'user_password_reset',
        'uses' => 'Auth\PasswordController@getLocaleReset'
    ]);
    Route::post('/{language}/password/reset', [
        'as' => 'user_password_reset',
        'uses' => 'Auth\PasswordController@postLocaleReset'
    ]);
});

// Confirm email for guess and logged user
Route::get('/{language}/register/confirm/{token}', [
    'as' => 'user_register_confirm',
    'uses' => 'Auth\RegistrationController@confirmEmail'
]);

// Routes for authenticate users
Route::group(['middleware' => ['auth']], function () {
    // Edit User
    Route::get('/{language}/user/{user}/edit',
        ['as' => 'user_edit_form', 'uses' => 'Auth\UserController@edit']);
    // Update User
    Route::put('/{language}/user/{user}',
        ['as' => 'user_edit', 'uses' => 'Auth\UserController@update']);

    //Show User
    Route::get('/{language}/user/{user}',
        ['as' => 'user_profile', 'uses' => 'Auth\UserController@show']);
});

// Subscriptions
Route::group(['middleware' => ['auth']], function () {
    Route::post('/{language}/place/{place}/subscribe',
        ['as' => 'place_subscribe', 'uses' => 'SubscriptionController@store']);
    Route::delete('/{language}/place/{place}/unsubscribe', [
        'as' => 'place_unsubscribe',
        'uses' => 'SubscriptionController@destroy'
    ]);
});

Route::get('/', ['as' => 'root', 'uses' => 'HomeController@index']);
// Home
Route::get('/{language}',
    ['as' => 'home', 'uses' => 'HomeController@index_locale']);

// Language change
Route::get('/{language}/change',
    ['as' => 'language', 'uses' => 'LanguageController@change']);

// Social Authentication
Route::get('/auth/{provider}',
    [
        'as' => 'social_login',
        'uses' => 'Auth\AuthController@redirectToProvider'
    ])
    ->where('provider', 'facebook|github|twitter');
Route::get('/auth/{provider}/callback', [
    'as' => 'social_callback',
    'uses' => 'Auth\AuthController@handleProviderCallback'
])->where('provider', 'facebook|github|twitter');
