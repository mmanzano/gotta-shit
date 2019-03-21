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

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(User $user)
    {
        $is_user = $this->isAuthUser($user->id);

        $title = trans('gottashit.title.user_profile', ['user' => $user->username]);

        return view('auth.view', compact('title', 'user', 'is_user'));
    }

    public function edit(User $user)
    {
        if (!$this->isAuthUser($user->id)) {
            $statusMessage = trans('gottashit.user.edit_user_not_allowed');

            $userShowRoute = route(
                'user.show',
                [
                    'user' => Auth::user()->id,
                ]
            );

            return redirect($userShowRoute)->with('status', $statusMessage);
        }

        $title = trans('gottashit.title.edit_user', ['user' => $user->username]);

        return view('auth.edit', compact('title', 'user'));
    }

    public function update(
        Request $request,
        AppMailer $mailer,
        User $user
    ) {
        $logout = false;
        $statusMessage = "";

        if (!$this->isAuthUser($user->id)) {
            $statusMessage = trans('gottashit.user.update_user_not_allowed');

            $homeRoute = route('home');

            return redirect($homeRoute)->with('status', $statusMessage);
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
            $mailer->sendEmailConfirmationTo($user, trans('gottashit.email.confirm_email_new_subject'));

            $statusMessage = trans('auth.confirm_email') . "<br/>";
        }

        if (trim($request->input('password')) != "") {
            $this->validate($request, [
                'password' => 'confirmed|min:6',
            ]);

            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        $statusMessage .= trans('gottashit.user.updated_user', ['user' => $user->full_name]);

        if ($logout) {
            Auth::logout();

            $homeRoute = route('home');

            return redirect($homeRoute)->with('status', $statusMessage);
        }

        $userShowRoute = route(
            'user.show',
            [
                'user' => Auth::id(),
            ]
        );

        return redirect($userShowRoute)
            ->with('status', $statusMessage);
    }

    private function isAuthUser($userId)
    {
        return Auth::id() == $userId;
    }
}
