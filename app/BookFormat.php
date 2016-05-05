<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;

class BookFormat extends Model
{
    protected $table = 'book_format';
    protected $fillable = ['name'];
}
