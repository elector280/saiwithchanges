<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscribeEmail extends Model
{
    protected $table = 'subscribe_emails'; // ✅ table name

    protected $guarded = [];

    protected $casts = [
        'is_subscribed' => 'boolean',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];
}
