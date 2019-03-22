<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

class SessionsController extends Controller
{
    use ThrottlesLogins;

    protected $loginPath;

    public function __construct()
    {
        $this->middleware('guest', ['only' => ['login', 'postLogin']]);

        $this->middleware('auth', ['only' => ['logout']]);
    }

    /**
     * Show the login page.
     *
     * @return \Response
     */
    public function login()
    {
        $title = trans('gottashit.title.login');

        return view('auth.login', compact('title'));
    }

    /**
     * Perform the login.
     *
     * @param Request $request
     * @return \Redirect
     */
    public function postLogin(Request $request)
    {
        $this->loginPath = route('user_login');

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($this->signIn($request)) {
            $statusMessage = trans('auth.login');

            $homeRoute = route('home');

            return redirect($homeRoute)
                ->with('status', $statusMessage);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Destroy the user's current session.
     *
     * @return \Redirect
     */
    public function logout()
    {
        Auth::logout();

        $statusMessage = trans('auth.logout');

        $homeRoute = route('home');

        return redirect($homeRoute)
            ->with('status', $statusMessage);
    }

    /**
     * Attempt to sign in the user.
     *
     * @param Request $request
     * @return boolean
     */
    protected function signIn(Request $request)
    {
        return Auth::attempt(
            $this->getCredentials($request),
            $request->has('remember')
        );
    }

    /**
     * Get the login credentials and requirements.
     *
     * @param Request $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'verified' => true,
        ];
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class,
            class_uses_recursive(get_class($this))
        );
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/login';
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return trans('auth.failed');
    }
}
