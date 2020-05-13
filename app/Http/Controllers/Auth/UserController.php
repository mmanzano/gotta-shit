<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserEditRequest;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Jobs\ManageChangeEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\View\View;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(User $user): View
    {
        return view('auth.view', [
            'title' => trans('gottashit.title.user_profile', ['user' => $user->username]),
            'user' => $user,
            'is_user' => $user->id === Auth::id(),
        ]);
    }

    public function edit(UserEditRequest $request, User $user): View
    {
        return view('auth.edit', [
            'title' => trans('gottashit.title.edit_user', ['user' => $user->username]),
            'user' => $user,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'full_name' => request('full_name'),
            'username' => request('username'),
            'password' => trim(request('password'))
                ? bcrypt(request('password'))
                : $user->password,
        ]);

        if (request('email') != $user->email) {
            ManageChangeEmail::dispatch($user);

            return redirect($user->path)
                ->with('status', trans('auth.confirm_email'));
        }

        $statusMessage = trans('gottashit.user.updated_user', ['user' => $user->full_name]);

        return redirect($user->path)
            ->with('status', $statusMessage);
    }
}
