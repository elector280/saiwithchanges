<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class WebsiteSetting extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    public $translatable = [
        'title',
        'subtitle',
        'meta_keyword',
        'description',
        'about_us_title_home',
        'about_us_content_home',
        'article_news_content',
        'review_title',
        'review_content',
        'review_sub_title',
        'our_numbers_content',
        'help_people_need_content',
        'start_volunteering_content',
        'become_sponsor_content',
        'help_more_content',
        'download_annual_report_content',
        'about_us_title',
        'our_mission',
        'donate_orphans_content',
        'urgent_help_title',
        'urgent_help_description',
        'annual_report_content',
        'contact_us_title',
        'contact_us_content',
        'donor_advides_title',
        'donor_advides_subtitle',
        'donor_advides_content',
        'donor_cripto_title_1',
        'donor_cripto_content_1',
        'donor_cripto_title_2',
        'donor_cripto_content_2',
        'how_to_donate_cripto',
        'donate_title',
        'donate_subtitle',
        'donate_description',
        'global_donorbox_code',
        'emp_match_section_1',
        'emp_match_section_2',
        'emp_match_section_3',
        'emp_match_section_4',
        'emp_match_section_5',
        'donate_to_feeding_dream',
        'donate_to_orphan_program',
        ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'meta_keyword' => 'array',
        'description' => 'array',
        'about_us_title_home' => 'array',
        'about_us_content_home' => 'array',
        'article_news_content' => 'array',
        'review_title' => 'array',
        'review_content' => 'array',
        'review_sub_title' => 'array',
        'our_numbers_content' => 'array',
        'help_people_need_content' => 'array',
        'start_volunteering_content' => 'array',
        'become_sponsor_content' => 'array',
        'help_more_content' => 'array',
        'download_annual_report_content' => 'array',
        'about_us_title' => 'array',
        'our_mission' => 'array',
        'donate_orphans_content' => 'array',
        'urgent_help_title' => 'array',
        'urgent_help_description' => 'array',
        'annual_report_content' => 'array',
        'contact_us_title' => 'array',
        'contact_us_content' => 'array',
        'donor_advides_title' => 'array',
        'donor_advides_subtitle' => 'array',
        'donor_advides_content' => 'array',
        'donor_cripto_title_1' => 'array',
        'donor_cripto_content_1' => 'array',
        'donor_cripto_title_2' => 'array',
        'donor_cripto_content_2' => 'array',
        'how_to_donate_cripto' => 'array',
        'donate_title' => 'array',
        'donate_subtitle' => 'array',
        'donate_description' => 'array',
        'global_donorbox_code' => 'array',
        'emp_match_section_1' => 'array',
        'emp_match_section_2' => 'array',
        'emp_match_section_3' => 'array',
        'emp_match_section_4' => 'array',
        'emp_match_section_5' => 'array',
        'donate_to_feeding_dream' => 'array',
        'donate_to_orphan_program' => 'array',
    ];


    // ✅ Generic function — any field translate get
    public function getLocalValue($field, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $translations = $this->getTranslations($field);

        if (isset($translations[$locale]) && $translations[$locale] !== null) {
            return $translations[$locale];
        }

        foreach ($translations as $value) {
            if ($value !== null) {
                return $value;
            }
        }

        return null;
    }

    // ✅ Specific locale value (no fallback)
    public function getDirectValue($field, $locale)
    {
        $translations = $this->getTranslations($field);
        return $translations[$locale] ?? null;
    }


    function localTitleShow()
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


    

    function localSubTitleShow()
    {
        $a = json_decode(json_encode($this->getTranslations('subtitle')), true);
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

}
 