<?php

namespace LibrosJB;

use Illuminate\Database\Eloquent\Model;

class ConversationInfo extends Model
{
    protected $table = 'conversation_info';

    protected $fillable = ['conversation_id', 'user_id'];

}
