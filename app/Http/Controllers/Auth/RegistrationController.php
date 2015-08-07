<?php namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Entities\User;
use GottaShit\Mailers\AppMailer;
use Illuminate\Http\Request;
use GottaShit\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    /**
     * Show the register page.
     *
     * @return \Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Perform the registration.
     *
     * @param  Request   $request
     * @param  AppMailer $mailer
     * @return \Redirect
     */
    public function postRegister(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
          'full_name' => 'required|max:255',
          'username' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'full_name' => $request->input('full_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $mailer->sendEmailConfirmationTo($user);

        $status_message = 'Please confirm your email address';

        return redirect('/')->with('status', $status_message);
    }

    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($token)
    {
        //return $token;

        User::where('token', $token)->firstOrFail()->confirmEmail();

        $status_message = 'You are now confirmed. Please login.';

        return redirect('/')->with('status', $status_message);
    }
}