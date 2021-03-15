<?php

namespace Tests\Feature;

use App\Entities\Place;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Place::factory()->create();
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
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('All');
    }

    /** @test */
    public function homeNearestUser()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Nearest');
    }

    /** @test */
    public function homeYourPlaces()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Your places');
    }

    /** @test */
    public function homeAdd()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Add');
    }

    /** @test */
    public function homeLogout()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertSee('Logout');
    }
}
