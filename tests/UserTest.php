<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use GottaShit\Entities\User;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_user_may_register_for_an_account_but_must_confirm_their_email_address()
    {
        $this->visit('/register')
            ->type('Got to shit', 'full_name')
            ->type('gottashit', 'username')
            ->type('got2shit@gmail.com', 'email')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->press('Register');

        $this->see('Please confirm your email address')
            ->seeInDatabase('users', ['username' => 'gottashit', 'verified' => 0]);

        $user = User::whereUsername('gottashit')->first();

        // You can't login until you confirm your email address.
       $this->login($user)->see('Could not sign you in.');

        // Like this...
        $this->visit("/register/confirm/{$user->token}")
          ->see('You are now confirmed. Please login.')
          ->seeInDatabase('users', ['username' => 'gottashit', 'verified' => 1]);
    }

    protected function login($user = null)
    {
        $user = $user ?: $this->factory->create('GottaShit\Entities\User', ['password' => 'secret']);

        return $this->visit('/login')
          ->type($user->email, 'email')
          ->type('secret', 'password') // You might want to change this.
          ->press('Login');
    }
}
