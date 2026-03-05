<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ChatHistory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'chat_histories';

    protected $fillable = [
        'session_id',
        'question',
        'answer'
    ];
} 