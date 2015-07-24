<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    private $databaseSeeder;

    public function __construct(DatabaseSeeder $databaseSeeder)
    {
        $this->databaseSeeder = new DatabaseSeeder();
    }

    public function run()
    {
        $usersAmount = $this->databaseSeeder->getUsersAmount();

        factory('ShitGuide\Entities\User', $usersAmount - 1)->create();
        factory('ShitGuide\Entities\User', 'admin')->create();
    }
}