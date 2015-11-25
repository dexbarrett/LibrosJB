<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;

class BookLanguage extends Model
{
    protected $table = 'languages';
    protected $fillable = ['name'];
}
