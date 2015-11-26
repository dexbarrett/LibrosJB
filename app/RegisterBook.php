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

    public function __construct(Book $book, Author $author, Publisher $publisher,
     BookFormValidator $validator, ImageManager $imageManipulator)
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
        $book->user_id = $data['user_id'];
        $book->title = $data['title'];
        $book->language_id = $data['language'];
        $book->edition_year = $data['edition_year'];
        $book->pages = $data['pages'];
        $book->extract = $data['extract'];
        $book->book_condition_id = $data['condition'];
        $book->sale_price = $data['price'];
        $book->comments = $data['comments'];
        $book->for_sale = array_get($data, 'for-sale', 0); // Laravel array helper

        $this->bookCoverFileName = $this->generateCoverFileName($data['cover']);
        $this->bookCoverFile = $data['cover'];
        $book->cover_picture = $this->bookCoverFileName;

        $book->author_id = $this->retrieveAuthorId($data['author']);
        $book->publisher_id = $this->retrievePublisherId($data['publisher']);

        $book->save();
    }


    protected function createBookCover()
    {
        $this->imageManipulator->make($this->bookCoverFile)
            ->resize(200, 325)
            ->save(config('app.book-cover-thumbnail-path') . '/' . $this->bookCoverFileName);
    }

    protected function generateCoverFileName(UploadedFile $imageFile)
    {
        return time() . "." . $imageFile->guessExtension();
    }

    protected function retrieveAuthorId($authorField)
    {
        $id = (int) $authorField;

        if ($id === 0) {
            return Author::firstOrCreate(['name' => $authorField])->id;
        }

        return $id;  
    }

    protected function retrievePublisherId($publisherField)
    {
        $id = (int) $publisherField;

        if ($id === 0) {
            return Publisher::firstOrCreate(['name' => $publisherField])->id;
        }

        return $id;
    }
   
}