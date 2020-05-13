<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterPostRequest;
use App\Notifications\UserConfirmationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => ['register', 'postRegister']]);
    }

    public function register(): View
    {
        return view('auth.register', [
            'title' => trans('gottashit.title.register'),
        ]);
    }

    public function postRegister(RegisterPostRequest $request): RedirectResponse
    {
        $user = User::create([
            'full_name' => $request->input('full_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'language' => App::getLocale(),
        ]);

        $user->notify(new UserConfirmationNotification(trans('gottashit.email.confirm_email_subject')));

        return redirect(route('user_login'))
            ->with('status', trans('auth.confirm_email'));
    }

    public function confirmEmail(string $token): RedirectResponse
    {
        $user = User::where('token', $token)->firstOrFail();

        $user->confirmEmail();

        Auth::login($user, true);

        return redirect(route('home'))->with('status', trans('auth.confirmed'));
    }
}
