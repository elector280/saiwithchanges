<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('developer', 0)->get();
        $stories = Story::orderBy('id','DESC')->get();
        return view('admin.story.index',compact('stories', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campaigns = Campaign::get();
        $author = User::where('developer', 0)->get();
        $categories = Category::get();
        return view('admin.story.create',compact('campaigns', 'author', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    { 
        $story = new Story();

        $title = $request->input('title', []);
        $slugInput  = $request->input('slug', []);
        $pathInput  = $request->input('reportpath', []);

        /**
         * Title translations
         */
        if (!empty($title)) {
            $story->setTranslations('title', $title);
        }

        /**
         * Default report path
         */
        $defaults = [
            'en' => 'report',
            'es' => 'informe',
        ];

        $slugTranslations = [];
        $pathTranslations = [];

        foreach ($defaults as $lang => $defaultPath) {

            $titleValue = $title[$lang] ?? '';

            // slug input
            $rawSlug = $slugInput[$lang] ?? $titleValue;

            // path input
            $rawPath = $pathInput[$lang] ?? $defaultPath;

            /**
             * যদি slug এ "/" থাকে তাহলে split করবো
             */
            if (str_contains($rawSlug, '/')) {

                $parts = explode('/', $rawSlug, 2);

                $path = $parts[0];
                $slug = $parts[1];

            } else {

                $path = $rawPath;
                $slug = $rawSlug;
            }

            /**
             * slug empty হলে title থেকে generate
             */
            if (empty($slug)) {
                $slug = $titleValue;
            }

            $pathTranslations[$lang] = $this->slugPreserveCase($path);
            $slugTranslations[$lang] = $this->slugPreserveCase($slug);
        }

        $story->setTranslations('slug', $slugTranslations);
        $story->reportpath = $pathTranslations;
        $story->campaign_id = $request->campaign_id;
        $story->category_id = $request->category_id;

        $story->sub_title = $request->sub_title;
        $story->description = $request->description;
        $story->short_description = $request->short_description;
        $story->seo_title = $request->seo_title;
        $story->meta_description = $request->meta_description;
        $story->tags = $request->tags;

        $story->footer_title = $request->footer_title;
        $story->footer_subtitle = $request->footer_subtitle;
        $story->footer_button_link = $request->footer_button_link;

        $story->status = $request->status;
        $story->position = $request->position  ?? 0;
        $story->addedby_id = $request->user_id  ?? auth()->id();
        $story->published_at = !empty($request->published_at) ? Carbon::parse($request->published_at) : null;

        // ✅ image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_story_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('story_image/' . $fileName, File::get($file));
            $story->image = $fileName;
        }
        $story->image_url =  Str::slug($request->image_url);


        if ($request->hasFile('footer_image2')) {
            $file = $request->file('footer_image2');
            $fileName = time() . '_story_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('story_image/' . $fileName, File::get($file));
            $story->footer_image2 = $fileName;
        }
        $story->footer_image_url = Str::slug($request->footer_image_url);

        $story->save();

        return redirect()->route('stories.index')->with('success', 'Story stored successfully!');
    
    }

    private function slugPreserveCase(string $value): string
    {
        $value = trim($value);
        $value = preg_replace('/[\s_]+/u', '-', $value);
        $value = preg_replace('/[^A-Za-z0-9\-]/u', '', $value);
        $value = preg_replace('/-+/', '-', $value);
        return trim($value, '-');
    }

    public function updateInlineUrl(Request $request, Story $story)
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

        /*
        |--------------------------------------------------------------------------
        | Save localization data
        |--------------------------------------------------------------------------
        | নিচের অংশটা তোমার project structure অনুযায়ী adjust করতে হতে পারে।
        | কারণ আমি ধরেছি getDirectValue() দিয়ে data পড়ছো, তাই setTranslation()
        | বা json column usage থাকতে পারে।
        |--------------------------------------------------------------------------
        */

        // Example if path and slug are translatable json fields:
        $pathData = is_array($story->reportpath) ? $story->reportpath : (json_decode($story->reportpath, true) ?: []);
        $slugData = is_array($story->slug) ? $story->slug : (json_decode($story->slug, true) ?: []);

        $pathData[$locale] = $path;
        $slugData[$locale] = $slug;

        $story->reportpath = $pathData;
        $story->slug = $slugData;
        $story->save();

        return response()->json([
            'status' => true,
            'message' => 'Page URL updated successfully.',
            'path' => $path,
            'slug' => $slug,
            'full_url' => $path . '/' . $slug,
            'display_url' => 'sai.ngo/' . $path . '/' . $slug,
        ]);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Story $story)
    public function show($id)
    {
        $story = Story::findOrFail($id);
        
        return view('admin.story.show', compact('story'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Story $story)
    {
        $campaigns = Campaign::get();
        $author = User::get();
        $categories = Category::get();
        return view('admin.story.edit',compact('campaigns', 'story', 'author', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Story $story)
    {
        // dd($request->all());

        $titleInput = $request->input('title', []);
$slugInput  = $request->input('slug', []);
$pathInput  = $request->input('reportpath', []);

$existingTitle = $story->getTranslations('title');
$existingSlug  = $story->getTranslations('slug');
$existingPath  = $story->getTranslations('reportpath');

$defaultPaths = [
    'en' => 'project',
    'es' => 'proyecto',
];

/**
 * -----------------------------
 * TITLE translations
 * -----------------------------
 */
$titleTranslations = [];

foreach (['en','es'] as $lang) {

    $titleTranslations[$lang] = $this->pickTranslatedValue(
        $titleInput,
        $lang,
        $existingTitle[$lang] ?? ''
    );
}

$story->setTranslations('title', $titleTranslations);


/**
 * -----------------------------
 * PATH + SLUG translations
 * -----------------------------
 */

$pathTranslations = [];
$slugTranslations = [];

foreach (['en','es'] as $lang) {

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

    /**
     * slug এ "/" থাকলে split করবো
     */
    if (str_contains($rawSlug, '/')) {

        $parts = explode('/', $rawSlug, 2);

        $path = $parts[0];
        $slug = $parts[1];

    } else {

        $path = $rawPath;
        $slug = $rawSlug;
    }

    /**
     * slug empty হলে title থেকে generate
     */
    if (empty($slug)) {
        $slug = $titleValue;
    }

    /**
     * slug sanitize
     */
    $slug = $this->slugPreserveCase($slug);

    /**
     * path sanitize
     */
    $path = $this->slugPreserveCase($path);

    $pathTranslations[$lang] = $path;
    $slugTranslations[$lang] = $slug;
}

$story->setTranslations('reportpath', $pathTranslations);
$story->setTranslations('slug', $slugTranslations);
        $story->campaign_id = $request->campaign_id;
        $story->category_id = $request->category_id;

        $story->sub_title = $request->sub_title;
        $story->description = $request->description;
        $story->short_description = $request->short_description;
        $story->seo_title = $request->seo_title;
        $story->meta_description = $request->meta_description;
        $story->tags = $request->tags;

        $story->footer_title = $request->footer_title;
        $story->footer_subtitle = $request->footer_subtitle;
        $story->footer_button_link = $request->footer_button_link;

        $story->status = $request->status;
        $story->position = $request->position  ?? 0;
        $story->addedby_id = $request->user_id  ?? auth()->id();
        $story->published_at = !empty($request->published_at) ? Carbon::parse($request->published_at) : null;

        // ✅ image replace
        if ($request->hasFile('image')) {
            if ($story->image && Storage::disk('public')->exists('story_image/' . $story->image)) {
                Storage::disk('public')->delete('story_image/' . $story->image);
            }

            $file = $request->file('image');
            $fileName = time() . '_story_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('story_image/' . $fileName, File::get($file));
            $story->image = $fileName;
        }

        if ($request->hasFile('footer_image2')) {
            if ($story->footer_image2 && Storage::disk('public')->exists('story_image/' . $story->footer_image2)) {
                Storage::disk('public')->delete('story_image/' . $story->footer_image2);
            }

            $file = $request->file('footer_image2');
            $fileName = time() . '_story_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('story_image/' . $fileName, File::get($file));
            $story->footer_image2 = $fileName;
        }

        $story->editedby_id = auth()->id();
        $story->save();

        return redirect()->route('stories.index')->with('success', 'Story updated successfully!');
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



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        
        if ($story->image &&
            Storage::disk('public')->exists('story_image/'.$story->image)) {
            Storage::disk('public')->delete('story_image/'.$story->image);
        }

        $story->delete();

        return redirect()->back()->with('success', 'Story deleted updated successfully!');
    }

    
    public function bulkDeleteStories(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || count($ids) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No items selected'
            ]);
        }

        // 🔥 First get all stories
        $stories = Story::whereIn('id', $ids)->get();

        foreach ($stories as $story) {
            // ✅ Image unlink
            if ($story->image && Storage::disk('public')->exists('story_image/'.$story->image)) {
                Storage::disk('public')->delete('story_image/'.$story->image);
            }

            // ✅ Delete record
            $story->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Selected stories deleted successfully!'
        ]);
    }

    public function toggleStatus(Story $story)
    {
        $statuses = ['published', 'draft'];
        $currentIndex = array_search($story->status, $statuses);

        $nextStatus = $statuses[($currentIndex + 1) % count($statuses)];

        $story->update([
            'status' => $nextStatus
        ]);

        return back()->with('success', 'Status updated successfully!');
    }

}
