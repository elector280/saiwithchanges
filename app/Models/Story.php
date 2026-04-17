<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Story extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'addedby_id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }



  
    public $translatable = ['title', 'short_description', 'description', 'seo_title', 'tags', 'meta_description', 'slug', 'footer_title', 'footer_subtitle', 'reportpath'];

    protected $casts = [
        'title' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'seo_title' => 'array',
        'tags' => 'array',
        'meta_description' => 'array',
        'slug' => 'array',
        'footer_title' => 'array',
        'footer_subtitle' => 'array',
        'reportpath' => 'array',
        'published_at' => 'datetime',
    ];




    public function getLocaleValue(string $field, string $code = null): ?string
    {
        $code = $code ?? app()->getLocale();
        $translations = $this->getTranslations($field);
        return $translations[$code]
            ?? collect($translations)->first(fn($v) => $v !== null && $v !== '')
            ?? null;
    }

    public function getTitle($locale = null) { return $this->getLocaleValue('title', $locale); }
    public function getDescription($locale = null) { return $this->getLocaleValue('description', $locale); }
    public function localeTitle($code) { return $this->getLocaleValue('title', $code); }
    public function localeTitleShow() { return $this->getLocaleValue('title'); }
    public function localeExcerpt($code) { return $this->getLocaleValue('short_description', $code); }
    public function localeExcerptShow() { return $this->getLocaleValue('short_description'); }
    public function localeDescription($code) { return $this->getLocaleValue('description', $code); }
    public function localeDescriptionShow() { return $this->getLocaleValue('description'); }
    public function localSeoTitle($code) { return $this->getLocaleValue('seo_title', $code); }
    public function localSeoTitleShow() { return $this->getLocaleValue('seo_title'); }
    public function localSlugTitle($code) { return $this->getLocaleValue('slug', $code); }
    public function localSlugShow() { return $this->getLocaleValue('slug'); }
    public function localMetaDescription($code) { return $this->getLocaleValue('meta_description', $code); }
    public function localMetaDescriptionShow() { return $this->getLocaleValue('meta_description'); }
    public function localTag($code) { return $this->getLocaleValue('tags', $code); }
    public function localTagShow() { return $this->getLocaleValue('tags'); }


    public function getDirectValue($field, $locale)
    {
        if (!method_exists($this, 'getTranslations')) {
            return $this->$field ?? null;
        }

        $translations = (array) ($this->getTranslations($field) ?? []);

        return $translations[$locale] ?? null;
    }


}
