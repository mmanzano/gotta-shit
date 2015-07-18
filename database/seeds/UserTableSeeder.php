<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $usersAmount = 20;

        for ($user = 1; $user <= $usersAmount; $user++) {
            \DB::table('users')->insert(array(
              'full_name' => $faker->firstName.' '.$faker->lastName,
              'username' => $faker->userName,
              'email' => $faker->unique()->email,
              'password' => \Hash::make('123456'),
            ));
        }
    }
}