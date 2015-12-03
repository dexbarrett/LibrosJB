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
        parent::__construct();
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
        ->select(['books.cover_picture', 'books.title', 'books.url_slug'])
        ->orderBy(mapFieldToDBColumn($sortBy), $direction)
        ->orderBy(mapFieldToDBColumn('titulo'), $direction)
        ->paginate(config('app.books-on-sale-per-page'));

        return view('home')->with(compact('books'))
            ->with('sortField', $sortBy)
            ->with('direction', $direction);       
    }

    public function show($bookSlug)
    {
        $book = Book::whereSlug($bookSlug)
            ->with('author')
            ->with('publisher')
            ->with('language')
            ->with('condition')
            ->firstOrFail();
        
        return view('books.book-detail')->with(compact('book'));
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $author = $book->author()->lists('name', 'id');
        $publisher = $book->publisher()->lists('name', 'id');

        return view('admin.edit-book')->with(compact('book', 'author', 'publisher'));
    }

    public function update($id)
    {
        if (! $this->registerBook->update($id, request()->all())) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($this->registerBook->errors());
        }

        return redirect()
            ->action('BookController@edit', ['id' => $id])
            ->with('message', 'Libro actualizado correctamente');
    }

    public function store()
    {
        $data = collect(request()->all())
        ->put('user_id', $this->user->id);

        if ($this->bookDataHasErrors($data->toArray())) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($this->registerBook->errors());
        }

        return redirect()
            ->back()
            ->with('message', 'Libro registrado correctamente');
    }

    public function changeStatus($id, $status)
    {
        $book = Book::findOrFail($id);

        $book->for_sale = $status;
        
        $book->save(); 
    }

    protected function bookDataHasErrors($data)
    {
       return ! $this->registerBook->create($data);
    }
}
