<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(GottaShit\Entities\User::class, function ($faker) {
    return [
        'full_name' => $faker->firstName.' '.$faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->unique()->email,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(GottaShit\Entities\User::class, 'admin', function ($faker) {
    return [
        'full_name' => 'Miguel Manzano',
        'username' => 'mmanzano',
        'email' => 'mmanzano@gmail.com',
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(GottaShit\Entities\Place::class, function ($faker) {
    $initialLat = 40.5;
    $initialLng = -3.7;
    $deltaMin = -4000;
    $deltaMax = 3000;
    $latitude = $initialLat + $faker->numberBetween($deltaMin, $deltaMax) / 1000;
    $longitude = $initialLng + $faker->numberBetween($deltaMin, $deltaMax) / 1000;

    return [
      'name' => $faker->company,
      'geo_lat' => $latitude,
      'geo_lng' => $longitude,
      'user_id' => GottaShit\Entities\User::All()->random()->id,
    ];
});

$factory->define(GottaShit\Entities\PlaceStar::class, function ($faker) {
    return [
        'user_id' => GottaShit\Entities\User::All()->random()->id,
        'place_id' => GottaShit\Entities\Place::All()->random()->id,
        'stars' => $faker->numberBetween(1, 5),
    ];
});

$factory->define(GottaShit\Entities\PlaceComment::class, function ($faker) {
    return [
        'user_id' => GottaShit\Entities\User::All()->random()->id,
        'place_id' => GottaShit\Entities\Place::All()->random()->id,
        'comment' => $faker->realText(300),
    ];
});