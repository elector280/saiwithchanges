<?php

use App\Models\LanguageTranslation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

function translate($key, $lang = null, $addslashes = false)
{
  if ($lang == null) {
    $lang = App::getLocale();
  }

  $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));

  $translations_en = Cache::rememberForever('translations-en', function () {
    return LanguageTranslation::where('lang', 'en')->pluck('lang_value', 'lang_key')->toArray();
  });

  if (!isset($translations_en[$lang_key])) {
    $translation_def = new LanguageTranslation;
    $translation_def->lang = 'en';
    $translation_def->lang_key = $lang_key;
    $translation_def->lang_value = str_replace(array("\r", "\n", "\r\n"), "", $key);
    $translation_def->save();
    Cache::forget('translations-en');
  }

  // return user session lang
  $translation_locale = Cache::rememberForever("translations-{$lang}", function () use ($lang) {
    return LanguageTranslation::where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
  });


  if (isset($translation_locale[$lang_key])) {
    return $addslashes ? addslashes(trim($translation_locale[$lang_key])) : trim($translation_locale[$lang_key]);
  }



  // return default lang if session lang not found
  $translations_default = Cache::rememberForever('translations-' . env('DEFAULT_LANGUAGE', 'en'), function () {
    return LanguageTranslation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->pluck('lang_value', 'lang_key')->toArray();
  });
  if (isset($translations_default[$lang_key])) {
    return $addslashes ? addslashes(trim($translations_default[$lang_key])) : trim($translations_default[$lang_key]);
  }

  // fallback to en lang
  if (!isset($translations_en[$lang_key])) {
    return trim($key);
  }
  return $addslashes ? addslashes(trim($translations_en[$lang_key])) : trim($translations_en[$lang_key]);
}






