<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Http\Controllers\Controller;
use GottaShit\Http\Requests\Auth\LoginPostRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\View\View;

class SessionsController extends Controller
{
    use ThrottlesLogins;

    protected $loginPath;

    public function __construct()
    {
        $this->middleware('guest', ['only' => ['login', 'postLogin']]);

        $this->middleware('auth', ['only' => ['logout']]);
    }

    public function login(): View
    {
        return view('auth.login', [
            'title' => trans('gottashit.title.login'),
        ]);
    }

    public function postLogin(LoginPostRequest $request): RedirectResponse
    {
        $this->loginPath = route('user_login');

        if ($this->signIn($request)) {
            return redirect(route('home'))
                ->with('status', trans('auth.login'));
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect(route('home'))
            ->with('status', trans('auth.logout'));
    }

    protected function signIn(Request $request): bool
    {
        return Auth::attempt(
            $this->getCredentials($request),
            $request->has('remember')
        );
    }

    protected function getCredentials(Request $request): array
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'verified' => true,
        ];
    }

    protected function isUsingThrottlesLoginsTrait(): bool
    {
        return in_array(
            ThrottlesLogins::class,
            class_uses_recursive(get_class($this))
        );
    }

    public function loginUsername(): string
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    public function loginPath(): string
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/login';
    }

    protected function getFailedLoginMessage(): string
    {
        return trans('auth.failed');
    }
}
