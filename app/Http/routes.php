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

Route::get('/', ['as' => 'root', 'uses' => 'HomeController@index']);

Route::group(['prefix' => '{language}'], function () {
    // Home
    Route::get('', ['as' => 'home', 'uses' => 'HomeController@index_locale']);

    // Language change
    Route::get('change',
      ['as' => 'language', 'uses' => 'LanguageController@change']);

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
      'only' => [
        'store',
        'edit',
        'update',
        'destroy',
      ],
      'names' => [
        'store'   => 'place.comment.store',
        'edit'    => 'place.comment.edit',
        'update'  => 'place.comment.update',
        'destroy' => 'place.comment.destroy',
      ]
    ]);

    Route::resource('place.stars', 'StarController', [
      'only' => [
        'update',
        'destroy',
      ],
      'names' => [
        'update'  => 'place.stars.update',
        'destroy' => 'place.stars.destroy',
      ]
    ]);

    Route::resource('place.subscribe', 'SubscriptionController', [
      'only' => [
        'store',
        'destroy',
      ],
      'names' => [
        'store'   => 'place.subscribe.store',
        'destroy' => 'place.subscribe.destroy',
      ]
    ]);

    Route::resource('user', 'Auth\UserController', [
      'only' => [
        'show',
        'edit',
        'update',
      ],
      'names' => [
        'show'    => 'user.show',
        'edit'    => 'user.edit',
        'update'  => 'user.update',
      ]
    ]);

    // Authentication
    Route::get('login',
      ['as' => 'user_login', 'uses' => 'Auth\SessionsController@login']);

    Route::post('login',
      ['as' => 'user_login', 'uses' => 'Auth\SessionsController@postLogin']);

    Route::get('logout',
      ['as' => 'user_logout', 'uses' => 'Auth\SessionsController@logout']);

    // Registration
    Route::get('register', [
      'as' => 'user_register',
      'uses' => 'Auth\RegistrationController@register'
    ]);

    Route::post('register', [
      'as' => 'user_register',
      'uses' => 'Auth\RegistrationController@postRegister'
    ]);

    Route::get('register/confirm/{token}', [
      'as' => 'user_register_confirm',
      'uses' => 'Auth\RegistrationController@confirmEmail'
    ]);

    // Password reset link
    Route::get('password/email', [
      'as' => 'user_password_email',
      'uses' => 'Auth\PasswordController@getLocaleEmail'
    ]);

    Route::post('password/email', [
      'as' => 'user_password_email',
      'uses' => 'Auth\PasswordController@postLocaleEmail'
    ]);

    Route::get('password/reset/{token}', [
      'as' => 'user_password_reset',
      'uses' => 'Auth\PasswordController@getLocaleReset'
    ]);

    Route::post('password/reset', [
      'as' => 'user_password_reset',
      'uses' => 'Auth\PasswordController@postLocaleReset'
    ]);
});

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