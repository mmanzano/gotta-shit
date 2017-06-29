<?php

use GottaShit\Entities\Place;
use GottaShit\Entities\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PlaceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function place_create()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $this->get('/en/place/create')->assertStatus(200);

        $this->post('/en/place/', [
            'name' => 'Bar Pepe',
            'geo_lat' => 40.5,
            'geo_lng' => -3.4,
            'stars' => 4,
        ])->assertRedirect('en/place/'. Place::all()->first()->id);
    }

    /** @test */
    public function place_edit()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);
        $this->get('/en/place/create')->assertStatus(200);

        $this->put('/en/place/' . $place->id, [
            'name' => 'Bar Pepe 2',
            'geo_lat' => 40.5,
            'geo_lng' => -3.4,
            'stars' => 4,
        ])->assertRedirect('/en/place/' . $place->id);

        $this->assertDatabaseHas('places', [
            'name' => 'Bar Pepe 2',
            'geo_lat' => 40.5,
            'geo_lng' => -3.4,
        ]);
    }

    /** @test */
    public function place_delete()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
        ]);

        $this->assertNull($place->fresh()->deleted_at);
        $this->actingAs($user);
        $this->delete('/en/place/' . $place->id)->assertRedirect('/en/place/user');
        $this->assertNotNull($place->fresh()->deleted_at);

        $this->actingAs($user);
        $this->delete('/en/place/' . $place->id)->assertRedirect('/en/place/user');

        $this->assertDatabaseMissing('places', [
            'id' => $place->id,
        ]);
    }
}
