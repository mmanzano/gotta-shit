<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Place;
use App\Entities\PlaceStar;
use App\Entities\User;

$factory->define(PlaceStar::class, function ($faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'stars' => $faker->numberBetween(1, 5),
    ];
});
