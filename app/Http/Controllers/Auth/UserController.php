<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Entities\User;
use GottaShit\Http\Controllers\Controller;
use GottaShit\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;

class UserController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function show(string $language, User $user)
    {
        $is_user = $this->isAuthUser($user->id);

        $title = trans('gottashit.title.user_profile',
            ['user' => $user->username]);

        return view('auth.view', compact('title', 'user', 'is_user'));
    }

    public function edit(string $language, User $user)
    {
        if (!$this->isAuthUser($user->id)) {
            $status_message = trans('gottashit.user.edit_user_not_allowed');

            return redirect(route('user.show', [
                'language' => App::getLocale(),
                'user' => Auth::user()->id
            ]))->with('status', $status_message);
        }

        $title = trans('gottashit.title.edit_user',
            ['user' => $user->username]);

        return view('auth.edit', compact('title', 'user'));
    }

    public function update(
        Request $request,
        AppMailer $mailer,
        string $language,
        User $user
    ) {
        $logout = false;
        $status_message = "";

        if (!$this->isAuthUser($user->id)) {
            $status_message = trans('gottashit.user.update_user_not_allowed');

            return redirect(route('home',
                ['language' => App::getLocale()]))->with('status', $status_message);
        }

        $this->validate($request, [
            'full_name' => 'required|max:255',
        ]);

        $user->full_name = $request->input('full_name');
        if ($request->input('username') != $user->username) {
            $this->validate($request, [
                'username' => 'required|max:255|unique:users',
            ]);

            $user->username = $request->input('username');
        }

        if ($request->input('email') != $user->email) {
            $this->validate($request, [
                'email' => 'required|email|max:255|unique:users',
            ]);

            $user->email = $request->input('email');
            $user->token = str_random(30);
            $user->modified = true;
            $mailer->sendEmailConfirmationTo($user,
                trans('gottashit.email.confirm_email_new_subject'));

            $status_message = trans('auth.confirm_email') . "<br/>";
        }

        if (trim($request->input('password')) != "") {
            $this->validate($request, [
                'password' => 'confirmed|min:6',
            ]);

            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        $status_message .= trans('gottashit.user.updated_user',
            ['user' => $user->full_name]);

        if ($logout) {
            Auth::logout();

            return redirect(route('home',
                ['language' => App::getLocale()]))->with('status', $status_message);
        }

        return redirect(route('user.show', [
            'language' => App::getLocale(),
            'user' => Auth::user()->id
        ]))->with('status', $status_message);
    }

    private function isAuthUser($userId)
    {
        if (Auth::check()) {
            return Auth::id() == $userId;
        }

        return false;
    }
}
