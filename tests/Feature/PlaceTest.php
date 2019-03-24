<?php

namespace Tests\Feature;

use GottaShit\Entities\Place;
use GottaShit\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function placeShowWithoutLoginUser()
    {
        $place = factory(Place::class)->create();

        $this->get($place->path)
            ->assertStatus(200);
    }

    /** @test */
    public function placeShow()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create();

        $this->assertCount(0, $user->subscriptions);

        $this->actingAs($user)
            ->get($place->path)
            ->assertStatus(200);

        $this->assertCount(0, $user->fresh()->subscriptions);
    }

    /** @test */
    public function placeShowWithActiveSubscription()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create();

        $user->updateOrCreateSubscription($place);

        $this->assertCount(1, $user->subscriptions);
        $user->subscriptions()->first()->update(['comment_id' => 1]);
        $this->assertNotNull($user->subscriptions()->first()->comment_id);

        $this->actingAs($user)
            ->get($place->path)
            ->assertStatus(200);

        $this->assertCount(1, $user->fresh()->subscriptions);
        $this->assertNull($user->fresh()->subscriptions()->first()->comment_id);
    }

    /** @test */
    public function placeCreate()
    {
        $user = factory(User::class)->create();

        $createFormRoute = route('place.create');

        $postRoute = route('place.store');

        $this->actingAs($user)
            ->get($createFormRoute)
            ->assertStatus(200);

        $response = $this->post($postRoute, [
            'name' => 'Bar Pepe',
            'geo_lat' => 40.5,
            'geo_lng' => -3.4,
            'stars' => 4,
        ]);

        $response->assertRedirect(Place::first()->path);
    }

    /** @test */
    public function placeEdit()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $editFormRoute = route('place.edit', [
            'place' => $place->id,
        ]);

        $putRoute = route('place.update', [
            'place' => $place->id,
        ]);

        $this->actingAs($user)
            ->get($editFormRoute)
            ->assertStatus(200);

        $this->actingAs($user)
            ->put($putRoute, [
                'name' => 'Bar Pepe 2',
                'geo_lat' => 40.5,
                'geo_lng' => -3.4,
                'stars' => 4,
            ])->assertRedirect($place->path);

        $this->assertDatabaseHas('places', [
            'name' => 'Bar Pepe 2',
            'geo_lat' => 40.5,
            'geo_lng' => -3.4,
        ]);
    }

    /** @test */
    public function placeDelete()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
        ]);

        $this->assertNull($place->deleted_at);

        $deleteRoute = route('place.destroy', [
            'place' => $place->id,
        ]);

        $userPlacesRoute = route('user_places');

        $this->actingAs($user)
            ->delete($deleteRoute)
            ->assertRedirect($userPlacesRoute);

        $this->assertNotNull($place->fresh()->deleted_at);

        $this->actingAs($user)
            ->delete($deleteRoute)
            ->assertRedirect();

        $this->assertDatabaseMissing('places', [
            'id' => $place->id,
        ]);

        $this->assertNull($place->fresh());
    }
}
