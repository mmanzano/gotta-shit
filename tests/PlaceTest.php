<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Lang;

class PlaceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_comment_lang()
    {
        $this->assertTrue(lang::has('gottashit.place.create_place'));
        $this->assertTrue(lang::has('gottashit.place.created_place'));
        $this->assertTrue(lang::has('gottashit.place.edit_place'));
        $this->assertTrue(lang::has('gottashit.place.update_place'));
        $this->assertTrue(lang::has('gottashit.place.updated_place'));
        $this->assertTrue(lang::has('gottashit.place.delete_place'));
        $this->assertTrue(lang::has('gottashit.place.deleted_place'));
    }

    public function test_place_create()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('4', 'stars')
          ->press(ucfirst(Lang::get('gottashit.place.create_place')))
          ->see('Bar Pepe '. Lang::get('gottashit.place.created_place'))
          ->see('4.00')
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
          ->press(ucfirst(Lang::get('gottashit.place.create_place')))
          ->click(ucfirst(Lang::get('gottashit.place.edit_place')))
          ->type('Bar Pepe 2', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('5', 'stars')
          ->press(ucfirst(Lang::get('gottashit.place.update_place')))
          ->see('Bar Pepe 2 ' . Lang::get('gottashit.place.updated_place'));
    }
    public function test_place_delete()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('4', 'stars')
          ->press(ucfirst(Lang::get('gottashit.place.create_place')))
          ->see('Bar Pepe ' . Lang::get('gottashit.place.created_place'))
          ->see('4.00')
          ->press(ucfirst(Lang::get('gottashit.place.delete_place')))
          ->see('Bar Pepe ' . Lang::get('gottashit.place.deleted_place'))
          ->seePageIs('/');
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
