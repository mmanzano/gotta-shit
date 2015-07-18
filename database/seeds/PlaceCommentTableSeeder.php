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
        $faker = Faker::create();

        $usersAmount = $this->databaseSeeder->getUsersAmount();
        $placesAmount = $this->databaseSeeder->getPlacesAmount();
        $placeCommentsAmount = $this->databaseSeeder->getPlaceCommentsAmount();

        for ($comment = 1; $comment <= $placeCommentsAmount; $comment++) {
            \DB::table('place_comments')->insert(array(
              'user_id' => $faker->numberBetween(1, $usersAmount),
              'place_id' => $faker->numberBetween(1, $placesAmount),
              'comment' => $faker->realText(300),
            ));
        }
    }
}