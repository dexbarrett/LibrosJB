<?php
namespace LibrosJB;

use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddPhotoToBook
{
    protected $book;
    protected $file;

    public function __construct(Book $book, UploadedFile $file)
    {
        $this->book = $book;
        $this->file = $file;
    }

    public function save()
    {
        $photo = $this->book->addPhoto($this->makePhoto());

        Image::make($this->file)
        ->resize(500, 700, function($constraint) {
            $constraint->upsize();
        })
        ->save(config('app.photo-path') . '/' . $photo->filename);

        Image::make($this->file)
        ->resize(100, 150)
        ->save(config('app.photo-thumbnail-path') . '/' . $photo->thumbnail_filename);
    }

    protected function makePhoto()
    {
        return new Photo(['filename' => $this->makeFileName()]);
    }

    protected function makeFileName()
    {
        return sha1(time() . str_random(5)) . '.' . $this->file->guessExtension();
    }
}