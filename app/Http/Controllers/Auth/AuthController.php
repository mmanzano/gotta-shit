<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Entities\User;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();

        $authUser = $this->findOrCreateUser('github', $user);

        Auth::login($authUser, true);

        return redirect(route('root'));

    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $authUser = $this->findOrCreateUser('facebook', $user);

        Auth::login($authUser, true);

        return redirect(route('root'));

    }


    private function findOrCreateUser($provider, $user)
    {
        if($provider = "github"){
            if ($authUser = User::where('github_id', $user->getId())->first()) {
                return $authUser;
            } else if ($authUser = User::where('email', $user->getEmail())->first()) {
                return $authUser;
            }
        }

        if($provider = "facebook"){
            if ($authUser = User::where('facebook_id', $user->getId())->first()) {
                return $authUser;
            } else if ($authUser = User::where('email', $user->getEmail())->first()) {
                return $authUser;
            }
        }

        return $this->createUser($provider, $user);
    }

    private function createUser($provider, $user){

        $authUser = User::create([
          'full_name' => $user->getName(),
          'username' => $user->getNickname() != "" ? $user->getNickname() : $this->camelCase($user->getName()),
          'email' => $user->getEmail(),
          'avatar' => $user->getAvatar()
        ]);

        if($provider == 'github'){
            $authUser->github_id = $user->getId();
        }

        if($provider == 'facebook'){
            $authUser->facebook_id = $user->getId();
        }


        $authUser->verified = true;

        $authUser->save();

        return $authUser;

    }

    public function camelCase($str, array $noStrip = [])
    {
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }

}
