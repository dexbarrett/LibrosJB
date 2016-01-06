<?php
namespace LibrosJB;

interface AuthenticateUserListener
{
    public function authorizationFailed();
    public function userHasLoggedIn();
}