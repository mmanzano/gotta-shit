<?php

use Illuminate\Database\Seeder;

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

        factory('GottaShit\Entities\PlaceComment',
            $placeCommentsAmount)->create();
    }
}
