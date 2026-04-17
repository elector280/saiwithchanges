<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    protected $fillable = [
        'folder_id','disk','path','original_name','mime_type','size','width','height'
    ];

    protected $appends = ['url'];

    public function isImage()
    {
        return str_starts_with((string)$this->mime_type, 'image/');
    }
}
