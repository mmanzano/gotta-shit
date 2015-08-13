<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
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

    public function getLocaleEmail($language)
    {
        App::setLocale(Session::get('language', $language));

        return $this->getEmail();
    }

    public function postLocaleEmail(Request $request, $language)
    {
        App::setLocale(Session::get('language', $language));

        $this->subject = trans('gottashit.email.reset_password_subject');

        return $this->postEmail($request);
    }

    public function getLocaleReset($language, $token)
    {
        App::setLocale(Session::get('language', $language));

        return $this->getReset($token);
    }
    public function postLocaleReset(Request $request, $language)
    {
        App::setLocale(Session::get('language', $language));

        $this->redirectTo = route('home', ['language' => $language]);

        return $this->postReset($request);
    }

}
