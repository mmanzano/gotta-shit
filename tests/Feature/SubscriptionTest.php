<?php

namespace Tests\Feature;

use GottaShit\Entities\Place;
use GottaShit\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function subscriptionCreate()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->json('POST', "/es/place/{$place->id}/subscribe")
            ->assertStatus(302);

        $this->assertCount(1, $user->subscriptions()->where('place_id', $place->id)->get());
    }

    /** @test */
    public function unsubscription()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $user->subscriptions()->create([
            'place_id' => $place->id,
        ]);

        $this->assertCount(1, $user->subscriptions()->where('place_id', $place->id)->get());

        $this->actingAs($user)
            ->json('DELETE', "/es/place/{$place->id}/subscribe")
            ->assertStatus(302);

        $this->assertCount(0, $user->subscriptions()->where('place_id', $place->id)->get());
    }
}
