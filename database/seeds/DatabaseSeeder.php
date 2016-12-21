<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    private $usersAmount;
    private $placesAmount;
    private $placeStarsAmount;
    private $placeCommentsAmount;

    public function __construct()
    {
        $this->usersAmount = 20;
        $this->placesAmount = 200;
        $this->placeStarsAmount = $this->placesAmount * 5;
        $this->placeCommentsAmount = $this->placesAmount * 3;
    }

    public function getUsersAmount()
    {
        return $this->usersAmount;
    }

    public function getPlacesAmount()
    {
        return $this->placesAmount;
    }

    public function getPlaceStarsAmount()
    {
        return $this->placeStarsAmount;
    }

    public function getPlaceCommentsAmount()
    {
        return $this->placeCommentsAmount;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserTableSeeder');
        $this->call('PlaceTableSeeder');
        $this->call('PlaceStarTableSeeder');
        $this->call('PlaceCommentTableSeeder');
    }
}
