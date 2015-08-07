<?php namespace GottaShit\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use GottaShit\Http\Controllers\Controller;

class SessionsController extends Controller
{

    /**
     * Show the login page.
     *
     * @return \Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Perform the login.
     *
     * @param  Request  $request
     * @return \Redirect
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);

        if ($this->signIn($request)) {
            $status_message = 'Welcome back!';

            return redirect('/')->with('status', $status_message);
        }

        $status_message = 'Could not sign you in.';

        return redirect('/')->with('status', $status_message);
    }

    /**
     * Destroy the user's current session.
     *
     * @return \Redirect
     */
    public function logout()
    {
        Auth::logout();


        $status_message = 'You have now been signed out. See you.';

        return redirect('/')->with('status', $status_message);
    }

    /**
     * Attempt to sign in the user.
     *
     * @param  Request $request
     * @return boolean
     */
    protected function signIn(Request $request)
    {
        return Auth::attempt($this->getCredentials($request), $request->has('remember'));
    }

    /**
     * Get the login credentials and requirements.
     *
     * @param  Request $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return [
          'email'    => $request->input('email'),
          'password' => $request->input('password'),
          'verified' => true
        ];
    }
}