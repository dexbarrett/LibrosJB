<?php

namespace LibrosJB\Http\Controllers;

use LibrosJB\Http\Requests;
use Illuminate\Http\Request;
use LibrosJB\AuthenticateUser;
use LibrosJB\AuthenticateUserListener;
use LibrosJB\Http\Controllers\Controller;


class SessionController extends Controller implements AuthenticateUserListener
{
    protected $authenticateUser;

    public function __construct(AuthenticateUser $authenticateUser)
    {
        $this->authenticateUser = $authenticateUser;
    }

    public function showAdminLogin()
    {
        return view('admin.login');
    }

    public function authAdminLogin()
    {
        $email = e(request()->input('email'));
        $password = e(request()->input('password'));

        if (auth()->attempt(compact('email', 'password'))) {
            
            auth()->user()->initializeSettings();

            return redirect()
                ->intended(action('DashboardController@index'));
        }

        return redirect()->back()
                ->withInput()
                ->with('message', 'los datos de usuario son incorrectos')
                ->with('message-type', 'warning'); 
    }

    public function showUserLogin()
    {
        return view('login');
    }

    public function authUserLogin()
    {
        return $this->authenticateUser->authorize();
    }

    public function processUserLogin()
    {
        return $this->authenticateUser->login($this);
    }

    public function authorizationFailed()
    {
        return redirect()
                ->action('SessionController@showUserLogin')
                ->with('message', 'Ocurrió un error al iniciar sesión con Facebook')
                ->with('message-type', 'danger');
    }

    public function userHasLoggedIn()
    {
        return redirect()->intended('/');
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
        }

        return redirect()->to('/');   
    }
    
}
