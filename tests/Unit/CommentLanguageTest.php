<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentLanguageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_comment_lang()
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
}
