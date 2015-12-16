<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'book_photos';
    protected $fillable = ['filename'];

    public function setFilenameAttribute($filename)
    {
        $this->attributes['filename'] = $filename;
        $this->thumbnail_filename = 'th-' . $filename;
    }

    public function getThumbnailPathAttribute()
    {
        return '/' . config('app.photo-thumbnail-path') . '/' . 
                $this->attributes['thumbnail_filename'];
    }

    public function getPhotoPathAttribute()
    {
        return '/' . config('app.photo-path') . '/' . 
                $this->attributes['filename'];
    }

    public function book()
    {
        return $this->belongsTo('LibrosJB\Book');
    }
}
