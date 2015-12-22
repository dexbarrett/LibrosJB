<?php

namespace LibrosJB\Http\Controllers;

use LibrosJB\Book;
use LibrosJB\Photo;
use LibrosJB\Http\Requests;
use Illuminate\Http\Request;
use LibrosJB\AddPhotoToBook;
use LibrosJB\Http\Controllers\Controller;

class BookPhotosController extends Controller
{
    public function create($bookID)
    {
        $book = Book::findOrFail($bookID);

        return view('admin.book-photos')
            ->with(compact('book'));
    }

    public function store($bookID)
    {
        $book = Book::findOrFail($bookID);
        $photo = request()->file('photo');

        (new AddPhotoToBook($book, $photo))->save();
    }

    public function delete()
    {
        $photo = Photo::findOrFail(e(request()->input('photoID')));
        $photo->delete();
    }
}
