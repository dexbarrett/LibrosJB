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

    public function scopeForSale($query)
    {
        return $query->where('for_sale', 1);
    }

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

    public function author()
    {
        return $this->belongsTo('LibrosJB\Author');
    }

    public function publisher()
    {
        return $this->belongsTo('LibrosJB\Publisher');
    }
}
