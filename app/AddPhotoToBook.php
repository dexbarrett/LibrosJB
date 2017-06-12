<?php
namespace LibrosJB;

use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddPhotoToBook
{
    protected $book;
    protected $file;
    protected $photoData;

    public function __construct(Book $book, UploadedFile $file)
    {
        $this->book = $book;
        $this->file = $file;
        $this->photoData = [];
    }

    public function save()
    {
        $photo = $this->book->addPhoto($this->makePhoto());
        $photoFile = Image::make($this->file);
        $watermark = Image::make(base_path('resources/librosjb-watermark.png'));

        if ($watermark->width() > $photoFile->width()) {
            $watermark->resize($photoFile->width() - 30, $watermark->height() - 30);
        }
        
        $photoFile
        ->orientate()
        ->resize(500, 700, function($constraint) {
            $constraint->upsize();
        })
        ->insert($watermark, 'center', 30, 30)
        ->save(config('app.photo-path') . '/' . $photo->filename);

        Image::make(config('app.photo-path') . '/' . $photo->filename)
        ->resize(100, 150)
        ->save(config('app.photo-thumbnail-path') . '/' . $photo->thumbnail_filename);

        $this->photoData['thumbnailPath'] = $photo->thumbnail_path;
        $this->photoData['photoID'] = $photo->id;

        return $this;
    }

    protected function makePhoto()
    {
        return new Photo(['filename' => $this->makeFileName()]);
    }

    protected function makeFileName()
    {
        return sha1(time() . str_random(5)) . '.' . $this->file->guessExtension();
    }

    /**
     * Gets the value of photoData.
     *
     * @return mixed
     */
    public function getPhotoData()
    {
        return $this->photoData;
    }
}