<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    public function creator() 
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
