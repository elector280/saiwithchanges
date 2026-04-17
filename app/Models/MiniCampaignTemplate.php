<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class MiniCampaignTemplate extends Model
{
        use HasFactory, HasTranslations;
    protected $guarded = [];

     public $translatable = [
        'title',
        'slug',
        'short_description',
        'paragraph_one',
        'paragraph_two',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'og_title',
        'og_description',

        'canonical_url',
        'donation_box',
    ];

    /**
     * ✅ Cast JSON to array
     */
    protected $casts = [
        'title'              => 'array',
        'slug'              => 'array',
        'short_description' => 'array',
        'paragraph_one'     => 'array',
        'paragraph_two'     => 'array',

        'meta_title'        => 'array',
        'meta_description'  => 'array',
        'meta_keywords'     => 'array',

        'og_title'          => 'array',
        'og_description'    => 'array',

        'donation_box'      => 'array',
        'canonical_url'     => 'array',
        'status'            => 'integer',

        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function getLocalValue($field, $locale = null)
    {
        if (!method_exists($this, 'getTranslations')) {
            return $this->$field ?? null;
        }

        $locale = $locale ?? app()->getLocale();

        $translations = (array) ($this->getTranslations($field) ?? []);
        if (array_key_exists($locale, $translations) && $translations[$locale] != null && $translations[$locale] !== '') {
            return $translations[$locale];
        }

        foreach ($translations as $value) {
            if ($value !== null && $value !== '') {
                return $value;
            }
        }
        return null;
    }


    
    public function getDirectValue($field, $locale)
    {
        if (!method_exists($this, 'getTranslations')) {
            return $this->$field ?? null;
        }

        $translations = (array) ($this->getTranslations($field) ?? []);

        return $translations[$locale] ?? null;
    }

}
