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
    public function homeGottaShit()
    {
        $this->get('/en')
            ->assertSee('Gotta Shit');
    }

    /** @test */
    public function homeLogin()
    {
        $this->get('/en')
            ->assertSee('Login');
    }

    /** @test */
    public function homeRegister()
    {
        $this->get('/en')
            ->assertSee('Register');
    }

    /** @test */
    public function homeAllGuest()
    {
        $this->get('/en')
            ->assertSee('All');
    }

    /** @test */
    public function homeNearestGuest()
    {
        $this->get('/en')
            ->assertSee('Nearest');
    }

    /** @test */
    public function homeAllUser()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('All');
    }

    /** @test */
    public function homeNearestUser()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Nearest');
    }

    /** @test */
    public function homeYourPlaces()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Your places');
    }

    /** @test */
    public function homeAdd()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Add');
    }

    /** @test */
    public function homeLogout()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Logout');
    }
}
