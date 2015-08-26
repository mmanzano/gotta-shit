<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_comment_lang()
    {
        $this->assertTrue(lang::has('gottashit.comment.create_comment_label'));
        $this->assertTrue(lang::has('gottashit.comment.create_comment'));
        $this->assertTrue(lang::has('gottashit.comment.comments'));
        $this->assertTrue(lang::has('gottashit.comment.created_comment'));
        $this->assertTrue(lang::has('gottashit.comment.edit_comment'));
        $this->assertTrue(lang::has('gottashit.comment.update_comment'));
        $this->assertTrue(lang::has('gottashit.comment.updated_comment'));
        $this->assertTrue(lang::has('gottashit.comment.delete_comment'));
        $this->assertTrue(lang::has('gottashit.comment.deleted_comment'));
    }

    public function old_test_comment_create()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/en/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('3', 'stars')
          ->press(trans('gottashit.place.create_place'))
          ->see(trans('gottashit.comment.create_comment_label'))
          ->see(trans_choice('gottashit.comment.comments', 0, ['number_of_comments' => 0]))
          ->type('Hello! Great Site', 'comment')
          ->press(trans('gottashit.comment.create_comment'))
          ->see(trans('gottashit.comment.created_comment', ['place' => 'Bar Pepe']))
          ->see(trans_choice('gottashit.comment.comments', 1, ['number_of_comments' => 1]))
          ->see('3.00')
          ->see('Hello! Great Site');
    }

    public function old_test_comment_edit()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/en/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('3', 'stars')
          ->press(trans('gottashit.place.create_place'))
          ->type('Hello! Great Site', 'comment')
          ->press(trans('gottashit.comment.create_comment'))
          ->see('3.00')
          ->see('Hello! Great Site')
          ->click(trans('gottashit.comment.edit_comment'))
          ->dontSee('3.00')
          ->type('Adios', 'comment')
          ->press(trans('gottashit.comment.update_comment'))
          ->see(trans('gottashit.comment.updated_comment', ['place' => 'Bar Pepe']))
          ->see('3.00')
          ->see('Adios');
    }

    public function old_test_comment_delete()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
          ->visit('/en/place/create')
          ->type('Bar Pepe', 'name')
          ->type('40.5', 'geo_lat')
          ->type('-3.4', 'geo_lng')
          ->select('3', 'stars')
          ->press(trans('gottashit.place.create_place'))
          ->type('Hello! Great Site', 'comment')
          ->press(trans('gottashit.comment.create_comment'))
          ->see('3.00')
          ->see('Hello! Great Site')
          ->press(trans('gottashit.comment.delete_comment'))
          ->see(trans('gottashit.comment.deleted_comment', ['place' => 'Bar Pepe']))
          ->see('3.00')
          ->dontSee('Hello! Great Site');
    }
}
