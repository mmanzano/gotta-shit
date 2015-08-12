<?php namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Entities\User;
use GottaShit\Mailers\AppMailer;
use Illuminate\Http\Request;
use GottaShit\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class RegistrationController extends Controller
{
    /**
     * Show the register page.
     *
     * @return \Response
     */
    public function register($language)
    {
        App::setLocale($language);

        return view('auth.register');
    }

    /**
     * Perform the registration.
     *
     * @param  Request   $request
     * @param  AppMailer $mailer
     * @return \Redirect
     */
    public function postRegister(Request $request, AppMailer $mailer, $language)
    {
        App::setLocale($language);

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
        ]);

        $mailer->sendEmailConfirmationTo($user, trans('gottashit.email.confirm_email_subject'));

        $status_message = trans('auth.confirm_email');

        return redirect(route('user_login', ['language' => App::getLocale()]))->with('status', $status_message);
    }

    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($language, $token)
    {
        App::setLocale($language);

        User::where('token', $token)->firstOrFail()->confirmEmail();

        $status_message = trans('auth.confirmed') ;

        return redirect(route('user_login', ['language' => App::getLocale()]))->with('status', $status_message);
    }
}