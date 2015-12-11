<?php

namespace LibrosJB\Http\Controllers;

use LibrosJB\Book;
use LibrosJB\Http\Requests;
use Illuminate\Http\Request;
use LibrosJB\AddPhotoToBook;
use LibrosJB\Http\Controllers\Controller;

class BookPhotosController extends Controller
{
    public function create($bookID)
    {
        return view('admin.book-photos')
            ->with(compact('bookID'));
    }

    public function store($bookID)
    {
        $book = Book::findOrFail($bookID);
        $photo = request()->file('photo');

        (new AddPhotoToBook($book, $photo))->save();
    }
}
