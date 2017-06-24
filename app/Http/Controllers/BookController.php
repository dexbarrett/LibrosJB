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
        ->select(['books.cover_picture', 'books.title', 'books.url_slug', 'books.sale_price'])
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
            ->with('photos')
            ->with('format')
            ->firstOrFail();

        if ( $book->notForSale() && (auth()->guest() || !$book->isSoldBy(auth()->user()->id)) ) {
            abort(404);
        }
        
        return view('books.book-detail')->with(compact('book'));
    }

    public function edit($uuid)
    {
        $book = Book::findByUuid($uuid);
        $this->authorize('manage-book', $book);

        $author = $book->author()->lists('name', 'id');
        $publisher = $book->publisher()->lists('name', 'id');

        return view('admin.edit-book')->with(compact('book', 'author', 'publisher'));
    }

    public function update($uuid)
    {
        $book = Book::findByUuid($uuid);

        $this->authorize('manage-book', $book);

        if (! $this->registerBook->update($book, request()->all())) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($this->registerBook->errors());
        }

        return redirect()
            ->action('BookController@edit', ['uuid' => $uuid])
            ->with('message', 'Información actualizada correctamente');
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

    public function changeStatus()
    {
        $id = e(request()->input('id'));
        $status = e(request()->input('status'));
        $book = Book::findByUuid($id);

        $this->authorize('manage-book', $book);

        $book->changeStatus($status);
    }

    protected function bookDataHasErrors($data)
    {
       return ! $this->registerBook->create($data);
    }
}
