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

        $user = User::firstOrNew($this->getUserData());
        $user->setRandomPasswordIfNotPresent();
        $user->save();

        Auth::login($user);

        return $listener->userHasLoggedIn();

    }

    protected function getUserData()
    {
        $userData = Socialite::driver('facebook')->user();

        return [
            'email' => $userData->getEmail(),
            'facebook_id' => $userData->getId()
        ];
    }
}