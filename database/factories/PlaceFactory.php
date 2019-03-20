<?php

use GottaShit\Entities\Place;
use GottaShit\Entities\User;

$factory->define(Place::class, function ($faker) {
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
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
