<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Entities\User;
use GottaShit\Http\Controllers\Controller;
use GottaShit\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller
{

    public function __construct(){
        $this->middleware('guest', ['only' => ['register', 'postRegister']]);
    }
    /**
     * Show the register page.
     *
     * @param $language
     * @return \Response
     */
    public function register($language)
    {
        $this->setLanguage($language);

        $title = trans('gottashit.title.register');

        return view('auth.register', compact('title'));
    }

    /**
     * Perform the registration.
     *
     * @param  Request $request
     * @param  AppMailer $mailer
     * @param $language
     * @return \Redirect
     */
    public function postRegister(Request $request, AppMailer $mailer, $language)
    {
        $this->setLanguage($language);

        $this->validate($request, [
            'full_name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'full_name' => $request->input('full_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'language' => App::getLocale(),
        ]);

        $mailer->sendEmailConfirmationTo($user,
            trans('gottashit.email.confirm_email_subject'));

        $status_message = trans('auth.confirm_email');

        return redirect(route('user_login',
            ['language' => App::getLocale()]))->with('status', $status_message);
    }

    /**
     * Confirm a user's email address.
     *
     * @param $language
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($language, $token)
    {
        $this->setLanguage($language);

        User::where('token', $token)->firstOrFail()->confirmEmail();

        $status_message = trans('auth.confirmed');

        if (Auth::check()) {
            return redirect(route('root'));
        } else {
            return redirect(route('user_login',
                ['language' => App::getLocale()]))->with('status',
                $status_message);
        }
    }
}
