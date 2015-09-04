<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use GottaShit\Entities\User;
use Illuminate\Support\Facades\Lang;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_user_may_register_for_an_account_but_must_confirm_their_email_address(
    ) {
        $this->visit('/en/register')
            ->type('Got to shit', 'full_name')
            ->type('gottashit', 'username')
            ->type('got2shit@gmail.com', 'email')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->press('Register');

        $this->see(trans('auth.confirm_email'))
            ->seeInDatabase('users',
                ['username' => 'gottashit', 'verified' => 0]);

        $user = User::whereUsername('gottashit')->first();

        // You can't login until you confirm your email address.
        $this->login($user)->see(trans('auth.failed'));

        // Like this...
        $this->visit("/en/register/confirm/{$user->token}")
            ->see(trans('auth.confirmed'))
            ->seeInDatabase('users',
                ['username' => 'gottashit', 'verified' => 1]);
    }

    protected function login($user = null)
    {
        $user = $user ?: $this->factory->create('GottaShit\Entities\User',
            ['password' => 'secret']);

        return $this->visit('/en/login')
            ->type($user->email, 'email')
            ->type('secret', 'password')// You might want to change this.
            ->press('Login');
    }
}
