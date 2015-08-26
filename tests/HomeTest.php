<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
    use DatabaseTransactions;

    public function test_home_gotta_shit()
    {
        $this->visit('/en')
            ->see('Gotta Shit');
    }

    public function test_home_login()
    {
        $this->visit('/en')
          ->click('Login');
    }

    public function test_home_register()
    {
        $this->visit('/en')
          ->click('Register');
    }

    public function test_home_all_guest()
    {
        $this->visit('/en')
          ->click('All');
    }

    public function test_home_nearest_guest()
    {
        $this->visit('/en')
          ->click('Nearest');
    }

    public function test_home_all_user()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/en')
          ->click('All');
    }

    public function test_home_nearest_user()
    {
        App::setLocale('en');

        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/en')
          ->click('Nearest');
    }

    public function test_home_your_places()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/en')
          ->click('Your places');
    }

    public function test_home_add()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/en')
          ->click('Add');
    }

    public function test_home_logout()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/en')
          ->click('Logout');
    }
}
