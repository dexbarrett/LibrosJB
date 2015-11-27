<?php

namespace LibrosJB\Http\Controllers;

use LibrosJB\Book;
use LibrosJB\Http\Requests;
use Illuminate\Http\Request;
use LibrosJB\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $userBooks = Book::forUser($this->user->id)->get();
        return view('admin.dashboard')
            ->with(compact('userBooks'));
    }
}
