<?php

use App\Entities\User;

$factory->define(User::class, function ($faker) {
    return [
        'full_name' => $faker->firstName . ' ' . $faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->unique()->email,
        'password' => bcrypt('123456'),
        'verified' => true,
        'remember_token' => str_random(10),
        'language' => 'en',
    ];
});

$factory->defineAs(User::class, 'admin', function ($faker) {
    return [
        'full_name' => 'Miguel Manzano',
        'username' => 'mmanzano',
        'email' => 'mmanzano@gmail.com',
        'password' => bcrypt('secret'),
        'verified' => true,
        'remember_token' => str_random(10),
        'language' => 'en',
    ];
});
