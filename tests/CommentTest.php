<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_comment_create()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('3', 'stars')
          ->press('Create Place')
          ->type('Hello! Great Site', 'comment')
          ->press('Send comment')
          ->see('3.00')
          ->see('Hello! Great Site');
    }

    public function test_comment_edit()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('3', 'stars')
          ->press('Create Place')
          ->type('Hello! Great Site', 'comment')
          ->press('Send comment')
          ->see('3.00')
          ->see('Hello! Great Site')
          ->click('Edit comment')
          ->dontSee('3.00')
          ->type('Adios', 'comment')
          ->press('Send comment')
          ->see('3.00')
          ->see('Adios');
    }

    public function test_comment_delete()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('3', 'stars')
          ->press('Create Place')
          ->type('Hello! Great Site', 'comment')
          ->press('Send comment')
          ->see('3.00')
          ->see('Hello! Great Site')
          ->press('Delete comment')
          ->see('3.00')
          ->dontSee('Hello! Great Site');
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
