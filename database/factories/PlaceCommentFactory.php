<?php

use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\User;
use GottaShit\Entities\Place;

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
