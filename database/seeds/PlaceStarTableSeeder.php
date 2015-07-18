<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PlaceStarTableSeeder extends Seeder
{
    private $databaseSeeder;

    public function __construct(DatabaseSeeder $databaseSeeder)
    {
        $this->databaseSeeder = new DatabaseSeeder();
    }

    public function run()
    {
        $faker = Faker::create();

        $usersAmount = $this->databaseSeeder->getUsersAmount();
        $placesAmount = $this->databaseSeeder->getPlacesAmount();
        $placeStarsAmount = $this->databaseSeeder->getPlaceStarsAmount();

        for ($star = 1; $star <= $placeStarsAmount; $star++) {
            \DB::table('place_stars')->insert(array(
              'user_id' => $faker->numberBetween(1, $usersAmount),
              'place_id' => $faker->numberBetween(1, $placesAmount),
              'stars' => $faker->numberBetween(1, 5),
            ));
        }
    }
}