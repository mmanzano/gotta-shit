<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class PlaceLanguageTest extends TestCase
{
    /**  @test */
    public function placeLang()
    {
        $this->assertTrue(Lang::has('gottashit.place.create_place'));
        $this->assertTrue(Lang::has('gottashit.place.created_place'));
        $this->assertTrue(Lang::has('gottashit.place.edit_place'));
        $this->assertTrue(Lang::has('gottashit.place.update_place'));
        $this->assertTrue(Lang::has('gottashit.place.updated_place'));
        $this->assertTrue(Lang::has('gottashit.place.delete_place'));
        $this->assertTrue(Lang::has('gottashit.place.deleted_place'));
    }
}
