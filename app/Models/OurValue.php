<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class OurValue extends Model
{
    use HasFactory, HasTranslations;

     public $translatable = [
            'title',
            'description',
        ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    
    // Get value for current or given locale with fallback
    public function getLocalValue($field, $locale = null)
    {
        // if model not translatable or method missing
        if (!method_exists($this, 'getTranslations')) {
            return $this->$field ?? null;
        }

        $locale = $locale ?? app()->getLocale();

        $translations = (array) ($this->getTranslations($field) ?? []);

        // exact locale value exists and not empty
        if (array_key_exists($locale, $translations) && $translations[$locale] != null && $translations[$locale] !== '') {
            return $translations[$locale];
        }

        // fallback → first non-empty available translation
        foreach ($translations as $value) {
            if ($value !== null && $value !== '') {
                return $value;
            }
        }

        // nothing found
        return null;
    }


    // Get value for specific locale ONLY (no fallback)
    public function getDirectValue($field, $locale)
    {
        if (!method_exists($this, 'getTranslations')) {
            return $this->$field ?? null;
        }

        $translations = (array) ($this->getTranslations($field) ?? []);

        return $translations[$locale] ?? null;
    }
}
