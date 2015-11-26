<?php

namespace LibrosJB\Http\Controllers;

use Illuminate\Http\Request;

use LibrosJB\Http\Requests;
use LibrosJB\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function showAdminLogin()
    {
        return view('admin.login');
    }

    public function authAdminLogin()
    {
        $email = request()->input('email');
        $password = request()->input('password');

        if (auth()->attempt(compact('email', 'password'))) {
            return redirect()->intended('/');
        }

        return redirect()->back()
                ->withInput()
                ->with('message', 'los datos de usuario son incorrectos')
                ->with('message-type', 'warning'); 
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
        }

        return redirect()->to('/');   
    }
    
}
