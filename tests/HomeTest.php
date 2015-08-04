<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
    use DatabaseTransactions;

    public function test_home_gotta_shit()
    {
        $this->visit('/')
            ->see('Gotta Shit');
    }

    public function test_home_login()
    {
        $this->visit('/')
          ->click('Login');
    }

    public function test_home_register()
    {
        $this->visit('/')
          ->click('Register');
    }


    public function test_home_nearest_guest()
    {
        $this->visit('/')
          ->click('Nearest');
    }

    public function test_home_nearest_user()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/')
          ->click('Nearest');
    }

    public function test_home_yours_places()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/')
          ->click('Yours places');
    }

    public function test_home_add()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/')
          ->click('Add');
    }

    public function test_home_logout()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/')
          ->click('Logout');
    }
}
