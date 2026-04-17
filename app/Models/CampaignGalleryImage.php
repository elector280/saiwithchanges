<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use voku\helper\UTF8;
use voku\helper\ASCII;

class CampaignGalleryImage extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'campaign_gallery_images';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];

    public $translatable = ['title', 'description', 'alt_text', 'caption', 'tags']; // ✅ make these translatable

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // CampaignGalleryImage.php
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'alt_text' => 'array',
        'caption' => 'array',
        'tags' => 'array',
    ];


public static function booted()
{
    static::saving(function ($item) {
        if (empty($item->slug)) {
            // title থাকলে title থেকে slug, না থাকলে image filename থেকে slug
            $base = $item->title['en'] ?? $item->title ?? pathinfo($item->image, PATHINFO_FILENAME);
            $item->slug = Str::slug($base);
        }
    });
}


    function localeTitle($code)
    {
        $a = json_decode(json_encode($this->getTranslations('title')), true);
        if($a)
        {
            if(array_key_exists($code, $a))
            {
                return $a[$code];
            }
            return null;

        }
    }

 

    function localeTitleShow()
    {
        $a = json_decode(json_encode($this->getTranslations('title')), true);
        $code = app()->getLocale();

        if ($a && $code !== null && array_key_exists($code, $a) && $a[$code] !== null) {
            return $a[$code];
        } else {
            foreach ($a as $k => $item) {
                if ($item !== null) {
                    return $item;
                }
            }
        }
    }

    
    function localeDescription($code)
    {
        $a = json_decode(json_encode($this->getTranslations('description')), true);
        if($a)
        {
            if(array_key_exists($code, $a))
            {
                return $a[$code];
            }
            return null;

        }
    }

    function localeDescriptionShow()
    {
        $a = json_decode(json_encode($this->getTranslations('description')), true);
        $code = app()->getLocale();

        // dd($a, $code , array_key_exists($code, $a), $a[$code]);
        if ($a && $code !== null && array_key_exists($code, $a) && $a[$code] !== "<p><br></p>" ) {
            return $a[$code];
        } else {

            foreach ($a as $k => $item) {

                if ($item !== null) {
                    return $item;
                }
            }
        }
    }



    // Get localized title by code
    public function getTitle($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->getTranslation('title', $locale, true);
    }

    // Get localized description by code
    public function getDescription($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->getTranslation('description', $locale, true);
    }


    // Get localized slug by code
    public function getSlug($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->getTranslation('slug', $locale, true);
    }





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
