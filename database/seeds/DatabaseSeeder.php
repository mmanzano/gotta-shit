<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    private $userAmount;
    private $placeAmount;

    public function __construct()
    {
        $this->userAmount = 20;
        $this->placeAmount = 200;
    }

    public function getUserAmount()
    {
        return $this->userAmount;
    }

    public function getPlaceAmount()
    {
        return $this->placeAmount;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UserTableSeeder');
        $this->call('PlaceTableSeeder');

        Model::reguard();
    }
}
