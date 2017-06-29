<?php

namespace Tests\Feature;

use GottaShit\Entities\Place;
use GottaShit\Entities\PlaceComment;
use GottaShit\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function comment_create()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);
        $response = $this->post("/en/place/{$place->id}/comment", [
            'comment' => 'Hello! Great Site',
        ]);

        $comment = PlaceComment::all()->first();

        $response->assertRedirect("/en/place/{$place->id}#comment-{$comment->id}");

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

        $this->actingAs($user);
        $response = $this->put("/en/place/{$place->id}/comment/{$comment->id}", [
            'comment' => 'GoodBye',
        ])->assertRedirect("/en/place/{$place->id}#comment-{$comment->id}");

        $comment = PlaceComment::all()->first();

        $response->assertRedirect("/en/place/{$place->id}#comment-{$comment->id}");

        $this->assertDatabaseHas('place_comments', [
            'place_id' => $place->id,
            'user_id' => $user->id,
            'comment' => 'GoodBye',
        ]);
    }

    public function xtest_comment_delete()
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

        $this->assertDatabaseHas('place_comment', [
            'id' => $comment->id
        ]);
        $this->actingAs($user);
        $this->delete("/en/place/{$place->id}/comment/{$comment->id}")->assertRedirect("/en/place/{$place->id}");
        $this->assertDatabaseMissing('place_comment', [
            'id' => $comment->id
        ]);
    }
}
