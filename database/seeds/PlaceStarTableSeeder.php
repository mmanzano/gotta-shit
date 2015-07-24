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
        $placeStarsAmount = $this->databaseSeeder->getPlaceStarsAmount();

        factory('ShitGuide\Entities\PlaceStar', $placeStarsAmount)->create();
    }
}