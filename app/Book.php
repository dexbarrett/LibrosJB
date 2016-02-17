<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class Book extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => ['author.name', 'title'],
        'save_to'    => 'url_slug'
    ];

    protected $casts = [
        'for_sale' => 'boolean'
    ];

    public function addPhoto(Photo $photo)
    {
        return $this->photos()->save($photo);
    }

    public function changeStatus($status)
    {
        $this->for_sale = $status;
        $this->save();
    }

    public function hasComments()
    {
        return strlen(trim($this->comments)) > 0;
    }

    public function isSoldBy($userID)
    {
        return (bool) ($this->user_id === $userID);
    }

    public function isForSale()
    {
        return $this->for_sale;
    }

    /* Query Scopes */

    public function scopeForSale($query)
    {
        return $query->where('for_sale', 1);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }

    /* Accessors and Mutators */

    public function setSalePriceAttribute($price)
    {
        $this->attributes['sale_price'] = (int)$price * 100;
    }

    public function getSalePriceAttribute($price)
    {
        return ($price / 100);
    }

    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = strtolower($title);
    }

    public function setForSaleAttribute($forsale)
    {

        if ($forsale === 'true') {
            $forsale = 1;
        } elseif ($forsale === 'false') {
            $forsale = 0;
        }

        $this->attributes['for_sale'] = $forsale;
    }

    public function getCoverThumbnailPathAttribute()
    {
        return config('app.book-cover-thumbnail-path') . '/' .
                $this->attributes['cover_picture'];   
    }

    /* Relationships */

    public function user()
    {
        return $this->belongsTo('LibrosJB\User');
    }

    public function author()
    {
        return $this->belongsTo('LibrosJB\Author');
    }

    public function publisher()
    {
        return $this->belongsTo('LibrosJB\Publisher');
    }

    public function language()
    {
        return $this->belongsTo('LibrosJB\BookLanguage');
    }

    public function condition()
    {
        return $this->belongsTo('LibrosJB\BookCondition', 'book_condition_id');
    }

    public function photos()
    {
        return $this->hasMany('LibrosJB\Photo');
    }

    public function format()
    {
        return $this->belongsTo(BookFormat::class);
    }
}
