<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Campaign extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];



    public function user()
    {
        return $this->belongsTo(User::class, 'addedby_id');
    }

    public function galleryImages()
    {
        return $this->hasMany(CampaignGalleryImage::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class, 'campaign_id', 'id');
    }

    public function slogans()
    {
        return $this->hasMany(CampaignSlogan::class, 'campaign_id');
    }

    public $translatable = [
            'title',
            'sub_title',
            'summary',
            'standard_webpage_content',
            'problem',
            'solution',
            'impact',
            'google_description',
            'short_description',
            'donorbox_code',
            'video',
            'seo_title',
            'seo_description',
            'meta_keyword',
            'slug',
            'footer_title',
            'footer_subtitle',
            'path',
        ];

    protected $casts = [
        'title' => 'array',
        'sub_title' => 'array',
        'summary' => 'array',
        'standard_webpage_content' => 'array',
        'problem' => 'array',
        'solution' => 'array',
        'impact' => 'array',
        'google_description' => 'array',
        'short_description' => 'array',
        'donorbox_code' => 'array',
        'video' => 'array',
        'seo_title' => 'array',
        'seo_description' => 'array',
        'meta_keyword' => 'array',
        'slug' => 'array',
        'footer_title' => 'array',
        'footer_subtitle' => 'array',
        'path' => 'array',
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
 