<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class PlaceTest extends TestCase
{
    use DatabaseTransactions;

    public function xtest_comment_lang()
    {
        $this->assertTrue(Lang::has('gottashit.place.create_place'));
        $this->assertTrue(Lang::has('gottashit.place.created_place'));
        $this->assertTrue(Lang::has('gottashit.place.edit_place'));
        $this->assertTrue(Lang::has('gottashit.place.update_place'));
        $this->assertTrue(Lang::has('gottashit.place.updated_place'));
        $this->assertTrue(Lang::has('gottashit.place.delete_place'));
        $this->assertTrue(Lang::has('gottashit.place.deleted_place'));
    }

    public function xtest_place_create()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
            ->visit('/en/place/create')
            ->type('Bar Pepe', 'name')
            ->type('40.5', 'geo_lat')
            ->type('-3.4', 'geo_lng')
            ->select('4', 'stars')
            ->press(trans('gottashit.place.create_place'))
            ->see(trans('gottashit.place.created_place',
                ['place' => 'Bar Pepe']))
            ->see('4.00');
    }

    public function xtest_place_edit()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
            ->visit('/en/place/create')
            ->type('Bar Pepe', 'name')
            ->type('40.5', 'geo_lat')
            ->type('-3.4', 'geo_lng')
            ->select('4', 'stars')
            ->press(trans('gottashit.place.create_place'))
            ->click(trans('gottashit.place.edit_place'))
            ->type('Bar Pepe 2', 'name')
            ->type('40.5', 'geo_lat')
            ->type('-3.4', 'geo_lng')
            ->select('5', 'stars')
            ->press(trans('gottashit.place.update_place'))
            ->see(trans('gottashit.place.updated_place',
                ['place' => 'Bar Pepe 2']));
    }

    public function xtest_place_delete()
    {
        $user = factory('GottaShit\Entities\User')->create();

        $this->actingAs($user)
            ->visit('/en/place/create')
            ->type('Bar Pepe', 'name')
            ->type('40.5', 'geo_lat')
            ->type('-3.4', 'geo_lng')
            ->select('4', 'stars')
            ->press(trans('gottashit.place.create_place'))
            ->see(trans('gottashit.place.created_place',
                ['place' => 'Bar Pepe']))
            ->see('4.00')
            ->press(trans('gottashit.place.delete_place'))
            ->see(trans('gottashit.place.deleted_place',
                ['place' => 'Bar Pepe']))
            ->seePageIs('/en/place/user');
    }
}
