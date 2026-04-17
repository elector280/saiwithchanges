<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\LanguageTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    public function languages(){
        $languages = Language::paginate(30);
        $activeLanguages = Language::whereActive(true)->get();

        return view('admin.language.index', compact('languages','activeLanguages'));
    }

    public function languageCreate(){
        return view('admin.language.create');
    }

    public function languageStore(Request $request){
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'language_code' => 'required',
        ]);

        if ($validation->fails()) {
            toast('Please submit your data correctly', 'error');
            return back()->withInput()->withErrors($validation)->with('card-open', 'card-open');
        }

        if(Language::where('language_code',$request->language_code)->first()){
            toast('This code is already used for another language', 'error');
            return back();
        }

        $language = new Language();
        $language->title = $request->title;
        $language->language_code = strtolower($request->language_code);
        $language->addedby_id = Auth::id();
        $language->save();

        cache()->flush();

        $translations = LanguageTranslation::where('lang', 'en')->get();
        foreach($translations as $tran){
            $translation = new LanguageTranslation();
            $translation->lang = $language->language_code ?? '';
            $translation->lang_key = $tran->lang_key;
            $translation->lang_value = null;
            $translation->addedby_id = Auth::id();
            $translation->save();
        }

        cache()->flush();
        toast('Language has been inserted successfully', 'success');
        return redirect()->route('admin.languages');
    }

    public function languageEdit(Language $language){
        return view('admin.language.edit', compact('language'));
    }

    public function languageUpdate(Request $request, Language $language){
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'language_code' => 'required',
        ]);

        // dd($request->all());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation)->with('card-open', 'card-open');
        }

        if(Language::where('language_code', $request->language_code)->where('id', '!=', $language->id)->first()){
            // toast('This code is already used for another language', 'error');
            return back();
        }

        $language->title = $request->title;
        $language->language_code = strtolower($request->language_code);
        $language->active = $request->active ? 1 : 0;
        $language->editedby_id = Auth::id();

        if ($request->hasFile('country_flag')) {

            // delete old profile image
            if ($language->country_flag &&
                Storage::disk('public')->exists('country_flag/'.$language->country_flag)) {
                Storage::disk('public')->delete('country_flag/'.$language->country_flag);
            }

            $file = $request->country_flag;
            $ext = '.' . $file->getClientOriginalExtension();
            $fileName = time() . '_flag_' . rand(100, 999) . $ext;

            Storage::disk('public')->put(
                'country_flag/' . $fileName,
                File::get($file)
            );

            $language->country_flag = $fileName;
        }


        $language->save();

        cache()->flush();

        // toast('Language has been updated successfully', 'success');
        return redirect()->route('admin.languages');
    }

    public function languageDelete(Language $language){
        $language->translations()->delete();
        $language->delete();
        cache()->flush();

        toast('Language has been deleted successfully', 'success');
        return redirect()->route('admin.languages');
    }

    public function languageStatus(Request $request){
        DB::table('languages')->where('id', $request->id)->update([
            'active' => $request->mode == 'true' ? 1 : 0
        ]); 

        return response()->json(['msg' => 'Status Successfully updated ', 'status' => true]);
    }


    // Translations
    public function translations(){
        return view('admin.translation.index');
    }

    public function translationStore(Request $request){

        $validation = Validator::make($request->all(), [
            'lang_key' => 'required|unique:language_translations,lang_key',
        ]);

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation)->with('card-open', 'card-open');
        }

        $lang_key = str_replace(' ', '_', $request->lang_key);

        $languages = Language::whereActive(true)->get();
        foreach($languages as $lang){
            $translation = new LanguageTranslation();
            $translation->lang = $lang->language_code ?? '';
            $translation->lang_key = strtolower($lang_key);
            $translation->lang_value = env('DEFAULT_LANGUAGE') == $lang->language_code ? $request->lang_value : null;
            $translation->addedby_id = Auth::id();
            $translation->save();
        }

        cache()->flush();
        return redirect()->back()->with('success', 'Language key value store successfully');
    }

    public function languageTranslatoins(Language $language){
        $lang_keys = LanguageTranslation::where('lang', 'en')->paginate(500);
        return view('admin.translation.view', compact('lang_keys', 'language'));
    }

    public function languageTranslateValueStore(Request $request){
        $language = Language::findOrFail($request->id);

        foreach ($request->values as $key => $value) {
            $translation = LanguageTranslation::where('lang_key', $key)
                ->where('lang', $language->language_code)
                ->latest()
                ->first();

            if(!$translation){
                $translation = new LanguageTranslation();
                $translation->lang = $language->language_code;
                $translation->lang_key = $key;
            }

            $translation->lang_value = $value;
            $translation->save();
        }

        cache()->flush();
        return redirect()->back()->with('success', 'Translations updated');
    }

    public function languageTranlationSearchAjax(Request $request)
    {
        $q = trim((string) $request->q);
        $language = Language::findOrFail($request->id);

        // ✅ "call us" -> "call%us" (space/ multiple space wildcard)
        $qLike = preg_replace('/\s+/', '%', $q);

        $lang_keys = LanguageTranslation::where('lang', $language->language_code)
            ->when($qLike !== '', function ($query) use ($qLike) {
                $query->where(function ($qq) use ($qLike) {
                    $qq->where('lang_key', 'like', "%{$qLike}%")
                    ->orWhere('lang_value', 'like', "%{$qLike}%");
                });
            })
            ->orderBy('lang_key')
            ->paginate(50);

        $page = view('admin.translation.includes.searchLanguageTranslation', [
            'lang_keys' => $lang_keys,
            'language' => $language
        ])->render();

        return response()->json(['success' => true, 'page' => $page]);
    }

}
