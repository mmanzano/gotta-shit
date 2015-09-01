<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Entities\User;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Social authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Social.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        return $this->findOrCreateUser($provider, $user);


    }


    private function findOrCreateUser($provider, $user)
    {
        $userExists = false;

        if($provider == "github"){
            if ($authUser = User::where('github_id', $user->getId())->first()) {
                $userExists = true;
            } else if (Auth::check()) {
                $authUser = Auth::user();
                $userExists = true;
            } else if ($authUser = User::where('email', $user->getEmail())->first()) {
                $userExists = true;
            }
            if($userExists) {
                $authUser->github_id = $user->getId();
                $authUser->save();
            }
        }

        if($provider == "facebook"){
            if ($authUser = User::where('facebook_id', $user->getId())->first()) {
                $userExists = true;
            } else if (Auth::check()) {
                $authUser = Auth::user();
                $userExists = true;
            } else if ($authUser = User::where('email', $user->getEmail())->first()) {
                $userExists = true;
            }

            if($userExists){
                $authUser->facebook_id = $user->getId();
                $authUser->save();
            }

        }

        if($provider == "twitter"){
            if ($authUser = User::where('twitter_id', $user->getId())->first()) {
                $userExists = true;
            } else if (Auth::check()) {
                $authUser = Auth::user();
                $userExists = true;
            } else if ($authUser = User::where('email', $user->getEmail())->first()) {
                $userExists = true;
            }
            if($userExists){
                $authUser->twitter_id = $user->getId();
                $authUser->save();
            }
        }

        if($userExists) {
            $status_message = "";

            if(is_null($authUser->email) && ! is_null($user->getEmail())){
                if(User::where('email', $user->getEmail())->count() == 0) {
                    $authUser->email = $user->getEmail();
                    $authUser->modified = false;
                    $authUser->save();
                } else {
                    $status_message = "Sorry, send a email to got2shit@gmail.com with subject: I can't add email from facebook or github to my twitter account";
                }
            }

            if(! $authUser->avatar){
                $authUser->avatar = $user->getAvatar();
                $authUser->save();
            }

            $authUser->avatar = $user->getAvatar();

            Auth::login($authUser, true);

            return redirect(route('root'))->with('status', $status_message);
        }

        return $this->createUserAndRouteToProfile($provider, $user);

    }

    private function createUserAndRouteToProfile($provider, $user){

        $authUser = new User();

        $authUser->full_name = $user->getName();
        $authUser->username = $this->username($user);
        $authUser->email = $user->getEmail();
        $authUser->avatar = $user->getAvatar();
        $authUser->verified = true;

        if($provider == 'github'){
            $authUser->github_id = $user->getId();
        }

        if($provider == 'facebook'){
            $authUser->facebook_id = $user->getId();
        }
        if($provider == 'twitter'){
            $authUser->twitter_id = $user->getId();
            $authUser->modified = true;
        }
        $authUser->save();

        Auth::login($authUser, true);

        return redirect(route('user_profile', ['language' => App::getLocale(), 'user' => Auth::user()->id]));

    }
    private function username($user)
    {
        $name = $user->getName();

        $nick = $user->getNickname();

        $anexo = 1;

        if(trim($nick) != "") {
            $username = $nick;
        }
        else {
            $username = str_slug($name);
        }

        while(User::where('username', $username)->count() != 0) {
            $username = $username . $anexo;
            $anexo++;
        }

        return $username;
    }

}
