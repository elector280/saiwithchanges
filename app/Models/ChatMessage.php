<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $guarded = [];

    public function thread(){
        return $this->belongsTo(ChatThread::class, 'thread_id');
    }
}
