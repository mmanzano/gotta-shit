<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlaceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_place_create()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('4', 'stars')
          ->press('Create Place')
          ->see('Bar Pepe created')
          ->see('No comments')
          ->dontSee('geo_lat')
          ->dontSee('geo_lng');
    }

    public function test_place_edit()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('4', 'stars')
          ->press('Create Place')
          ->click('Edit')
          ->type('Bar Pepe 2', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('5', 'stars')
          ->press('Edit Place')
          ->see('Bar Pepe 2 edited');
    }

    public function test_home_gotta_shit()
    {
        $this->visit('/')
          ->see('Gotta Shit');
    }

    public function test_place_create_guest()
    {
        $this->visit('/place/create')
          ->seePageIs('/login');
    }


    public function test_place_nearest()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->click('Nearest');
    }

    public function test_place_yours_places()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->click('Yours places');
    }

    public function test_place_add()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->click('Add');
    }

    public function test_home_logout()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->click('Logout');
    }
}
