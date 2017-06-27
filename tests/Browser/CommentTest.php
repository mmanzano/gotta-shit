<?php

namespace Tests\Browser;

use GottaShit\Entities\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Lang;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class CommentTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function xtest_comment_lang()
    {
        $this->assertTrue(Lang::has('gottashit.comment.create_comment_label'));
        $this->assertTrue(Lang::has('gottashit.comment.create_comment'));
        $this->assertTrue(Lang::has('gottashit.comment.comments'));
        $this->assertTrue(Lang::has('gottashit.comment.created_comment'));
        $this->assertTrue(Lang::has('gottashit.comment.edit_comment'));
        $this->assertTrue(Lang::has('gottashit.comment.update_comment'));
        $this->assertTrue(Lang::has('gottashit.comment.updated_comment'));
        $this->assertTrue(Lang::has('gottashit.comment.delete_comment'));
        $this->assertTrue(Lang::has('gottashit.comment.deleted_comment'));
    }

    public function xtest_comment_create()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::all()->first())
                ->visit('/en/place/create')
                ->type('name','Bar Pepe')
                ->type('geo_lat', '40.5')
                ->type('geo_lng', '-3.4')
                ->select('stars', '3')
                ->press(trans('gottashit.place.create_place'))
                ->see(trans('gottashit.comment.create_comment_label'))
                ->see(trans_choice('gottashit.comment.comments', 0,
                    ['number_of_comments' => 0]))
                ->type('comment', 'Hello! Great Site')
                ->press(trans('gottashit.comment.create_comment'))
                ->waitForText(trans('gottashit.comment.created_comment',
                    ['place' => 'Bar Pepe']))
                ->see(trans_choice('gottashit.comment.comments', 1,
                    ['number_of_comments' => 1]))
                ->see('3.00')
                ->see('Hello! Great Site');
        });
    }

    public function xtest_comment_edit()
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
            ->see(trans('gottashit.comment.updated_comment',
                ['place' => 'Bar Pepe']))
            ->see('3.00')
            ->see('Adios');
    }

    public function xtest_comment_delete()
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
            ->see(trans('gottashit.comment.deleted_comment',
                ['place' => 'Bar Pepe']))
            ->see('3.00')
            ->dontSee('Hello! Great Site');
    }
}
