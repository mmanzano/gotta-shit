<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use GottaShit\Entities\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_user_may_register_for_an_account_but_must_confirm_their_email_address() {
        $this->post('en/register', [
            'full_name' => 'Got to shit',
            'username' => 'gottashit',
            'email' => 'got2shit@gmail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertDatabaseHas('users',[
            'username' => 'gottashit',
            'verified' => 0
        ]);

        $user = User::whereUsername('gottashit')->first();

        $this->get("/en/register/confirm/{$user->token}");

        $this->assertDatabaseHas('users', [
            'username' => 'gottashit',
            'verified' => 1
        ]);
    }
}
