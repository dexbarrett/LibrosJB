<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message', 'from_user', 'to_user'];

    public function setMessageAttribute($message)
    {
        $this->attributes['message'] = strip_tags(trim($message));
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_user');
    }
}
