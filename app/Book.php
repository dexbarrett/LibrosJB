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

    public function getTitleAttribute($title)
    {
        return ucwords($title);
    }

    public function setForSaleAttribute($forsale)
    {
        $this->attributes['for_sale'] = (($forsale === 'true') ? 1 : 0);
    }

    public function getCoverThumbnailPathAttribute()
    {
        return '/' . config('app.book-cover-thumbnail-path') . '/' .
                $this->attributes['cover_picture'];   
    }

    /* Relationships */

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
}
