<?php

use GottaShit\Entities\Place;
use GottaShit\Entities\User;
use Illuminate\Database\Seeder;

class PlaceStarTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 420; $i++) {
            factory('GottaShit\Entities\PlaceStar')->create([
                'user_id' => User::all()->pluck('id')->random(),
                'place_id' => Place::all()->pluck('id')->random(),
            ]);
        }
    }
}
