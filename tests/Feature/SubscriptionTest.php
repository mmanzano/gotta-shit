<?php

namespace Tests\Feature;

use App\Entities\Place;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function subscriptionCreate()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create();

        $this->actingAs($user)
            ->json(
                'POST',
                route('place.subscribe.store', ['place' => $place->id])
            )
            ->assertStatus(302);

        $this->assertCount(1, $user->subscriptions()->where('place_id', $place->id)->get());
    }

    /** @test */
    public function unsubscription()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create();

        $user->subscriptions()->create([
            'place_id' => $place->id,
        ]);

        $this->assertCount(1, $user->subscriptions()->where('place_id', $place->id)->get());

        $this->actingAs($user)
            ->json(
                'DELETE',
                route('place.subscribe.destroy', ['place' => $place->id])
            )
            ->assertStatus(302);

        $this->assertCount(0, $user->subscriptions()->where('place_id', $place->id)->get());
    }
}
