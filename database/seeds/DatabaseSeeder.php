<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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
