<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
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

        for ($user = 1; $user <= $usersAmount - 1; $user++) {
            \DB::table('users')->insert(array(
              'full_name' => $faker->firstName.' '.$faker->lastName,
              'username' => $faker->userName,
              'email' => $faker->unique()->email,
              'password' => \Hash::make('123456'),
            ));
        }
        \DB::table('users')->insert(array(
          'full_name' => 'Miguel Manzano',
          'username' => 'mmanzano',
          'email' => 'mmanzano@gmail.com',
          'password' => \Hash::make('secret'),
        ));
    }
}