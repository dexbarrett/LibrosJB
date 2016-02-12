<?php
namespace LibrosJB;

use Auth;
use Socialite;

class AuthenticateUser
{

    public function authorize()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function login(AuthenticateUserListener $listener)
    {
        if (! request()->has('code')) {
            return $listener->authorizationFailed();
        }

        $userData = $this->getUserData();

        $user = User::firstOrNew(['facebook_id' => $userData->getId()]);
        $user->email = $userData->getEmail();
        $user->name = $userData->getName();
        $user->setRandomPasswordIfNotPresent();
        $user->save();

        Auth::login($user);

        return $listener->userHasLoggedIn();

    }

    protected function getUserData()
    {
        return Socialite::driver('facebook')->user();
    }
}