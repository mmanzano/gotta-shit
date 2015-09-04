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

        factory('GottaShit\Entities\User', $usersAmount - 1)->create();
        factory('GottaShit\Entities\User', 'admin')->create();
    }
}
