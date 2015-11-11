<?php

namespace LibrosJB\Http\Controllers;

use LibrosJB\Book;
use LibrosJB\RegisterBook;
use LibrosJB\Http\Requests;
use Illuminate\Http\Request;
use LibrosJB\Http\Controllers\Controller;
use LibrosJB\Services\Validation\BookFormValidator;

class BookController extends Controller
{
    protected $registerBook;

    public function __construct(RegisterBook $registerBook)
    {
        $this->registerBook = $registerBook;
    }

    public function create()
    {
        return view('admin.create-book');
    }

    public function index()
    {
        $books = Book::forSale()->select(['title', 'cover_picture'])->get();
        return view('home')->with(compact('books'));       
    }

    public function store()
    {

        if ($this->bookDataHasErrors()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($this->registerBook->errors());
        }

        return redirect()
            ->back()
            ->with('flash-message', 'Libro registrado correctamente');
    }

    protected function bookDataHasErrors()
    {
       return ! $this->registerBook->create(request()->all());
    }
}
