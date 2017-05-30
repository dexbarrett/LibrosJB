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
    public function create($uuid)
    {
        $book = Book::findByUuid($uuid);
        $this->authorize('manage-photos', $book);

        return view('admin.book-photos')
            ->with(compact('book'));
    }

    public function store($uuid)
    {
        $book = Book::findByUuid($uuid);
        $this->authorize('manage-photos', $book);

        $photo = request()->file('photo');

        $photoMaker = (new AddPhotoToBook($book, $photo))->save();

        return response($photoMaker->getPhotoData());
    }

    public function delete()
    {
        $photo = Photo::findOrFail(e(request()->input('photoID')));
        $this->authorize('manage-photos', $photo->book);

        $photo->delete();
    }
}
