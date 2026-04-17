<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatThread extends Model
{
    protected $guarded = [];

    public function messages(){
        return $this->hasMany(ChatMessage::class, 'thread_id');
    }

    public function latestMessage(){
        return $this->hasOne(ChatMessage::class, 'thread_id')->latestOfMany();
    }
}
