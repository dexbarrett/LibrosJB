<?php
namespace LibrosJB;

use Intervention\Image\ImageManager;
use LibrosJB\Services\Validation\BookFormValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisterBook
{
    protected $book;
    protected $validator;
    protected $imageManipulator;
    protected $bookCoverFileName;
    protected $bookCoverFile;

    public function __construct(Book $book, BookFormValidator $validator, ImageManager $imageManipulator)
    {
        $this->book = $book;
        $this->validator = $validator;
        $this->imageManipulator = $imageManipulator;
    }

    public function create(array $input)
    {
        if ($this->dataIsNotValid($input)) {
            return false;
        }

        $this->storeBook($input);
        $this->createBookCover($input['cover']);

        return true;
    }

    public function errors()
    {
        return $this->validator->errors();
    }

    protected function dataIsNotValid(array $data)
    {
        return ! $this->validator->validate($data);
    }

    protected function storeBook(array $data)
    {
        $book = new Book;

        $this->bookCoverFileName = $this->generateCoverFileName($data['cover']);
        $this->bookCoverFile = $data['cover'];

        $book->user_id = 1;
        $book->title = $data['title'];
        $book->author = $data['author'];
        $book->publisher = $data['publisher'];
        $book->edition = $data['edition'];
        $book->year = $data['edition_year'];
        $book->pages = $data['pages'];
        $book->extract = $data['extract'];
        $book->condition = $data['condition'];
        $book->sale_price = $data['price'];
        $book->for_sale = array_get($data, 'for-sale', 0); // Laravel array helper
        $book->cover_picture = $this->bookCoverFileName;
        $book->comments = $data['comments'];

        $book->save();
    }


    protected function createBookCover()
    {
        $this->imageManipulator->make($this->bookCoverFile)
            ->resize(200, 325)
            ->save('images/' . $this->bookCoverFileName);
    }

    protected function generateCoverFileName(UploadedFile $imageFile)
    {
        return time() . "." . $imageFile->guessExtension();
    }
   
}