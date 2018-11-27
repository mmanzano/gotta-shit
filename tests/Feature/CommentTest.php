<?php

namespace Tests\Feature;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function comment_create()
    {
        $user = factory(User::class)->create();

        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $route = route('place.comment.store', [
            'language' => 'en',
            'place' => $place->id
        ]);

        $response = $this->actingAs($user)
            ->post($route, [
                'comment' => 'Hello! Great Site',
            ]);

        $response->assertStatus(302);

        $comment = PlaceComment::first();

        $placeRoute = route('place.show', [
            'language' => 'en',
            'place' => $place->id,
        ]);

        $redirectRoute = "{$placeRoute}#comment-{$comment->id}";

        $response->assertRedirect($redirectRoute);

        $this->assertDatabaseHas('place_comments', [
            'place_id' => $place->id,
            'user_id' => $user->id,
            'comment' => 'Hello! Great Site',
        ]);
    }

    /** @test */
    public function comment_edit()
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

        $route = route('place.comment.update', [
            'language' => 'en',
            'place' => $place->id,
            'comment' => $comment->id
        ]);

        $placeRoute = route('place.show', [
            'language' => 'en',
            'place' => $place->id,
        ]);

        $redirectRoute = "{$placeRoute}#comment-{$comment->id}";

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

    public function test_comment_delete()
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

        $route = route('place.comment.destroy', [
            'language' => 'en',
            'place' => $place->id,
            'comment' => $comment->id,
        ]);

        $redirectRoute = route('place.show', [
            'language' => 'en',
            'place' => $place->id,
        ]);

        $this->actingAs($user)
            ->delete($route)
            ->assertRedirect($redirectRoute);

        $this->assertDatabaseMissing('place_comments', [
            'id' => $comment->id
        ]);
    }
}
