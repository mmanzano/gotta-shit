<?php

namespace Database\Seeders;

use App\Entities\Place;
use App\Entities\PlaceStar;
use App\Entities\User;
use Illuminate\Database\Seeder;

class PlaceStarTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 420; $i++) {
            PlaceStar::factory()->create([
                'user_id' => User::all()->pluck('id')->random(),
                'place_id' => Place::all()->pluck('id')->random(),
            ]);
        }
    }
}
