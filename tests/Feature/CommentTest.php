<?php

namespace Tests\Feature;

use App\Entities\Place;
use App\Entities\PlaceComment;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function commentCreate()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $route = route('comment.store');

        $response = $this->actingAs($user)
            ->post($route, [
                'placeId' => $place->id,
                'comment' => 'Hello! Great Site',
            ]);

        $response->assertStatus(302);

        $comment = PlaceComment::first();

        $redirectRoute = "{$place->path}#comment-{$comment->id}";

        $response->assertRedirect($redirectRoute);

        $this->assertDatabaseHas('place_comments', [
            'place_id' => $place->id,
            'user_id' => $user->id,
            'comment' => 'Hello! Great Site',
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'place_id' => $place->id,
            'user_id' => $user->id,
            'comment_id' => null,
        ]);
    }

    /** @test */
    public function commentEdit()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $comment = factory(PlaceComment::class)->create([
            'comment' => 'Hello',
            'place_id' => $place->id,
            'user_id' => $user->id,
        ]);

        $route = route('comment.update', [
            'place' => $place->id,
            'comment' => $comment->id
        ]);

        $redirectRoute = "{$place->path}#comment-{$comment->id}";

        $this->actingAs($user)
            ->put($route, [
                'comment' => 'GoodBye',
            ])->assertRedirect($redirectRoute);

        $this->assertDatabaseHas('place_comments', [
            'place_id' => $place->id,
            'user_id' => $user->id,
            'comment' => 'GoodBye',
        ]);
    }

    /** @test */
    public function commentDelete()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $comment = factory(PlaceComment::class)->create([
            'comment' => 'Hello',
            'place_id' => $place->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('place_comments', [
            'id' => $comment->id
        ]);

        $route = route('comment.destroy', [
            'place' => $place->id,
            'comment' => $comment->id,
        ]);

        $this->actingAs($user)
            ->delete($route)
            ->assertRedirect($place->path);

        $this->assertDatabaseMissing('place_comments', [
            'id' => $comment->id
        ]);
    }
}
