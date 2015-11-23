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

    public function index($sortBy = 'titulo', $direction = 'asc')
    {

        $books = Book::join('authors', function($join){
            $join->on('books.author_id', '=', 'authors.id')
            ->where('books.for_sale', '=', true);
        })
        ->select(['books.cover_picture', 'books.title'])
        ->orderBy(mapFieldToDBColumn($sortBy), $direction)
        ->orderBy(mapFieldToDBColumn('titulo'), $direction)
        ->paginate(config('app.books-on-sale-per-page'));

        return view('home')->with(compact('books'))
            ->with('sortField', $sortBy)
            ->with('direction', $direction);       
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
