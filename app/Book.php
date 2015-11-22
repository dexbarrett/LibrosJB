<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function scopeForSale($query)
    {
        return $query->where('for_sale', 1)->orderBy('title');
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
}
