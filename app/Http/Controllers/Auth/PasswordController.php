<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo;

    protected $subject;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getLocaleEmail(string $language)
    {
        return $this->getEmail();
    }

    public function postLocaleEmail(Request $request, string $language)
    {
        $this->subject = trans('gottashit.email.reset_password_subject');

        return $this->postEmail($request);
    }

    public function getLocaleReset(string $language, string $token)
    {
        return $this->getReset($token);
    }

    public function postLocaleReset(Request $request, string $language)
    {
        $this->redirectTo = route('home', ['language' => App::getLocale()]);

        return $this->postReset($request);
    }
}
