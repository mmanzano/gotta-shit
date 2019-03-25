<?php

namespace GottaShit\Services;

use GottaShit\Entities\User;
use Illuminate\Support\Facades\Auth;

class SocialiteGottaShit
{
    public function getAuthUser($socialiteUser, $provider)
    {
        $authUser = null;

        $socialiteId = $socialiteUser->getId();

        $socialiteEmail = $socialiteUser->getEmail();

        if ($this->validProvider($provider)) {
            $authUser = $this->getUserFromSocialite($provider, $socialiteId, $socialiteEmail);
        }

        if ($authUser) {
            $authUser = $this->updateUser($provider, $socialiteUser, $authUser);
        } else {
            $authUser = $this->createUser($provider, $socialiteUser);
        }

        return $authUser;
    }

    private function validProvider(string $provider): bool
    {
        return in_array($provider, ['github', 'facebook', 'twitter']);
    }

    private function getUserFromSocialite(string $provider, string $socialiteId, ?string $socialiteEmail)
    {
        if ($socialiteId && $user = User::where($provider . '_id', $socialiteId)->first()) {
            return $user;
        }

        if ($socialiteEmail && $user = User::where('email', $socialiteEmail)->first()) {
            return $user;
        }

        if ($user = Auth::user()) {
            return $user;
        }

        return null;
    }

    private function updateUser(string $provider, $socialiteUser, $authUser)
    {
        $socialiteId = $socialiteUser->getId();

        $socialiteEmail = $socialiteUser->getEmail();

        $socialiteAvatar = $socialiteUser->getavatar();

        $this->updateSocialiteInfo($provider, $authUser, $socialiteId, $socialiteAvatar);

        if (is_null($authUser->email)
            && !is_null($socialiteEmail)
            && !User::where('email', $socialiteEmail)->exists) {
            $authUser->update([
                'email' => $socialiteEmail,
                'modified' => false,
            ]);
        }

        return $authUser;
    }

    private function updateSocialiteInfo(string $provider, $user, $socialiteId, $socialiteAvatar)
    {
        if ($this->validProvider($provider)) {
            $user->update([
                $provider . '_id' => $socialiteId,
                'avatar' => $socialiteAvatar,
            ]);
        }
    }

    private function createUser($provider, $user)
    {
        $authUser = User::create([
            'full_name' => $user->getName(),
            'username' => $this->newUsername($user),
            'email' => $user->getEmail(),
            'avatar' => $user->getAvatar(),
            'verified' => true,
        ]);

        if ($this->validProvider($provider)) {
            $authUser->update([
                $provider . '_id' => $user->getId(),
                'modified' => $provider === 'twitter',
            ]);
        }

        return $authUser;
    }

    private function newUsername($user)
    {
        $username = trim($user->getNickname())
            ? $user->getNickname()
            : str_slug($user->getName());

        $append = 1;

        while (User::where('username', $username)->exists()) {
            $username = $username . $append;
            $append++;
        }

        return $username;
    }
}
