<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use App\Models\Campaign;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WebsiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function google_analytics()
    {
        return view('admin.seo.google_analytics');
    }
    public function google_console()
    {

        return view('admin.seo.google_console');
    }

    public function sitemapForm()
    {
        return view('admin.seo.sitemap_form');
    }
    public function tag_manager_form()
    {

        return view('admin.seo.tag_manager_form');
    }

    public function sitemap(WebsiteSetting $websiteSetting)
    {
        $setting = WebsiteSetting::first();
        return view('admin.website.sitemap', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WebsiteSetting $websiteSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebsiteSetting $websiteSetting)
    {
        $setting = WebsiteSetting::first();
        return view('admin.website.setting', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebsiteSetting $setting)
    {
        // dd($request->all());
        // ---------- TEXT UPDATE (example) ----------
        $setting->title = $request->title;
        $setting->email = $request->email;
        $setting->subtitle = $request->subtitle;
        $setting->description = $request->description;
        $setting->meta_keyword = $request->meta_keyword;

        $setting->fb_url = $request->fb_url;
        $setting->youtube_url = $request->youtube_url;
        $setting->twitter_url = $request->twitter_url;
        $setting->instragram_url = $request->instragram_url;

        $setting->google_analytics_code = $request->google_analytics_code;
        $setting->whatsapp_number = $request->whatsapp_number;
        $setting->telephone = $request->telephone;
        $setting->address = $request->address;

        $setting->google_map = $request->google_map;
        $setting->office_usa = $request->office_usa;
        $setting->office_venezuela = $request->office_venezuela;

        $setting->about_us_title = $request->about_us_title;
        $setting->our_mission = $request->our_mission;
        $setting->donate_orphans_content = $request->donate_orphans_content;

        $setting->urgent_help_title = $request->urgent_help_title;
        $setting->urgent_help_description = $request->urgent_help_description;

        $setting->donate_to_feeding_dream = $request->donate_to_feeding_dream;
        $setting->donate_to_orphan_program = $request->donate_to_orphan_program;

        $setting->annual_report_content = $request->annual_report_content;
        $setting->anual_report_button = $request->anual_report_button;
        $setting->help_people_need_content = $request->help_people_need_content;
        $setting->help_people_need_btn = $request->help_people_need_btn;


        $setting->about_us_title_home = $request->about_us_title_home;
        $setting->about_us_content_home = $request->about_us_content_home;
        $setting->about_us_btn_home = $request->about_us_btn_home;
        $setting->start_volunteering_content = $request->start_volunteering_content;
        $setting->become_sponsor_content = $request->become_sponsor_content;
        $setting->download_annual_report_content = $request->download_annual_report_content;
        $setting->contact_us_button_volun = $request->contact_us_button_volun;
        $setting->contact_us_title = $request->contact_us_title;
        $setting->contact_us_content = $request->contact_us_content;

        $setting->donor_advides_title = $request->donor_advides_title;
        $setting->donor_advides_subtitle = $request->donor_advides_subtitle;
        $setting->donor_advides_content = $request->donor_advides_content;
        $setting->donor_cripto_title_1 = $request->donor_cripto_title_1;
        $setting->donor_cripto_content_1 = $request->donor_cripto_content_1;
        $setting->donor_cripto_title_2 = $request->donor_cripto_title_2;
        $setting->donor_cripto_content_2 = $request->donor_cripto_content_2;
        $setting->how_to_donate_cripto = $request->how_to_donate_cripto;
        
        $setting->donate_title = $request->donate_title;
        $setting->donate_subtitle = $request->donate_subtitle;
        $setting->donate_description = $request->donate_description;
        $setting->global_donorbox_code = $request->global_donorbox_code;



        $setting->article_news_content = $request->article_news_content;
        $setting->review_title = $request->review_title;
        $setting->review_sub_title = $request->review_sub_title;
        $setting->review_content = $request->review_content;
        $setting->our_numbers_content = $request->our_numbers_content;
        $setting->help_more_content = $request->help_more_content;
        $setting->peaple_helped = $request->peaple_helped;
        $setting->volunteers = $request->volunteers;
        $setting->educated_children = $request->educated_children;
        $setting->service_meal = $request->service_meal;

        $setting->emp_match_section_1 = $request->emp_match_section_1;
        $setting->emp_match_section_2 = $request->emp_match_section_2;
        $setting->emp_match_section_3 = $request->emp_match_section_3;
        $setting->emp_match_section_4 = $request->emp_match_section_4;
        $setting->emp_match_section_5 = $request->emp_match_section_5;
        

        $setting->editedby_id = auth()->id();

        // ---------------- LOGO ----------------
        if ($request->hasFile('logo')) {

            if ($setting->logo && Storage::disk('public')->exists('logo/' . $setting->logo)) {
                Storage::disk('public')->delete('logo/' . $setting->logo);
            }

            $file = $request->file('logo');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_logo_' . Str::random(6) . $ext;

            Storage::disk('public')->put('logo/' . $name, File::get($file));

            $setting->logo = $name;
        }

        // ---------------- LOGO ALT ----------------
        if ($request->hasFile('logo_alt')) {

            if ($setting->logo_alt && Storage::disk('public')->exists('logo_alt/' . $setting->logo_alt)) {
                Storage::disk('public')->delete('logo_alt/' . $setting->logo_alt);
            }

            $file = $request->file('logo_alt');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_logo_alt_' . Str::random(6) . $ext;

            Storage::disk('public')->put('logo_alt/' . $name, File::get($file));

            $setting->logo_alt = $name;
        }

        // ---------------- FAVICON ----------------
        if ($request->hasFile('favicon')) {

            if ($setting->favicon && Storage::disk('public')->exists('favicon/' . $setting->favicon)) {
                Storage::disk('public')->delete('favicon/' . $setting->favicon);
            }

            $file = $request->file('favicon');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_favicon_' . Str::random(6) . $ext;

            Storage::disk('public')->put('favicon/' . $name, File::get($file));

            $setting->favicon = $name;
        }

        // ---------------- CAMPAIGN COVER ----------------
        if ($request->hasFile('campaign_cover_image')) {

            if ($setting->campaign_cover_image && Storage::disk('public')->exists('campaign_cover_image/' . $setting->campaign_cover_image)) {
                Storage::disk('public')->delete('campaign_cover_image/' . $setting->campaign_cover_image);
            }

            $file = $request->file('campaign_cover_image');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_campaign_cover_' . Str::random(6) . $ext;

            Storage::disk('public')->put('campaign_cover_image/' . $name, File::get($file));

            $setting->campaign_cover_image = $name;
        }

        // ---------------- CONTACT US COVER ----------------
        if ($request->hasFile('contact_us_cover_image')) {

            if ($setting->contact_us_cover_image && Storage::disk('public')->exists('contact_us_cover_image/' . $setting->contact_us_cover_image)) {
                Storage::disk('public')->delete('contact_us_cover_image/' . $setting->contact_us_cover_image);
            }

            $file = $request->file('contact_us_cover_image');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_contact_cover_' . Str::random(6) . $ext;

            Storage::disk('public')->put('contact_us_cover_image/' . $name, File::get($file));

            $setting->contact_us_cover_image = $name;
        }

        // ---------------- ABOUT US COVER ----------------
        if ($request->hasFile('about_us_cover_image')) {

            if ($setting->about_us_cover_image && Storage::disk('public')->exists('about_us_cover_image/' . $setting->about_us_cover_image)) {
                Storage::disk('public')->delete('about_us_cover_image/' . $setting->about_us_cover_image);
            }

            $file = $request->file('about_us_cover_image');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_about_cover_' . Str::random(6) . $ext;

            Storage::disk('public')->put('about_us_cover_image/' . $name, File::get($file));

            $setting->about_us_cover_image = $name;
        }

        // ---------------- ABOUT US COVER FOR HOME----------------
        if ($request->hasFile('about_us_cover_image_home')) {

            if ($setting->about_us_cover_image_home && Storage::disk('public')->exists('about_us_cover_image_home/' . $setting->about_us_cover_image_home)) {
                Storage::disk('public')->delete('about_us_cover_image_home/' . $setting->about_us_cover_image_home);
            }

            $file = $request->file('about_us_cover_image_home');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_home_about_cover_' . Str::random(6) . $ext;

            Storage::disk('public')->put('about_us_cover_image_home/' . $name, File::get($file));

            $setting->about_us_cover_image_home = $name;
        }

        // ---------------- ABOUT IMAGE 1 ----------------
        if ($request->hasFile('about_us_image_1')) {

            if ($setting->about_us_image_1 && Storage::disk('public')->exists('about_us_image_1/' . $setting->about_us_image_1)) {
                Storage::disk('public')->delete('about_us_image_1/' . $setting->about_us_image_1);
            }

            $file = $request->file('about_us_image_1');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_about_1_' . Str::random(6) . $ext;

            Storage::disk('public')->put('about_us_image_1/' . $name, File::get($file));

            $setting->about_us_image_1 = $name;
        }

        // ---------------- ABOUT IMAGE 2 ----------------
        if ($request->hasFile('about_us_image_2')) {

            if ($setting->about_us_image_2 && Storage::disk('public')->exists('about_us_image_2/' . $setting->about_us_image_2)) {
                Storage::disk('public')->delete('about_us_image_2/' . $setting->about_us_image_2);
            }

            $file = $request->file('about_us_image_2');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_about_2_' . Str::random(6) . $ext;

            Storage::disk('public')->put('about_us_image_2/' . $name, File::get($file));

            $setting->about_us_image_2 = $name;
        }

        // ---------------- ABOUT IMAGE 3 ----------------
        if ($request->hasFile('about_us_image_3')) {

            if ($setting->about_us_image_3 && Storage::disk('public')->exists('about_us_image_3/' . $setting->about_us_image_3)) {
                Storage::disk('public')->delete('about_us_image_3/' . $setting->about_us_image_3);
            }

            $file = $request->file('about_us_image_3');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_about_3_' . Str::random(6) . $ext;

            Storage::disk('public')->put('about_us_image_3/' . $name, File::get($file));

            $setting->about_us_image_3 = $name;
        }

        // ---------------- ABOUT IMAGE 4 ----------------
        if ($request->hasFile('about_us_image_4')) {

            if ($setting->about_us_image_4 && Storage::disk('public')->exists('about_us_image_4/' . $setting->about_us_image_4)) {
                Storage::disk('public')->delete('about_us_image_4/' . $setting->about_us_image_4);
            }

            $file = $request->file('about_us_image_4');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_about_4_' . Str::random(6) . $ext;

            Storage::disk('public')->put('about_us_image_4/' . $name, File::get($file));

            $setting->about_us_image_4 = $name;
        }

        // ---------------- ANNUAL REPORT COVER ----------------
        if ($request->hasFile('anual_report_cover_img')) {

            if ($setting->anual_report_cover_img && Storage::disk('public')->exists('anual_report_cover_img/' . $setting->anual_report_cover_img)) {
                Storage::disk('public')->delete('anual_report_cover_img/' . $setting->anual_report_cover_img);
            }

            $file = $request->file('anual_report_cover_img');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_annual_report_' . Str::random(6) . $ext;

            Storage::disk('public')->put('anual_report_cover_img/' . $name, File::get($file));

            $setting->anual_report_cover_img = $name;
        }

        // ---------------- URGENT HELP IMAGE ----------------
        if ($request->hasFile('urgent_help_image')) {

            if ($setting->urgent_help_image && Storage::disk('public')->exists('urgent_help_image/' . $setting->urgent_help_image)) {
                Storage::disk('public')->delete('urgent_help_image/' . $setting->urgent_help_image);
            }

            $file = $request->file('urgent_help_image');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_urgent_help_' . Str::random(6) . $ext;

            Storage::disk('public')->put('urgent_help_image/' . $name, File::get($file));

            $setting->urgent_help_image = $name;
        }

        // ---------------- URGENT HELP IMAGE ----------------
        if ($request->hasFile('help_people_need_image')) {

            if ($setting->help_people_need_image && Storage::disk('public')->exists('help_people_need_image/' . $setting->help_people_need_image)) {
                Storage::disk('public')->delete('help_people_need_image/' . $setting->help_people_need_image);
            }

            $file = $request->file('help_people_need_image');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_need_help_' . Str::random(6) . $ext;

            Storage::disk('public')->put('help_people_need_image/' . $name, File::get($file));

            $setting->help_people_need_image = $name;
        }

        // ---------------- URGENT HELP IMAGE ----------------
        if ($request->hasFile('donor_advides_image')) {

            if ($setting->donor_advides_image && Storage::disk('public')->exists('donor_advides_image/' . $setting->donor_advides_image)) {
                Storage::disk('public')->delete('donor_advides_image/' . $setting->donor_advides_image);
            }

            $file = $request->file('donor_advides_image');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_need_help_' . Str::random(6) . $ext;

            Storage::disk('public')->put('donor_advides_image/' . $name, File::get($file));

            $setting->donor_advides_image = $name;
        }

        // ---------------- URGENT HELP IMAGE ----------------
        if ($request->hasFile('donate_hero_image')) {

            if ($setting->donate_hero_image && Storage::disk('public')->exists('donate_hero_image/' . $setting->donate_hero_image)) {
                Storage::disk('public')->delete('donate_hero_image/' . $setting->donate_hero_image);
            }

            $file = $request->file('donate_hero_image');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_need_help_' . Str::random(6) . $ext;

            Storage::disk('public')->put('donate_hero_image/' . $name, File::get($file));

            $setting->donate_hero_image = $name;
        }

        // ---------------- URGENT HELP IMAGE ----------------
        if ($request->hasFile('download_annual_report_file')) {

            if ($setting->download_annual_report_file && Storage::disk('public')->exists('download_annual_report_file/' . $setting->download_annual_report_file)) {
                Storage::disk('public')->delete('download_annual_report_file/' . $setting->download_annual_report_file);
            }

            $file = $request->file('download_annual_report_file');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_need_help_' . Str::random(6) . $ext;

            Storage::disk('public')->put('download_annual_report_file/' . $name, File::get($file));

            $setting->download_annual_report_file = $name;
        }

        // ---------- SAVE ----------
        $setting->save();

        return back()->with('success', 'Settings updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebsiteSetting $websiteSetting)
    {
        //
    }




    public function sitemapUpdate(Request $request, WebsiteSetting $setting)
    {

        $setting->gsc_verification = $request->gsc_verification;
        $setting->google_analytics = $request->google_analytics;
        $setting->tag_manager = $request->tag_manager;
        $setting->google_tag_manager_body = $request->google_tag_manager_body;

        if ($request->hasFile('sitemap_file')) {

            if ($setting->sitemap_file && Storage::disk('public')->exists('sitemap_file/' . $setting->sitemap_file)) {
                Storage::disk('public')->delete('sitemap_file/' . $setting->sitemap_file);
            }

            $file = $request->file('sitemap_file');
            $ext  = '.' . ($file->getClientOriginalExtension() ?: $file->extension());
            $name = time() . '_sitemap_file_' . Str::random(6) . $ext;

            $originalName = $file->getClientOriginalName();

            Storage::disk('public')->put('sitemap_file/' . $originalName, File::get($file));

            $setting->sitemap_file = $originalName;
        }

        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }


    public function notifySound(Request $request){
        $request->validate(['notify'=>'required|in:0,1']);
        $setting = WebsiteSetting::first(); // or however you store settings
        $setting->notify = (int)$request->notify;
        $setting->save();
        return response()->json(['ok'=>true,'notify'=>$setting->notify]);
    }

public function generateSitemap()
{
    $setting = WebsiteSetting::first();

    if (!$setting) {
        return back()->with('error', 'Website setting not found.');
    }

    $baseUrl = rtrim(config('app.url'), '/');

    $urls = [];

    // Static pages
    $urls[] = ['loc' => $baseUrl . '/', 'changefreq' => 'daily', 'priority' => '1.0'];
    $urls[] = ['loc' => $baseUrl . '/about', 'changefreq' => 'monthly', 'priority' => '0.8'];
    $urls[] = ['loc' => $baseUrl . '/projects', 'changefreq' => 'weekly', 'priority' => '0.9'];
    $urls[] = ['loc' => $baseUrl . '/contact', 'changefreq' => 'monthly', 'priority' => '0.7'];
    $urls[] = ['loc' => $baseUrl . '/news', 'changefreq' => 'weekly', 'priority' => '0.8'];
    $urls[] = ['loc' => $baseUrl . '/donation', 'changefreq' => 'weekly', 'priority' => '0.9'];

    // Spanish static pages
    $urls[] = ['loc' => $baseUrl . '/es/home', 'changefreq' => 'daily', 'priority' => '1.0'];
    $urls[] = ['loc' => $baseUrl . '/es/nosotros', 'changefreq' => 'monthly', 'priority' => '0.8'];
    $urls[] = ['loc' => $baseUrl . '/es/proyecto', 'changefreq' => 'weekly', 'priority' => '0.9'];
    $urls[] = ['loc' => $baseUrl . '/es/contacto', 'changefreq' => 'monthly', 'priority' => '0.7'];
    $urls[] = ['loc' => $baseUrl . '/es/news', 'changefreq' => 'weekly', 'priority' => '0.8'];
    $urls[] = ['loc' => $baseUrl . '/es/donations', 'changefreq' => 'weekly', 'priority' => '0.9'];

    // Campaigns
    $campaigns = Campaign::where('status', 'published')->get();

    foreach ($campaigns as $campaign) {
        $enPath = $campaign->getTranslation('path', 'en', false);
        $enSlug = $campaign->getTranslation('slug', 'en', false);

        $esPath = $campaign->getTranslation('path', 'es', false) ?: $enPath;
        $esSlug = $campaign->getTranslation('slug', 'es', false) ?: $enSlug;

        $enPath = is_string($enPath) ? trim($enPath) : '';
        $enSlug = is_string($enSlug) ? trim($enSlug) : '';
        $esPath = is_string($esPath) ? trim($esPath) : '';
        $esSlug = is_string($esSlug) ? trim($esSlug) : '';

        if ($enPath !== '' && $enSlug !== '') {
            $urls[] = [
                'loc' => $baseUrl . '/' . $enPath . '/' . $enSlug,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        if ($esPath !== '' && $esSlug !== '') {
            $urls[] = [
                'loc' => $baseUrl . '/es/' . $esPath . '/' . $esSlug,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }
    }

    // Stories
    $stories = Story::where('status', 'published')->get();

    foreach ($stories as $story) {
        $enSlug = $story->getTranslation('slug', 'en', false);
        $esSlug = $story->getTranslation('slug', 'es', false) ?: $enSlug;

        $enSlug = is_string($enSlug) ? trim($enSlug) : '';
        $esSlug = is_string($esSlug) ? trim($esSlug) : '';

        if ($enSlug !== '') {
            $urls[] = [
                'loc' => $baseUrl . '/report/' . $enSlug,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        if ($esSlug !== '') {
            $urls[] = [
                'loc' => $baseUrl . '/es/informe/' . $esSlug,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }
    }

    $xml = view('admin.seo.sitemap_xml', compact('urls'))->render();

    $fileName = 'sitemap.xml';

    Storage::disk('public')->put('sitemap_file/' . $fileName, $xml);

    $setting->sitemap_file = $fileName;
    $setting->save();

    return back()->with('success', 'Sitemap generated successfully!');
}
}
