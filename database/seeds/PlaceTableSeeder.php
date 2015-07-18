<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PlaceTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $placesAmount = 200;

        for ($place = 1; $place <= $placesAmount; $place++) {
            $initialLat = 40.5;
            $initialLng = -3.7;
            $deltaMin = -4000;
            $deltaMax = 3000;
            $latitude = $initialLat + $faker->numberBetween($deltaMin, $deltaMax) / 1000;
            $longitude = $initialLng + $faker->numberBetween($deltaMin, $deltaMax) / 1000;
            \DB::table('places')->insert(array(
              'name' => $faker->company,
              'geo_lat' => $latitude,
              'geo_lng' => $longitude,
            ));
        }
    }
}