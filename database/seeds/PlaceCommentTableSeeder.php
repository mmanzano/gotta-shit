<?php

use App\Entities\Place;
use App\Entities\User;
use Illuminate\Database\Seeder;

class PlaceCommentTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 84; $i++) {
            factory('App\Entities\PlaceComment')->create([
                'user_id' => User::all()->pluck('id')->random(),
                'place_id' => Place::all()->pluck('id')->random(),
            ]);
        }
    }
}
