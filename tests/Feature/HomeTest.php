<?php

namespace Tests\Feature;

use GottaShit\Entities\Place;
use GottaShit\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        factory(Place::class)->create();
    }

    /** @test */
    public function home_gotta_shit()
    {
        $this->get('/en')
            ->assertSee('Gotta Shit');
    }

    /** @test */
    public function home_login()
    {
        $this->get('/en')
            ->assertSee('Login');
    }

    /** @test */
    public function home_register()
    {
        $this->get('/en')
            ->assertSee('Register');
    }

    /** @test */
    public function home_all_guest()
    {
        $this->get('/en')
            ->assertSee('All');
    }

    /** @test */
    public function home_nearest_guest()
    {
        $this->get('/en')
            ->assertSee('Nearest');
    }

    /** @test */
    public function home_all_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('All');
    }

    /** @test */
    public function home_nearest_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Nearest');
    }

    /** @test */
    public function home_your_places()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Your places');
    }

    /** @test */
    public function home_add()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Add');
    }

    /** @test */
    public function home_logout()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Logout');
    }
}
