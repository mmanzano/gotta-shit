<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Session;

class SessionsController extends Controller
{
    use ThrottlesLogins;

    protected $loginPath;

    public function __construct(){
        $this->middleware('guest', ['only' => ['login', 'postLogin']]);

        $this->middleware('auth', ['only' => ['logout']]);
    }

    /**
     * Show the login page.
     *
     * @param $language
     * @return \Response
     */
    public function login($language)
    {
        $title = trans('gottashit.title.login');

        return view('auth.login', compact('title'));
    }

    /**
     * Perform the login.
     *
     * @param  Request $request
     * @param $language
     * @return \Redirect
     */
    public function postLogin(Request $request, $language)
    {
        $this->loginPath = route('user_login',
            ['language' => App::getLocale()]);

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($this->signIn($request)) {
            $status_message = trans('auth.login');

            return redirect(route('home',
                ['language' => App::getLocale()]))->with('status',
                $status_message);
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
     * @param $language
     * @return \Redirect
     */
    public function logout($language)
    {
        Auth::logout();

        $status_message = trans('auth.logout');

        return redirect(route('home',
            ['language' => App::getLocale()]))->with('status', $status_message);
    }

    /**
     * Attempt to sign in the user.
     *
     * @param  Request $request
     * @return boolean
     */
    protected function signIn(Request $request)
    {
        return Auth::attempt($this->getCredentials($request),
            $request->has('remember'));
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
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'verified' => true
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
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
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
        return property_exists($this,
            'loginPath') ? $this->loginPath : '/login';
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
