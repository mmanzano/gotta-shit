<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use DatabaseTransactions;

    public function xtest_home_gotta_shit()
    {
        $this->visit('/en')
            ->see('Gotta Shit');
    }

    public function xtest_home_login()
    {
        $this->visit('/en')
            ->click('Login');
    }

    public function xtest_home_register()
    {
        $this->visit('/en')
            ->click('Register');
    }

    public function xtest_home_all_guest()
    {
        $this->visit('/en')
            ->click('All');
    }

    public function xtest_home_nearest_guest()
    {
        $this->visit('/en')
            ->click('Nearest');
    }

    public function xtest_home_all_user()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
            ->visit('/en')
            ->click('All');
    }

    public function xtest_home_nearest_user()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
            ->visit('/en')
            ->click('Nearest');
    }

    public function xtest_home_your_places()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
            ->visit('/en')
            ->click('Your places');
    }

    public function xtest_home_add()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
            ->visit('/en')
            ->click('Add');
    }

    public function xtest_home_logout()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
            ->visit('/en')
            ->click('Logout');
    }
}
