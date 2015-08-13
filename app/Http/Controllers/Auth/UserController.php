<?php namespace GottaShit\Http\Controllers\Auth;

use Illuminate\Auth;
use GottaShit\Entities\User;
use Illuminate\Http\Request;
use GottaShit\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use GottaShit\Mailers\AppMailer;

class UserController extends Controller
{
    public function show($language, $user_id)
    {
        App::setLocale(Session::get('language', $language));

        $user = User::findOrFail($user_id);
        $is_user =  $this->is_user($user_id);

        return view('auth.view', compact('user', 'is_user' ));
    }

    public function edit($language, $user_id)
    {
        App::setLocale(Session::get('language', $language));

        $user = User::findOrFail($user_id);

        if ( ! $this->is_user($user_id)){
            $status_message = trans('gottashit.user.edit_user_not_allowed');
            return redirect(route('user_profile', ['language' => $language, 'user' => \Auth::User()->id]))->with('status', $status_message);
        }

        return view('auth.edit', compact('user'));
    }

    public function update(Request $request, AppMailer $mailer, $language, $user_id)
    {
        App::setLocale(Session::get('language', $language));

        $logout = false;
        $status_message = "";

        if ( ! $this->is_user($user_id)){
            $status_message = trans('gottashit.user.update_user_not_allowed');
            return redirect(route('home', ['language' => $language]))->with('status', $status_message);
        }

        $this->validate($request, [
          'full_name' => 'required|max:255',
        ]);

        $user = User::findOrFail($user_id);

        $user->full_name = $request->input('full_name');
        if ($request->input('username') != $user->username)
        {
            $this->validate($request, [
              'username' => 'required|max:255|unique:users',
            ]);

            $user->username = $request->input('username');
        }

        if ($request->input('email') != $user->email)
        {
            $this->validate($request, [
              'email' => 'required|email|max:255|unique:users',
            ]);

            $user->email = $request->input('email');
            $user->token = str_random(30);
            $user->verified = false;
            $mailer->sendEmailConfirmationTo($user, trans('gottashit.email.confirm_email_new_subject'));

            $status_message = trans('auth.confirm_email') . "<br/>";

            $logout = true;
        }

        if (trim($request->input('password')) != "")
        {
            $this->validate($request, [
              'password' => 'confirmed|min:6',
            ]);

            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        $status_message .= trans('gottashit.user.updated_user', ['user' => $user->full_name]);

        if ($logout) {
            Auth::logout();

            redirect(route('home', ['language' => $language]))->with('status', $status_message);
        }

        return redirect(route('user_profile', ['language' => $language, 'user' => \Auth::User()->id]))->with('status', $status_message);
    }

    public function is_user($user_id)
    {
        if (\Auth::check()){
            $current_user_id = \Auth::User()->id;
            if ($current_user_id == $user_id){
                return true;
            }
        }
    }

}