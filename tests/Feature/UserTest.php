<?php

namespace Tests\Feature;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aUserMayRegisterForAnAccountButMustConfirmTheirEmailAddress()
    {
        $registerRoute = route('user_register');

        $this->post($registerRoute, [
            'full_name' => 'Got to shit',
            'username' => 'gottashit',
            'email' => 'got2shit@gmail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'gottashit',
            'verified' => 0
        ]);

        $user = User::whereUsername('gottashit')->first();

        $registerConfirmRoute = route('user_register_confirm', [
            'token' => $user->token,
        ]);

        $this->get($registerConfirmRoute);

        $this->assertDatabaseHas('users', [
            'username' => 'gottashit',
            'verified' => 1
        ]);
    }
}
