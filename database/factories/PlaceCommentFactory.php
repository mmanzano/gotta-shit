<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\PlaceComment;
use App\Entities\User;
use App\Entities\Place;

$factory->define(PlaceComment::class, function ($faker) {
    return [
        'user_id'  => function () {
            return factory(User::class)->create()->id;
        },
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'comment'  => $faker->realText(300),
    ];
});
