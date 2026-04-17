<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Language;
use App\Models\MiniCampaignTemplate;
use App\Models\Story;
use App\Models\SubscribeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\CampaignGalleryImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class HomeController extends Controller
{
    public function getHomeData()
    {
        return [
            'sliders' => \App\Models\Slider::latest()->get(),
            'campaigns' => \App\Models\Campaign::orderBy('home_order', 'desc')->where('status', 'published')->where('show_home_page', 'active')->take(3)->get(),
            'certifications' => \App\Models\Sponsor::where('type', 'certifications')->latest()->get(),
            'reviews' => \App\Models\Review::latest()->take(10)->get(['name', 'description', 'image', 'profile_image']),
        ];
    }

    public function indexes()
    {
        return view('frontend.home', $this->getHomeData());
    }

    public function indexesEs()
    {
        return view('frontend.home', $this->getHomeData());
    }

    public function aboutUs()
    {
        return view('frontend.about_us');
    }

    public function campaigns(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $campaigns = \App\Models\Campaign::query()
            ->where('status', 'published')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('sub_title', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('frontend.campaigns', compact('campaigns', 'q'));
    }



    public function contactUs() 
    {
        return view('frontend.contact_us');
    }

    /*public function news(Request $request)
    {
        $categorySlug = $request->query('category'); // ?category=ID (আপনার কোড অনুযায়ী)
        $q            = $request->query('q');        // ?q=search

        // Top 6 category buttons
       $categories = Category::orderByRaw('`order` IS NULL, `order` ASC')->where('status', 1)->take(8)->get();


        // ✅ Base story query (ONLY published)
        $query = Story::query()
            ->where('status', 'published')
            ->with(['user','category'])
            ->latest();

        // Filter by clicked category (optional)
        $activeCategory = null;
        if (!empty($categorySlug)) {
            $activeCategory = Category::where('id', $categorySlug)->first();
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        // Search filter (optional)
        if (!empty($q)) {
            $query->where(function ($s) use ($q) {
                $s->where('title', 'like', "%{$q}%")
                ->orWhere('seo_title', 'like', "%{$q}%");
            });
        }

        // TOP sections
        $featured = (clone $query)->take(1)->get();
        $side     = (clone $query)->skip(1)->take(4)->get();

        // ✅ CATEGORY-WISE STORY LIST (ONLY published)
        $categoryWise = Category::query()
            ->when($activeCategory, fn($c) => $c->where('id', $activeCategory->id))
            ->with(['stories' => function ($s) use ($q) {
                $s->where('status', 'published')  // ✅ here
                ->with('user')
                ->latest();

                if (!empty($q)) {
                    $s->where(function ($x) use ($q) {
                        $x->where('title', 'like', "%{$q}%")
                        ->orWhere('seo_title', 'like', "%{$q}%");
                    });
                }

                $s->take(9);
            }])
            ->latest()
            ->get();

        // ✅ related stories (ONLY published) + per category 1
        $related_stories = Story::query()
            ->where('status', 'published')
            ->with(['user','category'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('category_id')
            ->values();

        return view('frontend.news', compact(
            'categories',
            'featured',
            'side',
            'categoryWise',
            'activeCategory',
            'related_stories'
        ));
    }*/
    
    public function news(Request $request)
{
    $categoryId = $request->query('category');
    $search     = trim((string) $request->query('q', ''));

    // Top category buttons
    $categories = Category::query()
        ->where('status', 1)
        ->orderByRaw('`order` IS NULL, `order` ASC')
        ->take(8)
        ->get();

    // Active category
    $activeCategory = null;
    if (!empty($categoryId)) {
        $activeCategory = Category::query()
            ->where('id', $categoryId)
            ->first();
    }


    // Base published stories query
    $baseQuery = Story::query()
        ->where('status', 'published')
        ->with(['user', 'category'])
        ->when($activeCategory, function ($query) use ($activeCategory) {
            $query->where('category_id', $activeCategory->id);
        })
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('seo_title', 'like', "%{$search}%"); 
            });
        })
        ->latest();

    // Top sections
    $featured = (clone $baseQuery)->take(1)->get();
    $side     = (clone $baseQuery)->skip(1)->take(4)->get();

    // Category-wise stories
    $categoryWise = Category::query()
        ->when($activeCategory, function ($query) use ($activeCategory) {
            $query->where('id', $activeCategory->id);
        })
        ->with([
            'stories' => function ($storyQuery) use ($search) {
                $storyQuery->where('status', 'published')
                    ->with('user')
                    ->when($search !== '', function ($query) use ($search) {
                        $query->where(function ($subQuery) use ($search) {
                            $subQuery->where('title', 'like', "%{$search}%")
                                ->orWhere('seo_title', 'like', "%{$search}%");
                        });
                    })
                    ->latest()
                    ->take(9);
            }
        ])
        ->orderByRaw('`order` IS NULL, `order` ASC')
        ->latest()
        ->get();

    $relatedStories = Story::where('status', 'published')
        ->with(['user', 'category'])
        ->whereRaw('id IN (
            SELECT MAX(id) FROM stories
            WHERE status = "published"
            GROUP BY category_id
        )')
        ->get();

    // Related stories: latest one per category
    $recentStories = Story::query()
        ->where('status', 'published')
        ->with(['user', 'category'])
        ->latest('created_at')
        ->take(6)
        ->get()
        ->values();
        
        if (!$activeCategory && !$request->filled('category')) {
        $activeCategory = Category::query()
            ->where('order', '1')
            ->where('status', 1)
            ->first();
            $categoryId = $activeCategory->id;
    } 

    return view('frontend.news', [
        'categories'       => $categories,
        'featured'         => $featured,
        'side'             => $side,
        'categoryWise'     => $categoryWise,
        'activeCategory'   => $activeCategory,
        'related_stories'  => $relatedStories,
        'recent_articles'  => $recentStories,
        'search'           => $search,
        'categoryId'       => $categoryId,
    ]);
}

    
public function campaignsdetails($path, $slug)
{
    $locale = app()->getLocale();

    $path = trim((string) $path);
    $slug = trim((string) $slug);

    $campaign = Campaign::where(function ($q) use ($slug) {
            $q->where('slug->en', $slug)
              ->orWhere('slug->es', $slug);
        })
        ->where('status', 'published')
        ->firstOrFail();

    $validPaths = array_filter([
        $campaign->getTranslation('path', 'en', false),
        $campaign->getTranslation('path', 'es', false),
    ]);

    if (!in_array($path, $validPaths, true)) {
        abort(404);
    }

    $currentPath = $campaign->getTranslation('path', $locale, false)
        ?: $campaign->getTranslation('path', 'en', false);

    $currentSlug = $campaign->getTranslation('slug', $locale, false)
        ?: $campaign->getTranslation('slug', 'en', false);

    $currentPath = is_string($currentPath) ? trim($currentPath) : '';
    $currentSlug = is_string($currentSlug) ? trim($currentSlug) : '';

    if ($currentPath === '' || $currentSlug === '') {
        abort(404);
    }

    $isSpanishRoute = request()->routeIs('campaignsdetailsEsDyn');

    $expectedRoute = $isSpanishRoute ? 'campaignsdetailsEsDyn' : 'campaignsdetailsDyn';

    if ($path !== $currentPath || $slug !== $currentSlug) {
        return redirect()->route($expectedRoute, [
            'path' => $currentPath,
            'slug' => $currentSlug,
        ], 301);
    }

    $campaign->increment('view_count');

    return view('frontend.campaign_details', compact('campaign'));
}





    public function blogDetails($slug)
    {
        if (request()->routeIs('blogDetailsEs')) {
            $language = (object) ['language_code' => 'es'];
        } else {
            $language = (object) ['language_code' => 'en'];
        }
        
        // session এ locale save
        session()->put('locale', $language->language_code);
    
        // app locale set
        app()->setLocale($language->language_code);
    
        $locale = $language->language_code;

        $story = Story::where("slug->$locale", $slug)->orWhere("slug->en", $slug)->firstOrFail();

        // dd($story->view_count);
        $story->increment('view_count');

        $relatedStories = Story::where('id', '!=', $story->id)->where('status', 'published')->take(3)->get();

        return view('frontend.blog_details', compact('story', 'relatedStories'));
    }


    public function donateCripto()
    {
        return view('frontend.donate_in_cripto'); 
    }
    public function doubleDonation()
    {
        $campaigns = Campaign::where('status', 'published')->take(3)->get();
        return view('frontend.double_donation', compact('campaigns'));
    }
    public function dafDonation()
    {
        return view('frontend.daf_donation');
    }

    public function donation()
    {
        $donation_campaigns = MiniCampaignTemplate::where('status', 1)->latest()->first();

        return view('frontend.donation', compact('donation_campaigns'));
    }

    public function miniCampaign(Request $request, $slug)
    {
        $locale = app()->getLocale();
        $cam = MiniCampaignTemplate::where("slug->$locale", $slug)->orWhere("slug->en", $slug)->firstOrFail();

        return view('frontend.mini_campaign', compact('cam'));
    }

    public function showUrlByCampaignAndSlug($campaignSlug, $imageSlug, $ext)
    {
        $locale = app()->getLocale();

        $campaign = Campaign::query()
            ->where("slug->$locale", $campaignSlug)
            ->orWhere('slug->en', $campaignSlug)
            ->firstOrFail();

        $img = CampaignGalleryImage::where('campaign_id', $campaign->id)
            ->where('slug', $imageSlug)
            ->firstOrFail();

        $path = 'gallery_image/' . $img->image;
        abort_unless(Storage::disk('public')->exists($path), 404);

        // 👉 real extension বের করো
        $realExt = strtolower(pathinfo($img->image, PATHINFO_EXTENSION));

        // 👉 URL ext ভুল হলে correct ext এ 301 redirect
        if ($realExt && $realExt !== strtolower($ext)) {
            return redirect()->route('gallery.image', [
                'campaignSlug' => $campaignSlug,
                'imageSlug'    => $imageSlug,
                'ext'          => $realExt,
            ], 301);
        }



        return response()->file(Storage::disk('public')->path($path), [
            'Cache-Control' => 'public, max-age=31536000',
            'Content-Type'  => \Illuminate\Support\Facades\File::mimeType(
                Storage::disk('public')->path($path)
            ),
        ]);
    }



public function showStoryImage($reportSlug, $imageSlug, $ext)
{
    $locale = app()->getLocale();
    $ext = strtolower($ext);

    // 1) Find story by slug (json locale / en / plain string fallback)
    $story = \App\Models\Story::query()
        ->where(function ($q) use ($locale, $reportSlug) {
            $q->where("slug->$locale", $reportSlug)
              ->orWhere("slug->en", $reportSlug)
              ->orWhere('slug', $reportSlug);
        })
        ->firstOrFail();

    // 2) Resolve filename from DB (image column)
    $fileName = ltrim((string) $story->image, '/');

    // If DB already contains folder, avoid double folder
    $fileName = preg_replace('#^story_image/#', '', $fileName);

    $path = 'story_image/' . $fileName;

    abort_unless(Storage::disk('public')->exists($path), 404);

    $fullPath = Storage::disk('public')->path($path);

    // 3) Extension check & redirect to correct ext (301)
    $realExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION) ?: 'jpg');

    if ($realExt && $realExt !== $ext) {
        return redirect()->route('gallery.image.story', [
            'reportSlug' => $reportSlug,
            'imageSlug'  => $imageSlug,
            'ext'        => $realExt,
        ], 301);
    }

    // 4) Serve file
    $mime = File::mimeType($fullPath) ?: 'image/' . ($realExt ?: 'jpeg');

    return response()->file($fullPath, [
        'Cache-Control' => 'public, max-age=31536000, immutable',
        'Content-Type'  => $mime,
    ]);
}



public function showStoryFooterImage($reportSlug, $imageSlug, $ext)
{
    $locale = app()->getLocale();
    $ext = strtolower($ext);

    // 1) Find story by slug (json locale / en / plain string)
    $story = \App\Models\Story::query()
        ->where(function ($q) use ($locale, $reportSlug) {
            $q->where("slug->$locale", $reportSlug)
              ->orWhere("slug->en", $reportSlug)
              ->orWhere('slug', $reportSlug);
        })
        ->firstOrFail();

    // 2) Footer image filename from DB
    $fileName = ltrim((string) $story->footer_image2, '/');

    abort_if(empty($fileName), 404);

    // If db already includes folder, avoid double folder
    // আপনার footer ফোল্ডার যদি story_image হয়, এটায় রাখুন
    // যদি আলাদা হয় (e.g. footer_image) তাহলে সেটা দিন
    $folder = 'story_image';

    $fileName = preg_replace('#^' . preg_quote($folder, '#') . '/#', '', $fileName);
    $path = $folder . '/' . $fileName;

    abort_unless(Storage::disk('public')->exists($path), 404);

    $fullPath = Storage::disk('public')->path($path);

    // 3) Real ext বের করে ext mismatch হলে 301 redirect
    $realExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION) ?: 'jpg');

    if ($realExt && $realExt !== $ext) {
        return redirect()->route('gallery.image.story.footer', [
            'reportSlug' => $reportSlug,
            'imageSlug'  => $imageSlug,
            'ext'        => $realExt,
        ], 301);
    }

    // 4) (Optional) imageSlug mismatch হলে canonical slug এ redirect
    if (!empty($story->footer_image_url) && $story->footer_image_url !== $imageSlug) {
        return redirect()->route('gallery.image.story.footer', [
            'reportSlug' => $reportSlug,
            'imageSlug'  => $story->footer_image_url,
            'ext'        => $realExt,
        ], 301);
    }

    // 5) Serve
    $mime = File::mimeType($fullPath) ?: 'image/' . ($realExt ?: 'jpeg');

    return response()->file($fullPath, [
        'Cache-Control' => 'public, max-age=31536000, immutable',
        'Content-Type'  => $mime,
    ]);
}


    public function subscribe(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|unique:subscribe_emails,email',
            ],
            [
                'email.required' => 'Please enter your email address.',
                'email.email'    => 'Please enter a valid email address.',
                'email.unique'   => 'This email is already subscribed. Thank you for staying with us!',
            ]
        );

        SubscribeEmail::create([
            'email' => $request->email,
        ]);

        return redirect()->back()->with(
            'success',
            '🎉 Thank you for subscribing! You’ll now receive our latest updates.'
        );
    }


    public function contactMessage(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:150',
            'message' => 'required|string',
        ]);

        // ✅ Save to DB
        ContactMessage::create($validated);

        // ✅ Send Email
        Mail::to(config('mail.from.address'))
            ->send(new ContactMail($validated));

        return back()->with('success','Message sent successfully!');
    }


    /*public function languageUpdateStatus(Request $request, Language $language,  $slug = null)
    {
        session()->put('locale', $language->language_code);


        if ($slug) {
             $currentSlug = $slug 
                        ?? $request->input('slug') 
                        ?? $request->input('campaign_slug') 
                        ?? $request->segment(count($request->segments())) 
                        ?? 'home';



            $supported = ['en', 'es']; 

           
            $campaignQuery = Campaign::query();
            foreach ($supported as $lang) {
                $campaignQuery->orWhere("slug->$lang", $currentSlug);
            }
            $campaign = $campaignQuery->first();

            if ($campaign) {
                $newSlug = $campaign->getTranslation('slug', $language->language_code, false)
                    ?: $campaign->getTranslation('slug', 'en');
                    
                $newPath = $campaign->getTranslation('path', $language->language_code, false)
                    ?: $campaign->getTranslation('path', 'en');
                    
                if(session('locale', config('app.locale')) === 'es'){
                    return redirect()->route('campaignsdetailsEsDyn',  [$newPath, $newSlug]);
                }else{
                    return redirect()->route('campaignsdetailsDyn',  [$newPath, $newSlug]);
                }
                // dd($newSlug);
                // return redirect()->route(session('locale', config('app.locale')) === 'es' ? route('campaignsdetailsEs', $newSlug) : route('campaignsdetails', $newSlug));
                
            }
            
            $storyQuery = Story::query();
            foreach ($supported as $lang) {
                $storyQuery->orWhere("slug->$lang", $currentSlug);
            }
            $story = $storyQuery->first();

            if ($story) {
                $newSlug = $story->getTranslation('slug', $language->language_code, false)
                    ?: $story->getTranslation('slug', 'en');

                if(session('locale', config('app.locale')) === 'es'){
                    return redirect()->route('blogDetailsEs', $newSlug);
                }else{
                    return redirect()->route('blogDetails', $newSlug);
                }

                // return redirect()->route('blogDetails', ['slug' => $newSlug]); 
                // ⬆️ তোমার story details route name যেটা, সেটা বসাও 
            }


            $locale = session('locale', config('app.locale')); // 'en' or 'es'

            // dd($currentSlug);
            // যেসব path থেকে redirect করবেন সেগুলোর route map
            $routes = [
                'home'           => ['en' => 'homees',           'es' => 'homeEs'],

                'about'          => ['en' => 'aboutUs',         'es' => 'aboutUsEs'],
                'nosotros'          => ['en' => 'aboutUs',         'es' => 'aboutUsEs'],

                'campaigns'      => ['en' => 'campaigns',       'es' => 'campaignsEs'],
                'proyecto'      => ['en' => 'campaigns',       'es' => 'campaignsEs'],

                'contact'        => ['en' => 'contactUs',       'es' => 'contactUsEs'],
                'contacto'        => ['en' => 'contactUs',       'es' => 'contactUsEs'],

                'news'           => ['en' => 'news',            'es' => 'newsEs'],
                'news'           => ['en' => 'news',            'es' => 'newsEs'],

                'how-to-donate-cryptocurrency-to-help-venezuela'  => ['en' => 'donateCripto',    'es' => 'donateCriptoEs'],
                'como-donar-criptomonedas'  => ['en' => 'donateCripto',    'es' => 'donateCriptoEs'],

                'how-employees-of-fortune-500-companies-can-help-venezuela'=> ['en' => 'doubleDonation',  'es' => 'doubleDonationEs'],
                'voluntariado'=> ['en' => 'doubleDonation',  'es' => 'doubleDonationEs'],

                'donor-advised-funds-donations-daf-venezuelan'   => ['en' => 'dafDonation',     'es' => 'dafDonationEs'],
                'fondos-asesorados-para-donantes'   => ['en' => 'dafDonation',     'es' => 'dafDonationEs'],

                'donation'       => ['en' => 'donation',        'es' => 'donationEs'],
                'donar'       => ['en' => 'donation',        'es' => 'donationEs'],
            ];

           

            // locale যদি en/es ছাড়া অন্য কিছু হয়, default en ধরুন
            $locale = in_array($locale, ['en', 'es']) ? $locale : 'en';

            // $path যদি map এ না থাকে, fallback home
            $routeName = $routes[$currentSlug][$locale] ?? $routes['home'][$locale];

            return redirect()->route($routeName);
       
        }

        return back();
    }*/
    
   public function languageUpdateStatus(Request $request, Language $language, $slug = null)
{
    $locale = $language->language_code;

    // only support en / es
    $locale = in_array($locale, ['en', 'es']) ? $locale : 'en';

    session()->put('locale', $locale);
    app()->setLocale($locale);

    /*
    |--------------------------------------------------------------------------
    | Admin / backend request হলে same page এ back করবে
    |--------------------------------------------------------------------------
    */
    if ($request->is('admin/*') || str_contains(url()->previous(), '/admin/')) {
        return back();
    }

    /*
    |--------------------------------------------------------------------------
    | Current slug detect
    |--------------------------------------------------------------------------
    */
    $currentSlug = $slug
        ?? $request->input('slug')
        ?? $request->input('campaign_slug')
        ?? $request->segment(count($request->segments()))
        ?? 'home';

    $currentSlug = is_string($currentSlug) ? trim($currentSlug) : 'home';

    $supported = ['en', 'es'];

    /*
    |--------------------------------------------------------------------------
    | 1. Campaign খোঁজো
    |--------------------------------------------------------------------------
    */
    $campaign = Campaign::where(function ($q) use ($supported, $currentSlug) {
        foreach ($supported as $lang) {
            $q->orWhere("slug->$lang", $currentSlug);
        }
    })->first();

    if ($campaign) {
        $newSlug = $campaign->getTranslation('slug', $locale, false)
            ?: $campaign->getTranslation('slug', 'en', false);

        $newPath = $campaign->getTranslation('path', $locale, false)
            ?: $campaign->getTranslation('path', 'en', false);

        $newSlug = is_string($newSlug) ? trim($newSlug) : '';
        $newPath = is_string($newPath) ? trim($newPath) : '';

        if ($newPath !== '' && $newSlug !== '') {
            return redirect()->route(
                $locale === 'es' ? 'campaignsdetailsEsDyn' : 'campaignsdetailsDyn',
                ['path' => $newPath, 'slug' => $newSlug]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Story খোঁজো
    |--------------------------------------------------------------------------
    */
    $story = Story::where(function ($q) use ($supported, $currentSlug) {
        foreach ($supported as $lang) {
            $q->orWhere("slug->$lang", $currentSlug);
        }
    })->first();

    if ($story) {
        $newSlug = $story->getTranslation('slug', $locale, false)
            ?: $story->getTranslation('slug', 'en', false);

        $newSlug = is_string($newSlug) ? trim($newSlug) : '';

        if ($newSlug !== '') {
            return redirect()->route(
                $locale === 'es' ? 'blogDetailsEs' : 'blogDetails',
                ['slug' => $newSlug]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Static page map
    |--------------------------------------------------------------------------
    */
    $routes = [
        'home' => [
            'en' => 'homees',
            'es' => 'homeEs',
        ],

        'about' => [
            'en' => 'aboutUs',
            'es' => 'aboutUsEs',
        ],
        'nosotros' => [
            'en' => 'aboutUs',
            'es' => 'aboutUsEs',
        ],

        'campaigns' => [
            'en' => 'campaigns',
            'es' => 'campaignsEs',
        ],
        'projects' => [
            'en' => 'campaigns',
            'es' => 'campaignsEs',
        ],
        'proyecto' => [
            'en' => 'campaigns',
            'es' => 'campaignsEs',
        ],

        'contact' => [
            'en' => 'contactUs',
            'es' => 'contactUsEs',
        ],
        'contacto' => [
            'en' => 'contactUs',
            'es' => 'contactUsEs',
        ],

        'news' => [
            'en' => 'news',
            'es' => 'newsEs',
        ],

        'how-to-donate-cryptocurrency-to-help-venezuela' => [
            'en' => 'donateCripto',
            'es' => 'donateCriptoEs',
        ],
        'como-donar-criptomonedas' => [
            'en' => 'donateCripto',
            'es' => 'donateCriptoEs',
        ],

        'how-employees-of-fortune-500-companies-can-help-venezuela' => [
            'en' => 'doubleDonation',
            'es' => 'doubleDonationEs',
        ],
        'voluntariado' => [
            'en' => 'doubleDonation',
            'es' => 'doubleDonationEs',
        ],

        'donor-advised-funds-donations-daf-venezuelan' => [
            'en' => 'dafDonation',
            'es' => 'dafDonationEs',
        ],
        'fondos-asesorados-para-donantes' => [
            'en' => 'dafDonation',
            'es' => 'dafDonationEs',
        ],

        'donation' => [
            'en' => 'donation',
            'es' => 'donationEs',
        ],
        'donar' => [
            'en' => 'donation',
            'es' => 'donationEs',
        ],
    ];

    $routeName = $routes[$currentSlug][$locale] ?? $routes['home'][$locale];

    return redirect()->route($routeName);
}



    public function galleryImageDetails($slug)
    {
        $locale = app()->getLocale();
        $image = CampaignGalleryImage::where('slug', $slug)->firstOrFail();
        return view('frontend.gallery_image_details', compact('image'));
    }

    public function migrate()
    {
        $oldStories = DB::table('old_campaigns')->get();

        foreach ($oldStories as $old) {

            // Insert new campaign
            $campaign = Campaign::create([
                'id' => $old->id, // optional, only if you want to preserve old IDs
                'title' => [
                    'en' => $old->title,
                    'es' => null,
                ],
                'sub_title' => [
                    'en' => $old->sub_title ?? $old->subtitle ?? null,
                    'es' => null,
                ],
                'summary' => [
                    'en' => $old->summary ?? null,
                    'es' => null,
                ],
                'standard_webpage_content' => [
                    'en' => $old->standard_webpage_content ?? null,
                    'es' => null,
                ],
                'problem' => [
                    'en' => $old->problem ?? null,
                    'es' => null,
                ],
                'solution' => [
                    'en' => $old->solution ?? null,
                    'es' => null,
                ],
                'impact' => [
                    'en' => $old->impact ?? null,
                    'es' => null,
                ],
                'google_description' => [
                    'en' => $old->google_description ?? null,
                    'es' => null,
                ],
                'short_description' => [
                    'en' => $old->short_description ?? null,
                    'es' => null,
                ],
                'donorbox_code' => [
                    'en' => $old->donorbox_code ?? null,
                    'es' => null,
                ],
                'video' => [
                    'en' => $old->video ?? null,
                    'es' => null,
                ],
                'seo_title' => [
                    'en' => $old->seo_title ?? null,
                    'es' => null,
                ],
                'seo_description' => [
                    'en' => $old->seo_description ?? null,
                    'es' => null,
                ],

                'slug' => $old->slug ?? null,
                'type' => $old->type ?? 'default',
                'status' => $old->status ?? 'draft',
                'published_at' => $old->published_at ?? null,
                'hero_image' => $old->hero_image ?? null,
                'addedby_id' => $old->addedby_id ?? null,
                'editedby_id' => $old->editedby_id ?? null,
                'created_at' => $old->created_at ?? now(),
                'updated_at' => $old->updated_at ?? now(),
            ]);
        }

        return redirect()->back()->with(
                'success',
                'Old campaign gallery data migrated successfully!'
            );
    }

}
