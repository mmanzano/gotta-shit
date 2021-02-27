<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\User;
use Illuminate\Support\Str;

$factory->define(User::class, function ($faker) {
    return [
        'full_name' => $faker->firstName . ' ' . $faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->unique()->email,
        'password' => bcrypt('123456'),
        'verified' => true,
        'remember_token' => Str::random(10),
        'language' => 'en',
    ];
});

$factory->state(User::class, 'admin', [
    'full_name' => 'Miguel Manzano',
    'username' => 'mmanzano',
    'email' => 'mmanzano@gmail.com',
    'password' => bcrypt('secret'),
    'verified' => true,
    'remember_token' => Str::random(10),
    'language' => 'en',
]);
