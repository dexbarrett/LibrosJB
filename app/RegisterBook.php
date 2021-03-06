<?php
namespace LibrosJB;

use Intervention\Image\ImageManager;
use LibrosJB\Services\Validation\BookFormValidator;
use Ramsey\Uuid\Uuid;
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
        if ($this->dataIsNotValidToCreate($input)) {
            return false;
        }

        $this->storeBook($input);

        return true;
    }

    public function update($id, array $input)
    {
        if ($this->dataIsNotValidToUpdate($input)) {
            return false;
        }

        $this->updateBook($id, $input);

        return true;
    }

    public function errors()
    {
        return $this->validator->errors();
    }

    protected function dataIsNotValidToCreate(array $data)
    {
        return ! $this->validator->validate($data);
    }

    protected function dataIsNotValidToUpdate(array $data)
    {
        return ! $this->validator->setRules('update')->validate($data);
    }

    protected function storeBook(array $data)
    {
        $book = new Book;
        $book->user_id = $data['user_id'];
        $book->title = $data['title'];
        $book->format_id = $data['format'];
        $book->language_id = $data['language'];
        $book->edition_year = $data['edition_year'];
        $book->pages = $data['pages'];
        $book->extract = $data['extract'];
        $book->book_condition_id = $data['condition'];
        $book->sale_price = $data['price'];
        $book->comments = $data['comments'];
        $book->for_sale = array_get($data, 'for-sale', 0); // Laravel array helper
        $book->uuid = Uuid::uuid4()->toString();

        $this->bookCoverFileName = $this->generateCoverFileName($data['cover']);
        $this->bookCoverFile = $data['cover'];
        $book->cover_picture = $this->bookCoverFileName;

        $book->author_id = $this->retrieveAuthorId($data['author']);
        $book->publisher_id = $this->retrievePublisherId($data['publisher']);

        $book->save();

        $this->createBookCover();
    }

    protected function updateBook($book, array $data)
    {
        
        $book->title = $data['title'];
        $book->format_id = $data['format'];
        $book->language_id = $data['language'];
        $book->edition_year = $data['edition_year'];
        $book->pages = $data['pages'];
        $book->extract = $data['extract'];
        $book->book_condition_id = $data['condition'];
        $book->sale_price = $data['price'];
        $book->comments = $data['comments'];
        $book->for_sale = array_get($data, 'for-sale', 0); // Laravel array helper

        $book->author_id = $this->retrieveAuthorId($data['author']);
        $book->publisher_id = $this->retrievePublisherId($data['publisher']);

        if (isset($data['cover'])) {
            \File::delete(sprintf('%s/%s', public_path(), $book->cover_thumbnail_path));

            $this->bookCoverFileName = $this->generateCoverFileName($data['cover']);
            $this->bookCoverFile = $data['cover'];
            $book->cover_picture = $this->bookCoverFileName;

            $this->createBookCover();
        }

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
        return sha1(time() . str_random(5)) . '.' . $imageFile->guessExtension();
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