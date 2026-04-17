<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = [
        'menu_id',
        'parent_id',
        'label',
        'url',
        'route_name',
        'route_params',
        'icon',
        'sort_order',
        'is_active',
        'permission',
        'role',
    ];

    protected $casts = [
        'route_params' => 'array',
        'is_active'    => 'boolean',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }
}
