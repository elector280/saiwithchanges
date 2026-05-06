<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\CampaignGalleryImage;
use App\Models\CampaignSlogan;
use App\Models\MiniCampaignTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    


    public function index()
    {
        $campaigns = Campaign::orderBy('id','DESC')->paginate(20);
        return view('admin.campaign.index', compact('campaigns'));
    }

    public function miniCampaignIndex()
    {
        $miniCampaigns = MiniCampaignTemplate::orderBy('id','DESC')->paginate(20);
        return view('admin.campaign.mini_campaign_index', compact('miniCampaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.campaign.create');
    }

    public function miniCampaignCreate()
    {
        return view('admin.campaign.mini_campaign_create');
    }
    
    public function store(Request $request)
{
    $request->validate([
        'title.en'   => 'required|string|max:255',
        'title.es'   => 'nullable|string|max:255',
        'status'     => 'required|in:1,0,published,draft',
        'url'        => 'nullable|url|max:500',
        'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        'footer_image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        'gallery_image' => 'nullable|array',
        'gallery_image.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    $campaign = new Campaign();

    $titleInput = $request->input('title', []);
    $slugInput  = $request->input('slug', []);
    $pathInput  = $request->input('path', []);

    $defaultPaths = [
        'en' => 'project',
        'es' => 'proyecto',
    ];

    /**
     * -----------------------------
     * TITLE translations
     * -----------------------------
     */
    $titleTranslations = [
        'en' => $this->pickTranslatedValue($titleInput, 'en', '', ''),
        'es' => $this->pickTranslatedValue($titleInput, 'es', '', ''),
    ];

    $campaign->setTranslations('title', $titleTranslations);

    /**
     * -----------------------------
     * PATH + SLUG translations
     * -----------------------------
     */
    $pathTranslations = [];
    $slugTranslations = [];

    foreach (['en', 'es'] as $lang) {
        $rawPath = $this->pickTranslatedValue(
            $pathInput,
            $lang,
            '',
            $defaultPaths[$lang]
        );

        $rawSlug = $this->pickTranslatedValue(
            $slugInput,
            $lang,
            '',
            $titleTranslations[$lang] ?? ''
        );

        $split = $this->extractPathAndSlug(
            $rawSlug,
            $rawPath,
            '',
            '',
            $defaultPaths[$lang],
            $titleTranslations[$lang] ?? ''
        );

        $pathTranslations[$lang] = $split['path'];
        $slugTranslations[$lang] = $split['slug'];
    }

    $campaign->setTranslations('path', $pathTranslations);
    $campaign->setTranslations('slug', $slugTranslations);

    /**
     * -----------------------------
     * Other fields
     * -----------------------------
     */
    $campaign->sub_title = $request->sub_title;
    $campaign->summary = $request->summary;
    $campaign->summary_espanish = $request->summary_espanish;
    $campaign->url = $request->url;
    $campaign->standard_webpage_content = $request->standard_webpage_content;
    $campaign->problem = $request->problem;
    $campaign->solution = $request->solution;
    $campaign->impact = $request->impact;
    $campaign->google_description = $request->google_description;
    $campaign->short_description = $request->short_description;
    $campaign->type = $request->type;
    $campaign->donorbox_code = $request->donorbox_code;
    $campaign->video = $request->video;
    $campaign->status = $request->status;
    $campaign->show_home_page = $request->show_home_page;
    $campaign->donorbox_code_spanish = $request->donorbox_code_spanish;
    $campaign->video_for_spanish = $request->video_for_spanish;
    $campaign->seo_title = $request->seo_title;
    $campaign->seo_description = $request->seo_description;
    $campaign->meta_keyword = $request->meta_keyword;
    $campaign->position = $request->position;
    $campaign->home_order = $request->home_order;
    $campaign->show_on_navbar = $request->show_on_navbar;
    $campaign->bg_color = $request->bg_color;
    $campaign->footer_title = $request->footer_title;
    $campaign->footer_subtitle = $request->footer_subtitle;
    $campaign->footer_button_link = $request->footer_button_link;

    /**
     * -----------------------------
     * HERO IMAGE
     * -----------------------------
     */
    if ($request->hasFile('hero_image')) {
        $file = $request->file('hero_image');
        $name = time() . '_hero.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('hero_image/' . $name, File::get($file));
        $campaign->hero_image = $name;
    }

    /**
     * -----------------------------
     * FOOTER IMAGE 2
     * -----------------------------
     */
    if ($request->hasFile('footer_image2')) {
        $file = $request->file('footer_image2');
        $name = time() . '_hero.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('footer_image2/' . $name, File::get($file));
        $campaign->footer_image2 = $name;
    }

    /**
     * -----------------------------
     * HEADER PHOTO
     * -----------------------------
     */
    $campaign->header_photo_layout = $request->header_photo_layout ?? 'object-cover object-center';
    if ($request->hasFile('header_photo')) {
        $file = $request->file('header_photo');
        $name = time() . '_header.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('hero_image/' . $name, File::get($file));
        $campaign->header_photo = $name;
    }

    $campaign->save();

    /**
     * -----------------------------
     * Gallery images
     * -----------------------------
     */
    if ($request->hasFile('gallery_image')) {
        foreach ($request->file('gallery_image') as $img) {
            $name = time() . '_gallery_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            Storage::disk('public')->put('gallery_image/' . $name, File::get($img));

            $image = new CampaignGalleryImage();
            $image->campaign_id = $campaign->id;
            $image->image = $name;
            $image->title = 'title';
            $image->description = 'description';
            $image->addedby_id = auth()->id();
            $image->editedby_id = auth()->id();
            $image->save();
        }
    }

    /**
     * -----------------------------
     * Slogans
     * -----------------------------
     */
    $sloganTitles = $request->input('slogan_title', []);
    $textColors   = $request->input('slogan_text_color', []);
    $bgColors     = $request->input('slogan_bg_color', []);

    foreach ($sloganTitles as $i => $title) {
        $title = trim((string) $title);

        if ($title === '') {
            continue;
        }

        CampaignSlogan::create([
            'campaign_id'       => $campaign->id,
            'slogan_title'      => $title,
            'slogan_text_color' => $textColors[$i] ?? null,
            'slogan_bg_color'   => $bgColors[$i] ?? null,
        ]);
    }

    return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully!');
}


public function miniCampaignStore(Request $request)
{
    try {
        $locale = app()->getLocale();

        $request->validate([
            'title' => ['nullable', 'array'],
            'title.*' => ['nullable', 'string', 'max:255'],

            'slug' => ['nullable', 'array'],
            'slug.*' => ['nullable', 'string', 'max:255'],

            'short_description' => ['nullable', 'array'],
            'short_description.*' => ['nullable', 'string'],

            'paragraph_one' => ['nullable', 'array'],
            'paragraph_one.*' => ['nullable', 'string'],

            'paragraph_two' => ['nullable', 'array'],
            'paragraph_two.*' => ['nullable', 'string'],

            'meta_title' => ['nullable', 'array'],
            'meta_title.*' => ['nullable', 'string', 'max:255'],

            'meta_description' => ['nullable', 'array'],
            'meta_description.*' => ['nullable', 'string'],

            'meta_keywords' => ['nullable', 'array'],
            'meta_keywords.*' => ['nullable', 'string'],

            'og_title' => ['nullable', 'array'],
            'og_title.*' => ['nullable', 'string', 'max:255'],

            'og_description' => ['nullable', 'array'],
            'og_description.*' => ['nullable', 'string'],

            'canonical_url' => ['nullable', 'array'],
            'canonical_url.*' => ['nullable', 'string', 'max:255'],

            'donation_box' => ['nullable', 'array'],
            'donation_box.*' => ['nullable', 'string'],

            'status' => ['required', 'in:0,1'],
            'tag_line' => ['nullable', 'string', 'max:255'],
            'utm_source' => ['nullable', 'string', 'max:255'],
            'utm_medium' => ['nullable', 'string', 'max:255'],
            'utm_campaign' => ['nullable', 'string', 'max:255'],

            'start_date' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'end_date' => ['nullable', 'date_format:Y-m-d\TH:i'],

            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
        ], [
            'start_date.date_format' => 'Start date format is invalid.',
            'end_date.date_format' => 'End date format is invalid.',
        ]);

        DB::beginTransaction();

        $cam = new MiniCampaignTemplate();

        $cam->title = $request->title ?? [];

        $slugInput = $request->input("slug.$locale");
        if (!$slugInput && is_array($request->slug)) {
            $slugInput = reset($request->slug);
        }
        $slugInput = is_string($slugInput) ? trim($slugInput) : '';

        $cam->slug = $slugInput !== '' ? Str::slug($slugInput) : uniqid('mini-');

        $cam->status = (int) $request->status;
        $cam->view_project_url = $request->view_project_url ?? '#';

        $cam->short_description = $request->short_description ?? [];
        $cam->paragraph_one = $request->paragraph_one ?? [];
        $cam->paragraph_two = $request->paragraph_two ?? [];

        $cam->meta_title = $request->meta_title ?? [];
        $cam->meta_description = $request->meta_description ?? [];
        $cam->meta_keywords = $request->meta_keywords ?? [];
        $cam->og_title = $request->og_title ?? [];
        $cam->og_description = $request->og_description ?? [];
        $cam->canonical_url = $request->canonical_url ?? [];
        $cam->donation_box = $request->donation_box ?? [];

        $cam->tag_line = $request->tag_line;
        $cam->utm_source = $request->utm_source;
        $cam->utm_medium = $request->utm_medium;
        $cam->utm_campaign = $request->utm_campaign;

        $cam->start_date = $request->filled('start_date')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date)->format('Y-m-d H:i:s')
            : null;

        $cam->end_date = $request->filled('end_date')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date)->format('Y-m-d H:i:s')
            : null;

        $cam->created_by = Auth::id();
        $cam->updated_by = Auth::id();

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $name = time() . '_cover_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('cover_image/' . $name, File::get($file));
            $cam->cover_image = $name;
        }

        if ($request->hasFile('og_image')) {
            $file = $request->file('og_image');
            $name = time() . '_og_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('og_image/' . $name, File::get($file));
            $cam->og_image = $name;
        }

        $cam->header_photo_layout = $request->header_photo_layout ?? 'object-cover object-center';
        if ($request->hasFile('header_photo')) {
            $file = $request->file('header_photo');
            $name = time() . '_header_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('hero_image/' . $name, File::get($file));
            $cam->header_photo = $name;
        }

        $cam->save();

        DB::commit();

        return redirect()
            ->route('campaigns.miniCampaignIndex')
            ->with('success', 'Mini Campaign Template saved successfully!');

    } catch (ValidationException $e) {
        DB::rollBack();
        throw $e;

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Mini Campaign Store Failed', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'user_id' => Auth::id(),
            'request_data' => $request->except(['cover_image', 'og_image']),
        ]);

        return back()
            ->withInput()
            ->with('error', 'Mini campaign save failed. Please check the form and try again.');
    }
}



    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        return view('admin.campaign.show', compact('campaign'));
    }
    public function miniCampaignShow($id)
    {
        $minicampaign = MiniCampaignTemplate::findOrFail($id);


        return view('admin.campaign.mini_campaign_show', compact('minicampaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        return view('admin.campaign.edit', compact('campaign'));
    }

    public function miniCampaignEdit($id)
    {
         $minicampaign = MiniCampaignTemplate::findOrFail($id);
        return view('admin.campaign.mini_campaign_edit', compact('minicampaign'));
    }

    
    public function update(Request $request, Campaign $campaign)
{
    // dd($request->all());
    $titleInput = $request->input('title', []);
    $slugInput  = $request->input('slug', []);
    $pathInput  = $request->input('path', []);

    $existingTitle = $campaign->getTranslations('title');
    $existingSlug  = $campaign->getTranslations('slug');
    $existingPath  = $campaign->getTranslations('path');

    $defaultPaths = [
        'en' => 'project',
        'es' => 'proyecto',
    ];

    /**
     * -----------------------------
     * TITLE translations
     * -----------------------------
     */
    $titleTranslations = [
        'en' => $this->pickTranslatedValue(
            $titleInput,
            'en',
            $existingTitle['en'] ?? ''
        ),
        'es' => $this->pickTranslatedValue(
            $titleInput,
            'es',
            $existingTitle['es'] ?? ''
        ),
    ];
    $campaign->setTranslations('title', $titleTranslations);

    /**
     * -----------------------------
     * PATH + SLUG translations
     * Rules:
     * 1) If slug input contains "/", split into path + slug
     * 2) If path input exists, it overrides path
     * 3) If slug input blank, existing DB slug remains
     * 4) If no slug anywhere, generate from title
     * -----------------------------
     */
    $pathTranslations = [];
    $slugTranslations = [];

    foreach (['en', 'es'] as $lang) {
        $existingPathValue = $existingPath[$lang] ?? $defaultPaths[$lang];
        $existingSlugValue = $existingSlug[$lang] ?? '';
        $titleValue        = $titleTranslations[$lang] ?? '';

        $rawPath = $this->pickTranslatedValue(
            $pathInput,
            $lang,
            $existingPathValue,
            $defaultPaths[$lang]
        );

        $rawSlug = $this->pickTranslatedValue(
            $slugInput,
            $lang,
            $existingSlugValue,
            $titleValue
        );

        $split = $this->extractPathAndSlug(
            $rawSlug,
            $rawPath,
            $existingPathValue,
            $existingSlugValue,
            $defaultPaths[$lang],
            $titleValue
        );

        $pathTranslations[$lang] = $split['path'];
        $slugTranslations[$lang] = $split['slug'];
    }

    $campaign->setTranslations('path', $pathTranslations);
    $campaign->setTranslations('slug', $slugTranslations);

    /**
     * -----------------------------
     * Other fields
     * -----------------------------
     */
    $campaign->sub_title = $request->sub_title;
    $campaign->summary = $request->summary;
    $campaign->summary_espanish = $request->summary_espanish;
    $campaign->url = $request->url;
    $campaign->standard_webpage_content = $request->standard_webpage_content;
    $campaign->problem = $request->problem;
    $campaign->solution = $request->solution;
    $campaign->impact = $request->impact;
    $campaign->google_description = $request->google_description;
    $campaign->short_description = $request->short_description;
    $campaign->type = $request->type;
    $campaign->donorbox_code = $request->donorbox_code;
    $campaign->video = $request->video;
    $campaign->status = $request->status;
    $campaign->show_home_page = $request->show_home_page;
    $campaign->donorbox_code_spanish = $request->donorbox_code_spanish;
    $campaign->video_for_spanish = $request->video_for_spanish;
    $campaign->seo_title = $request->seo_title;
    $campaign->meta_keyword = $request->meta_keyword;
    $campaign->seo_description = $request->seo_description;
    $campaign->position = $request->position;
    $campaign->home_order = $request->home_order;
    $campaign->show_on_navbar = $request->show_on_navbar;
    $campaign->bg_color = $request->bg_color;
    $campaign->footer_title = $request->footer_title;
    $campaign->footer_subtitle = $request->footer_subtitle;
    $campaign->footer_button_link = $request->footer_button_link;

//dd($campaign);
    /**
     * -----------------------------
     * HERO IMAGE replace
     * -----------------------------
     */
    if ($request->hasFile('hero_image')) {
        if ($campaign->hero_image && Storage::disk('public')->exists('hero_image/' . $campaign->hero_image)) {
            Storage::disk('public')->delete('hero_image/' . $campaign->hero_image);
        }

        $file = $request->file('hero_image');
        $name = time() . '_hero.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('hero_image/' . $name, File::get($file));
        $campaign->hero_image = $name;
    }

    /**
     * -----------------------------
     * FOOTER IMAGE 2 replace
     * -----------------------------
     */
    if ($request->hasFile('footer_image2')) {
        if ($campaign->footer_image2 && Storage::disk('public')->exists('footer_image2/' . $campaign->footer_image2)) {
            Storage::disk('public')->delete('footer_image2/' . $campaign->footer_image2);
        }

        $file = $request->file('footer_image2');
        $name = time() . '_hero.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('footer_image2/' . $name, File::get($file));
        $campaign->footer_image2 = $name;
    }

    /**
     * -----------------------------
     * HEADER PHOTO replace
     * -----------------------------
     */
    $campaign->header_photo_layout = $request->header_photo_layout ?? 'object-cover object-center';
    if ($request->hasFile('header_photo')) {
        if ($campaign->header_photo && Storage::disk('public')->exists('hero_image/' . $campaign->header_photo)) {
            Storage::disk('public')->delete('hero_image/' . $campaign->header_photo);
        }

        $file = $request->file('header_photo');
        $name = time() . '_header.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('hero_image/' . $name, File::get($file));
        $campaign->header_photo = $name;
    }

    $campaign->save();

    /**
     * -----------------------------
     * New gallery add
     * -----------------------------
     */
    if ($request->hasFile('gallery_image')) {
        foreach ($request->file('gallery_image') as $img) {
            $name = time() . '_gallery_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            Storage::disk('public')->put('gallery_image/' . $name, File::get($img));

            $image = new CampaignGalleryImage();
            $image->campaign_id = $campaign->id;
            $image->image = $name;
            $image->title = 'title';
            $image->description = 'description';
            $image->addedby_id = auth()->id();
            $image->editedby_id = auth()->id();
            $image->save();
        }
    }

    /**
     * -----------------------------
     * Campaign slogans
     * -----------------------------
     */
    DB::transaction(function () use ($request, $campaign) {
        $ids        = $request->input('slogan_id', []);
        $titles     = $request->input('slogan_title', []);
        $textColors = $request->input('slogan_text_color', []);
        $bgColors   = $request->input('slogan_bg_color', []);

        $keepIds = [];

        foreach ($titles as $i => $t) {
            $t = trim((string) $t);

            if ($t === '') {
                continue;
            }

            $id = $ids[$i] ?? null;

            $data = [
                'campaign_id'       => $campaign->id,
                'slogan_title'      => $t,
                'slogan_text_color' => $textColors[$i] ?? null,
                'slogan_bg_color'   => $bgColors[$i] ?? null,
            ];

            if ($id) {
                CampaignSlogan::where('campaign_id', $campaign->id)
                    ->where('id', $id)
                    ->update($data);

                $keepIds[] = (int) $id;
            } else {
                $new = CampaignSlogan::create($data);
                $keepIds[] = (int) $new->id;
            }
        }

        CampaignSlogan::where('campaign_id', $campaign->id)
            ->when(count($keepIds) > 0, fn($q) => $q->whereNotIn('id', $keepIds))
            ->when(count($keepIds) === 0, fn($q) => $q)
            ->delete();
    });

    return redirect()->route('campaigns.index')->with('success', 'Campaign updated successfully!');
}

private function pickTranslatedValue(array $input, string $lang, string $existing = '', string $fallback = ''): string
{
    $value = $input[$lang] ?? null;

    if ($value !== null && trim((string) $value) !== '') {
        return trim((string) $value);
    }

    if (trim((string) $existing) !== '') {
        return trim((string) $existing);
    }

    return trim((string) $fallback);
}

private function extractPathAndSlug(
    string $rawSlug,
    string $rawPath,
    string $existingPath,
    string $existingSlug,
    string $defaultPath,
    string $titleFallback
): array {
    $rawSlug = trim((string) $rawSlug);
    $rawPath = trim((string) $rawPath);

    $path = $rawPath !== '' ? $rawPath : ($existingPath !== '' ? $existingPath : $defaultPath);
    $slug = $rawSlug !== '' ? $rawSlug : ($existingSlug !== '' ? $existingSlug : $titleFallback);

    $path = trim($path, '/');
    $slug = trim($slug, '/');

    if ($slug !== '' && str_contains($slug, '/')) {
        $parts = explode('/', $slug, 2);

        $pathFromSlug = trim($parts[0] ?? '');
        $slugOnly     = trim($parts[1] ?? '');

        if ($pathFromSlug !== '') {
            $path = $pathFromSlug;
        }

        $slug = $slugOnly;
    }

    $path = $this->normalizePathSegment($path !== '' ? $path : $defaultPath);
    $slug = $this->normalizeSlugSegment($slug);

    if ($path === '') {
        $path = $defaultPath;
    }

    if ($slug === '') {
        $slug = $this->normalizeSlugSegment($titleFallback);
    }

    return [
        'path' => $path,
        'slug' => $slug,
    ];
}

private function normalizePathSegment(string $value): string
{
    $value = trim($value);
    $value = trim($value, '/');

    $segments = explode('/', $value);
    $segments = array_map(function ($segment) {
        return $this->slugPreserveCase($segment);
    }, $segments);

    $segments = array_filter($segments, fn($segment) => $segment !== '');

    return implode('/', $segments);
}

private function normalizeSlugSegment(string $value): string
{
    $value = trim($value);
    $value = trim($value, '/');

    if ($value === '') {
        return '';
    }

    // safety: if someone still passes full path, keep only the last segment as slug
    if (str_contains($value, '/')) {
        $parts = explode('/', $value);
        $value = end($parts);
    }

    return $this->slugPreserveCase($value);
}

private function slugPreserveCase(string $value): string
{
    $value = trim($value);

    if ($value === '') {
        return '';
    }

    // Convert to lowercase
    $value = strtolower($value);

    // Replace spaces and underscores with hyphen
    $value = preg_replace('/[\s_]+/', '-', $value);

    // Remove everything except letters, numbers and hyphen
    $value = preg_replace('/[^a-z0-9\-]/', '', $value);

    // Remove duplicate hyphens
    $value = preg_replace('/-+/', '-', $value);

    return trim($value, '-');
}

    
    
    private function splitPathAndSlug($value, $defaultPath = 'project')
{
    $value = trim((string) $value);
    $value = trim($value, '/');

    if ($value === '') {
        return [
            'path' => $defaultPath,
            'slug' => '',
        ];
    }

    $parts = explode('/', $value, 2);

    if (count($parts) === 2) {
        return [
            'path' => $this->slugPreserveCase($parts[0]),
            'slug' => $this->slugPreserveCase($parts[1]),
        ];
    }

    return [
        'path' => $defaultPath,
        'slug' => $this->slugPreserveCase($parts[0]),
    ];
}

    public function sloganDelete($id)
    {
        $slogan = CampaignSlogan::findOrFail($id);
        $slogan->delete();
        return redirect()->route('campaigns.edit', $slogan->campaign_id)->with('success', 'Slogan delete successfully');
    }

        public function updateInlineUrl(Request $request, Campaign $campaign)
    {
        $locale = $request->locale;

        $validator = Validator::make($request->all(), [
            'locale' => 'required|string',
            'full_url' => 'required|string|max:255',
        ], [
            'full_url.required' => 'Page URL is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $fullUrl = trim($request->full_url, '/');

        if (!str_contains($fullUrl, '/')) {
            return response()->json([
                'status' => false,
                'message' => 'URL must contain both path and slug. Example: usa/help-venezuela',
            ], 422);
        }

        $segments = explode('/', $fullUrl);
        $slug = array_pop($segments);
        $path = implode('/', $segments);

        if (empty($path) || empty($slug)) {
            return response()->json([
                'status' => false,
                'message' => 'Path and slug both are required.',
            ], 422);
        }

        // optional sanitize
        $path = Str::slug($path, '/');
        $slug = Str::slug($slug);

        // Example if path and slug are translatable json fields:
        $pathData = is_array($campaign->path) ? $campaign->path : (json_decode($campaign->path, true) ?: []);
        $slugData = is_array($campaign->slug) ? $campaign->slug : (json_decode($campaign->slug, true) ?: []);

        $pathData[$locale] = $path;
        $slugData[$locale] = $slug;

        $campaign->path = $pathData;
        $campaign->slug = $slugData;
        $campaign->save();

        return response()->json([
            'status' => true,
            'message' => 'Page URL updated successfully.',
            'path' => $path,
            'slug' => $slug,
            'full_url' => $path . '/' . $slug,
            'display_url' => 'sai.ngo/' . $path . '/' . $slug,
        ]);
    }
    
    public function miniCampaignUpdate(Request $request, $id)
{
    try {
        $locale = app()->getLocale();

        $request->validate([
            'title' => ['nullable', 'array'],
            'title.*' => ['nullable', 'string', 'max:255'],

            'slug' => ['nullable', 'array'],
            'slug.*' => ['nullable', 'string', 'max:255'],

            'short_description' => ['nullable', 'array'],
            'short_description.*' => ['nullable', 'string'],

            'paragraph_one' => ['nullable', 'array'],
            'paragraph_one.*' => ['nullable', 'string'],

            'paragraph_two' => ['nullable', 'array'],
            'paragraph_two.*' => ['nullable', 'string'],

            'meta_title' => ['nullable', 'array'],
            'meta_title.*' => ['nullable', 'string', 'max:255'],

            'meta_description' => ['nullable', 'array'],
            'meta_description.*' => ['nullable', 'string'],

            'meta_keywords' => ['nullable', 'array'],
            'meta_keywords.*' => ['nullable', 'string'],

            'og_title' => ['nullable', 'array'],
            'og_title.*' => ['nullable', 'string', 'max:255'],

            'og_description' => ['nullable', 'array'],
            'og_description.*' => ['nullable', 'string'],

            'canonical_url' => ['nullable', 'array'],
            'canonical_url.*' => ['nullable', 'string', 'max:255'],

            'donation_box' => ['nullable', 'array'],
            'donation_box.*' => ['nullable', 'string'],

            'status' => ['required', 'in:0,1'],
            'tag_line' => ['nullable', 'string', 'max:255'],
            'utm_source' => ['nullable', 'string', 'max:255'],
            'utm_medium' => ['nullable', 'string', 'max:255'],
            'utm_campaign' => ['nullable', 'string', 'max:255'],

            'start_date' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'end_date' => ['nullable', 'date_format:Y-m-d\TH:i'],

            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
        ]);

        DB::beginTransaction();

        $cam = MiniCampaignTemplate::findOrFail($id);

        $cam->title = $request->title ?? [];

        $slugInput = $request->input("slug.$locale");
        if (!$slugInput && is_array($request->slug)) {
            $slugInput = reset($request->slug);
        }
        $slugInput = is_string($slugInput) ? trim($slugInput) : '';

        $cam->slug = $slugInput !== '' ? Str::slug($slugInput) : ($cam->slug ?: uniqid('mini-'));

        $cam->status = (int) $request->status;
        $cam->view_project_url = $request->view_project_url ?? '#';

        $cam->short_description = $request->short_description ?? [];
        $cam->paragraph_one = $request->paragraph_one ?? [];
        $cam->paragraph_two = $request->paragraph_two ?? [];

        $cam->meta_title = $request->meta_title ?? [];
        $cam->meta_description = $request->meta_description ?? [];
        $cam->meta_keywords = $request->meta_keywords ?? [];
        $cam->og_title = $request->og_title ?? [];
        $cam->og_description = $request->og_description ?? [];
        $cam->canonical_url = $request->canonical_url ?? [];
        $cam->donation_box = $request->donation_box ?? [];

        $cam->tag_line = $request->tag_line;
        $cam->utm_source = $request->utm_source;
        $cam->utm_medium = $request->utm_medium;
        $cam->utm_campaign = $request->utm_campaign;

        $cam->start_date = $request->filled('start_date')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date)->format('Y-m-d H:i:s')
            : null;

        $cam->end_date = $request->filled('end_date')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date)->format('Y-m-d H:i:s')
            : null;

        $cam->updated_by = Auth::id();

        if ($request->hasFile('cover_image')) {
            if ($cam->cover_image && Storage::disk('public')->exists('cover_image/' . $cam->cover_image)) {
                Storage::disk('public')->delete('cover_image/' . $cam->cover_image);
            }

            $file = $request->file('cover_image');
            $name = time() . '_cover_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('cover_image/' . $name, File::get($file));
            $cam->cover_image = $name;
        }

        if ($request->hasFile('og_image')) {
            if ($cam->og_image && Storage::disk('public')->exists('og_image/' . $cam->og_image)) {
                Storage::disk('public')->delete('og_image/' . $cam->og_image);
            }

            $file = $request->file('og_image');
            $name = time() . '_og_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('og_image/' . $name, File::get($file));
            $cam->og_image = $name;
        }

        $cam->header_photo_layout = $request->header_photo_layout ?? 'object-cover object-center';
        if ($request->hasFile('header_photo')) {
            if ($cam->header_photo && Storage::disk('public')->exists('hero_image/' . $cam->header_photo)) {
                Storage::disk('public')->delete('hero_image/' . $cam->header_photo);
            }

            $file = $request->file('header_photo');
            $name = time() . '_header_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('hero_image/' . $name, File::get($file));
            $cam->header_photo = $name;
        }

        $cam->save();

        DB::commit();

        return redirect()
            ->route('campaigns.miniCampaignIndex')
            ->with('success', 'Mini Campaign template updated successfully!');

    } catch (ValidationException $e) {
        DB::rollBack();
        throw $e;

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Mini Campaign Update Failed', [
            'campaign_id' => $id,
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'user_id' => Auth::id(),
            'request_data' => $request->except(['cover_image', 'og_image']),
        ]);

        return back()
            ->withInput()
            ->with('error', 'Mini campaign update failed. Please try again.');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $campaign = Campaign::with('galleryImages')->findOrFail($id);

            // ✅ delete hero image file
            if (!empty($campaign->hero_image)) {
                $heroPath = public_path('storage/hero_image/' . $campaign->hero_image);
                if (file_exists($heroPath)) {
                    @unlink($heroPath);
                }
            }

            // ✅ delete footer image file
            if (!empty($campaign->footer_image)) {
                $footerPath = public_path('storage/footer_image/' . $campaign->footer_image);
                if (file_exists($footerPath)) {
                    @unlink($footerPath);
                }
            }

            // ✅ delete gallery files + rows
            foreach ($campaign->galleryImages as $img) {
                if (!empty($img->image)) {
                    $galleryPath = public_path('storage/gallery_image/' . $img->image);
                    if (file_exists($galleryPath)) {
                        @unlink($galleryPath);
                    }
                }
                $img->delete(); // delete row
            }

            // ✅ finally delete campaign row
            $campaign->delete();

            DB::commit();

            return redirect()->route('campaigns.index')->with([
                'message' => 'Campaign deleted successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'message' => 'Delete failed! ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
public function miniCampaignDestroy($id)
{
    DB::beginTransaction();

    try {
        $campaign = MiniCampaignTemplate::findOrFail($id);

        // ✅ remove dd() - এটা থাকলে delete হবে না
        // dd($campaign);

        // ✅ delete files from public disk (recommended)
        if (!empty($campaign->cover_image)) {
            Storage::disk('public')->delete('cover_image/'.$campaign->cover_image);
        }

        if (!empty($campaign->og_image)) {
            Storage::disk('public')->delete('og_image/'.$campaign->og_image);
        }

        // ✅ delete row
        $campaign->delete();

        // ✅ MUST commit
        DB::commit();

        return redirect()->route('campaigns.miniCampaignIndex')->with([
            'message' => 'Mini Campaign template deleted successfully!',
            'alert-type' => 'success'
        ]);

    } catch (\Throwable $e) {
        DB::rollBack();

        return redirect()->back()->with([
            'message' => 'Delete failed! ' . $e->getMessage(),
            'alert-type' => 'error'
        ]);
    }
}

    public function toggleStatus(Campaign $campaign)
    {
        $statuses = ['published', 'draft', 'archive'];
        $currentIndex = array_search($campaign->status, $statuses);

        $nextStatus = $statuses[($currentIndex + 1) % count($statuses)];

        $campaign->update([
            'status' => $nextStatus
        ]);

        return back()->with('success', 'Status updated successfully!');
    }



    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || count($ids) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No items selected'
            ]);
        }

        Campaign::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected campaigns deleted successfully!'
        ]);
    }

    public function deleteGalleryImage(Request $request)
    {
        // dd($request->all());

        $img = CampaignGalleryImage::findOrFail($request->imageId);

        if (!empty($img->gallery_image)) {
            $footerPath = public_path('storage/gallery_image/' . $img->gallery_image);
            if (file_exists($footerPath)) {
                @unlink($footerPath);
            }
        }
        $campaignId = $img->campaign_id;
        $img->delete();

        return redirect()->route('campaigns.edit', $campaignId)->with('success', 'Gallery item deleted successfully');
    }

    public function deleteImage($id)
    {
        $image = CampaignGalleryImage::find($id); // Replace with your model's name

        if ($image) {
            // Delete the image file from storage
            $imagePath = 'gallery_image/' . $image->image;
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            // Delete the image record from the database
            $image->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }



    public function galleryindex(Request $request)
    {
        // q না এলে empty string নেবে
        $q = trim($request->query('q', ''));

        $campaigns = Campaign::query()
            ->with('galleryImages')
            ->when($q !== '', function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.campaign_gallery.index', compact('campaigns', 'q'));
    }



    public function galleryedit(Campaign $campaign)
    {
        $campaign->load(['galleryImages']);
        return view('admin.campaign_gallery.edit', compact('campaign'));
    }

    public function gallerystore(Request $request, Campaign $campaign)
    {
        // dd($request->all());
        $request->validate([
            'image' => ['required', 'image', 'max:5120'],
            'title' => ['required'],
            'description' => ['required'],
            'slug' => ['required', 'string', 'max:255'],
        ]);

        $file = $request->file('image');
        $name = $file->getClientOriginalName();

        Storage::disk('public')->put('gallery_image/' . $name, File::get($file));

        $nextOrder = (int) ($campaign->galleryImages()->max('sort_order') ?? 0) + 1;

        $slug = $this->slugPreserveCase($request->slug ?? '');

        // duplicate slug হলে unique বানাই
        $exists = CampaignGalleryImage::where('slug', $slug)->exists();
        if ($exists) {
            $slug = $slug . '-' . time(); // বা -id পরে add করবেন
        }

        $gallery = new CampaignGalleryImage();
        $gallery->campaign_id  = $campaign->id;
        $gallery->image  = $name;
        $gallery->slug   = $slug;               // ✅ slug saved
        $gallery->title  = $request->title;
        $gallery->alt_text       = $request->alt_text;
        $gallery->caption       = $request->caption;
        $gallery->tags       = $request->tags;
        $gallery->credit_copyrights       = $request->credit_copyrights;
        $gallery->description  = $request->description;
        $gallery->sort_order  = $nextOrder;
        $gallery->addedby_id  = auth()->id();
        $gallery->save();

        return back()->with('success', 'Image added successfully.');
    }

    public function galleryUpdate(Request $request, Campaign $campaign, $gallery)
    {

        $img = $campaign->galleryImages()->findOrFail($gallery);
        $request->validate([
            'image'       => ['nullable', 'image', 'max:5120'],
            'title'       => ['required'],
            'description' => ['required'],
        ]);

        $slug = $this->slugPreserveCase($request->slug ?? '');

        $img->title       = $request->title;
        $img->slug        = $slug;               
        $img->alt_text    = $request->alt_text;
        $img->caption     = $request->caption;
        $img->tags        = $request->tags;
        $img->credit_copyrights       = $request->credit_copyrights;
        $img->description = $request->description;
        $img->editedby_id = auth()->id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $name = time() . '_gallery_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            // $name = $file->getClientOriginalName();
            Storage::disk('public')->put('gallery_image/' . $name, File::get($file));

            if (!empty($img->image) && Storage::disk('public')->exists('gallery_image/' . $img->image)) {
                Storage::disk('public')->delete('gallery_image/' . $img->image);
            }

            $img->image = $name;
        }

        $img->save();

        return back()->with('success', 'Image updated successfully.');
    }


    public function galleryreorder(Request $request, Campaign $campaign)
    {
        $request->validate([
            'orders' => ['required', 'array'],
            'orders.*.id' => ['required', 'integer'],
            'orders.*.sort_order' => ['required', 'integer'],
        ]);

        $ids = collect($request->orders)->pluck('id')->all();

        $count = CampaignGalleryImage::where('campaign_id', $campaign->id)
            ->whereIn('id', $ids)
            ->count();

        if ($count !== count($ids)) {
            return response()->json(['message' => 'Invalid images'], 422);
        }

        DB::transaction(function () use ($request, $campaign) {
            foreach ($request->orders as $row) {
                CampaignGalleryImage::where('campaign_id', $campaign->id)
                    ->where('id', $row['id'])
                    ->update([
                        'sort_order' => $row['sort_order'],
                        'editedby_id' => auth()->id(),
                    ]);
            }
        });

        return response()->json(['message' => 'Saved']);
    }

    public function gallerydestroy(Campaign $campaign, CampaignGalleryImage $img)
    {
        // dd($img);

        if ($img->campaign_id !== $campaign->id) {
            abort(404);
        }

        if (!empty($img->image)) {
            $footerPath = public_path('storage/gallery_image/' . $img->image);
            if (file_exists($footerPath)) {
                @unlink($footerPath);
            }
        }

        // storage image delete
        Storage::disk('public')->delete($img->image);

        $img->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
