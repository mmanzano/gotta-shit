<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION'),
    ],

    'stripe' => [
        'model'  => App\Entities\User::class,
        'key' => '',
        'secret' => '',
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_URL_CALLBACK'),
    ],

    'facebook' => [
        'client_id' => env('FB_APP_ID'),
        'client_secret' => env('FB_APP_SECRET'),
        'redirect' => env('FB_URL_CALLBACK'),
    ],

    'twitter' => [
        'client_id' => env('TW_CONSUMER_ID'),
        'client_secret' => env('TW_CONSUMER_SECRET'),
        'redirect' => env('TW_URL_CALLBACK'),
    ],

    'recaptcha' => [
        'client_secret' => env('SERVICES_RECAPTCHA_CLIENT_SECRET'),
        'server_secret' => env('SERVICES_RECAPTCHA_SERVER_SECRET'),
    ],

];
