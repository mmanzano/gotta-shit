<?php

use App\Entities\User;
use App\Entities\Place;
use Illuminate\Database\Seeder;

class PlaceTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 42; $i++) {
            factory(Place::class)->create([
                'user_id' => User::all()->pluck('id')->random()
            ]);
        }
    }
}
