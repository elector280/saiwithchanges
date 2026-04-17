<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    

     public $translatable = ['title', 'subtitle', 'btn_text'];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'btn_text' => 'array',
        'status' => 'boolean',
    ];



        
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


    function localeBtnText($code)
    {
        $a = json_decode(json_encode($this->getTranslations('btn_text')), true);
        if($a)
        {
            if(array_key_exists($code, $a))
            {
                return $a[$code];
            }
            return null;
        }
    }

    function localeBtnTextShow()
    {
        $a = json_decode(json_encode($this->getTranslations('btn_text')), true);
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
    

    function localeSubTitle($code)
    {
        $a = json_decode(json_encode($this->getTranslations('btn_text')), true);
        if($a)
        {
            if(array_key_exists($code, $a))
            {
                return $a[$code];
            }
            return null;
        }
    }

    function localeSubTitleShow()
    {
        $a = json_decode(json_encode($this->getTranslations('btn_text')), true);
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
