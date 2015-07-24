<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PlaceCommentTableSeeder extends Seeder
{
    private $databaseSeeder;

    public function __construct(DatabaseSeeder $databaseSeeder)
    {
        $this->databaseSeeder = new DatabaseSeeder();
    }

    public function run()
    {
        $placeCommentsAmount = $this->databaseSeeder->getPlaceCommentsAmount();

        factory('ShitGuide\Entities\PlaceComment', $placeCommentsAmount)->create();
    }
}