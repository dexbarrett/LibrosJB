<?php

namespace LibrosJB\Http\Controllers;

use Illuminate\Http\Request;

use LibrosJB\Http\Requests;
use LibrosJB\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function updateEmailNotifications()
    {
        $receiveEmailNotifications = e(request()->input('emailNotifications'));
        auth()->user()->settings->receiveEmailNotifications($receiveEmailNotifications);
    }
}
