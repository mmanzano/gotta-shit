<?php

use Illuminate\Database\Seeder;

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

        factory('GottaShit\Entities\PlaceStar', $placeStarsAmount)->create();
    }
}