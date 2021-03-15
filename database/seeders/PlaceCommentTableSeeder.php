<?php

namespace Database\Seeders;

use App\Entities\Place;
use App\Entities\PlaceComment;
use App\Entities\User;
use Illuminate\Database\Seeder;

class PlaceCommentTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 84; $i++) {
            PlaceComment::factory()->create([
                'user_id' => User::all()->pluck('id')->random(),
                'place_id' => Place::all()->pluck('id')->random(),
            ]);
        }
    }
}
