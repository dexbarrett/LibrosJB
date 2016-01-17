<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['book_id', 'from_user', 'to_user'];

    // Relationships
    public function messages()
    {
        return $this->hasMany('LibrosJB\Message');
    }

    public function book()
    {
        return $this->belongsTo('LibrosJB\Book');
    }
    
}
