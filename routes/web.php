<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Models\WebsiteSetting;

use App\Http\Controllers\MiniCampaignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OurValueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\GuestChatController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\WebsiteSettingController;
use App\Http\Controllers\SubscribeEmailController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Auth / Profile
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthenticatedSessionController::class, 'adminLogin'])->name('admin.login')->middleware('guest');
Route::redirect('/project/hospitals', '/project/help-venezuelan-hospitals-supplying-food-and-medicine', 301);
Route::redirect('/project/hospitals/', '/project/help-venezuelan-hospitals-supplying-food-and-medicine', 301);
Route::redirect('/about', '/about-us', 301);
Route::redirect('/about/', '/about-us', 301);
Route::redirect('/usa/help-venezuela/', '/project/help-venezuela', 301);
Route::redirect('/usa/help-venezuela', '/project/help-venezuela', 301);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Main
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/menus', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu-items/store', [MenuController::class, 'storeItem']);
    Route::post('/menu-items/update', [MenuController::class, 'updateItem']);
    Route::post('/menu-items/delete', [MenuController::class, 'deleteItem']);
    Route::post('/menu-items/save-order', [MenuController::class, 'saveOrder']);

    Route::resource('admin/roles', RoleController::class);
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/permissions', PermissionController::class);

    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('admin/google_analytics', [WebsiteSettingController::class, 'google_analytics'])->name('admin.google_analytics');
    Route::get('admin/google_console', [WebsiteSettingController::class, 'google_console'])->name('admin.google_console');
    Route::get('admin/sitemap/xml/form', [WebsiteSettingController::class, 'sitemapForm'])->name('admin.sitemapForm');
    Route::get('admin/tag/manager/form', [WebsiteSettingController::class, 'tag_manager_form'])->name('admin.tag_manager_form');

    Route::resource('admin/sliders', SliderController::class);
    Route::patch('admin/sliders/{slider}/toggle-status', [SliderController::class, 'toggleStatus'])->name('sliders.toggleStatus');

    Route::get('admin/website/setting', [WebsiteSettingController::class, 'edit'])->name('websitesetting');
    Route::post('admin/website/setting/update/{setting}', [WebsiteSettingController::class, 'update'])->name('setting.update');

    Route::get('admin/website/sitemap', [WebsiteSettingController::class, 'sitemap'])->name('sitemap.index');
    Route::post('admin/sitemap/sitemap/{setting}', [WebsiteSettingController::class, 'sitemapUpdate'])->name('setting.sitemap.update');

    Route::resource('admin/sponsors', SponsorController::class);
    Route::resource('admin/values', OurValueController::class);
    Route::resource('admin/reviews', ReviewController::class);

    /*
    |--------------------------------------------------------------------------
    | Admin Pages / Campaigns
    |--------------------------------------------------------------------------
    */

    Route::delete('/admin/delete-image/{id}', [CampaignController::class, 'deleteImage'])->name('admin.delete.image');

    Route::get('admin/page', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('admin/page/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('admin/page/store', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('admin/page/show/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
    Route::get('admin/page/{campaign}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('admin/page/update/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('admin/page/destroy/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');

    Route::get('admin/mini-campaign', [CampaignController::class, 'miniCampaignIndex'])->name('campaigns.miniCampaignIndex');
    Route::get('admin/mini-campaign/create', [CampaignController::class, 'miniCampaignCreate'])->name('campaigns.miniCampaignCreate');
    Route::post('admin/mini-campaign/store', [CampaignController::class, 'miniCampaignStore'])->name('campaigns.miniCampaignStore');
    Route::get('admin/mini-campaign/show/{id}', [CampaignController::class, 'miniCampaignShow'])->name('campaigns.miniCampaignShow');
    Route::get('admin/mini-campaign/{id}/edit', [CampaignController::class, 'miniCampaignEdit'])->name('campaigns.miniCampaignEdit');
    Route::put('admin/mini-campaign/update/{id}', [CampaignController::class, 'miniCampaignUpdate'])->name('campaigns.miniCampaignUpdate');
    Route::delete('admin/mini-campaign/destroy/{id}', [CampaignController::class, 'miniCampaignDestroy'])->name('campaigns.miniCampaignDestroy');

    Route::delete('admin/slogan/destroy/{id}', [CampaignController::class, 'sloganDelete'])->name('sloganDelete');
    Route::get('/export-users', [CampaignController::class, 'exportUsers'])->name('export');

    /*
    |--------------------------------------------------------------------------
    | Admin Blog / Stories
    |--------------------------------------------------------------------------
    */

    Route::get('admin/blog', [StoryController::class, 'index'])->name('stories.index');
    Route::get('admin/blog/create', [StoryController::class, 'create'])->name('stories.create');
    Route::post('admin/blog/store', [StoryController::class, 'store'])->name('stories.store');
    Route::get('admin/blog/show/{story}', [StoryController::class, 'show'])->name('stories.show');
    Route::get('admin/blog/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
    Route::put('admin/blog/{story}/update', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('admin/blog/{story}/delete', [StoryController::class, 'destroy'])->name('stories.destroy');
    Route::patch('admin/story/{story}/toggle-status', [StoryController::class, 'toggleStatus'])->name('story.toggleStatus');
    Route::post('admin/stories/bulk-delete', [StoryController::class, 'bulkDeleteStories'])->name('stories.bulk-delete');

    Route::post('/story/{story}/update-inline-url', [StoryController::class, 'updateInlineUrl'])->name('story.update.inline.url');
    /*
    |--------------------------------------------------------------------------
    | Admin Campaign Gallery
    |--------------------------------------------------------------------------
    */

    Route::post('admin/campaigns/bulk-delete', [CampaignController::class, 'bulkDelete'])->name('campaigns.bulk-delete');

    Route::get('admin/campaign-gallery', [CampaignController::class, 'galleryindex'])->name('campaign.gallery.index');
    Route::get('admin/campaign-gallery/{campaign}', [CampaignController::class, 'galleryedit'])->name('campaign.gallery.edit');
    Route::post('admin/campaign-gallery/{campaign}/upload', [CampaignController::class, 'gallerystore'])->name('campaign.gallery.store');
    Route::post('admin/campaign-gallery/{campaign}/reorder', [CampaignController::class, 'galleryreorder'])->name('campaign.gallery.reorder');
    Route::delete('admin/campaign-gallery/{campaign}/delete/{img}', [CampaignController::class, 'gallerydestroy'])->name('campaign.gallery.destroy');
    Route::put('/campaigns/{campaign}/gallery/{gallery}', [CampaignController::class, 'galleryUpdate'])->name('campaign.gallery.update');
    Route::patch('admin/campaigns/{campaign}/toggle-status', [CampaignController::class, 'toggleStatus'])->name('campaigns.toggleStatus');

    Route::get('admin/campaigns/gallery-image', [CampaignController::class, 'deleteGalleryImage'])->name('admin.campaign.gallery.delete');

    Route::post('/campaign/{campaign}/update-inline-url', [CampaignController::class, 'updateInlineUrl'])->name('campaign.update.inline.url');

    Route::get('admin/media', [AdminController::class, 'media'])->name('admin.media');
    Route::get('admin/pages', [AdminController::class, 'pages'])->name('admin.pages');
});

/*
|--------------------------------------------------------------------------
| Admin Prefixed
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/media', [MediaController::class, 'index'])->name('admin.media.index');
    Route::post('/media/folder', [MediaController::class, 'createFolder'])->name('admin.media.folder.create');
    Route::post('/media/upload', [MediaController::class, 'upload'])->name('admin.media.upload');
    Route::post('/media/move', [MediaController::class, 'move'])->name('admin.media.move');
    Route::delete('/media/item', [MediaController::class, 'delete'])->name('admin.media.delete');
    Route::get('/media/item/{type}/{id}', [MediaController::class, 'show'])->name('admin.media.show');

    Route::post('/settings/notify-sound', [WebsiteSettingController::class, 'notifySound']);

    Route::resource('categories', CategoryController::class);
    Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory'])->name('updateCategory');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'categoriesDestroy'])->name('categoriesDestroy');

    Route::get('/database', [DatabaseController::class, 'index'])->name('admin.database.index');
    Route::get('/breadindex', [DatabaseController::class, 'breadindex'])->name('admin.database.breadindex');
    Route::get('/database/table/{table}', [DatabaseController::class, 'show'])->name('admin.database.show');
    Route::delete('/database/table/{table}', [DatabaseController::class, 'destroy'])->name('admin.database.destroy');

    Route::get('/subscribers/list', [AdminController::class, 'subscriberList'])->name('admin.subscriberList');
    Route::delete('/subscriber/delete/{id}', [AdminController::class, 'subscriberDelete'])->name('subscribers.destroy');

    Route::get('/contactmessage/list', [AdminController::class, 'contactMessage'])->name('admin.contactMessage');
    Route::delete('/contactmessagedestry/{id}', [AdminController::class, 'contactMessageDestry'])->name('admin.contactMessageDestry');
    
    Route::post('sitemap/generate', [WebsiteSettingController::class, 'generateSitemap'])->name('admin.sitemap.generate');

    Route::post('sitemap/upload', [SitemapController::class, 'upload']);
    
    Route::post('/mini-campaign/preview/store', [MiniCampaignController::class, 'storePreview'])
    ->name('campaigns.miniCampaignPreview.store');

    /*
    |--------------------------------------------------------------------------
    | Admin Chat
    |--------------------------------------------------------------------------
    */

    Route::get('/chat', [AdminChatController::class, 'index'])->name('admin.chat.index');
    Route::get('/chat/threads', [AdminChatController::class, 'threads'])->name('admin.chat.threads');
    Route::get('/chat/fetch/{thread}', [AdminChatController::class, 'fetch'])->name('admin.chat.fetch');
    Route::post('/chat/send/{thread}', [AdminChatController::class, 'send'])->name('admin.chat.send');
    Route::post('/chat/notify/read-thread/{thread}', [AdminChatController::class, 'readThread'])->name('admin.chat.notify.readThread');

    /*
    |--------------------------------------------------------------------------
    | Admin Gallery Share
    |--------------------------------------------------------------------------
    */

    Route::get('/gallery/share/{id}', [HomeController::class, 'share'])->name('gallery.share');

    /*
    |--------------------------------------------------------------------------
    | Admin Languages
    |--------------------------------------------------------------------------
    */

    Route::get('languages', [LanguageController::class, 'languages'])->name('admin.languages');
    Route::get('language/create', [LanguageController::class, 'languageCreate'])->name('admin.languageCreate');
    Route::post('language/store', [LanguageController::class, 'languageStore'])->name('admin.languageStore');
    Route::get('language/edit/{language}', [LanguageController::class, 'languageEdit'])->name('admin.languageEdit');
    Route::post('language/update/{language}', [LanguageController::class, 'languageUpdate'])->name('admin.languageUpdate');
    Route::post('language/delete/{language}', [LanguageController::class, 'languageDelete'])->name('admin.languageDelete');
    Route::post('language/status', [LanguageController::class, 'languageStatus'])->name('admin.languageStatus');

    Route::get('translations', [LanguageController::class, 'translations'])->name('admin.translations');
    Route::post('translation/store', [LanguageController::class, 'translationStore'])->name('admin.translationStore');
    Route::get('language/translations/{language}', [LanguageController::class, 'languageTranslatoins'])->name('admin.languageTranslatoins');
    Route::post('language/translation/value/store', [LanguageController::class, 'languageTranslateValueStore'])->name('admin.languageTranslateValueStore');
    Route::get('language/translation/search/ajax', [LanguageController::class, 'languageTranlationSearchAjax'])->name('admin.languageTranlationSearchAjax');
});

Route::get('/admin/mini-campaign/preview/{token}', [MiniCampaignController::class, 'showPreview'])
    ->name('campaigns.miniCampaignPreview.show');

/*
|--------------------------------------------------------------------------
| Public Static / Core Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'indexes'])->name('homees');
Route::get('/es/home', [HomeController::class, 'indexes'])->name('homeEs');

// About
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/es/nosotros', [HomeController::class, 'aboutUs'])->name('aboutUsEs');

// Projects list
Route::get('/projects', [HomeController::class, 'campaigns'])->name('campaigns');
Route::get('/es/proyecto', [HomeController::class, 'campaigns'])->name('campaignsEs');

// Contact
Route::get('/contact', [HomeController::class, 'contactUs'])->name('contactUs');
Route::get('/es/contacto', [HomeController::class, 'contactUs'])->name('contactUsEs');

// News
Route::get('/news/{slug?}', [HomeController::class, 'news'])->name('news');
Route::get('/es/news/{slug?}', [HomeController::class, 'news'])->name('newsEs');

// Blog / Reports
Route::get('/report/{slug}', [HomeController::class, 'blogDetails'])->name('blogDetails');
Route::get('/es/informe/{slug}', [HomeController::class, 'blogDetails'])->name('blogDetailsEs');

// Other pages
Route::get('/how-to-donate-cryptocurrency-to-help-venezuela', [HomeController::class, 'donateCripto'])->name('donateCripto');
Route::get('/es/como-donar-criptomonedas', [HomeController::class, 'donateCripto'])->name('donateCriptoEs');

Route::get('/how-employees-of-fortune-500-companies-can-help-venezuela', [HomeController::class, 'doubleDonation'])->name('doubleDonation');
Route::get('/es/voluntariado', [HomeController::class, 'doubleDonation'])->name('doubleDonationEs');

Route::get('/donor-advised-funds-donations-daf-venezuelan', [HomeController::class, 'dafDonation'])->name('dafDonation');
Route::get('/es/fondos-asesorados-para-donantes', [HomeController::class, 'dafDonation'])->name('dafDonationEs');

Route::get('/donation', [HomeController::class, 'donation'])->name('donation');
Route::get('/es/donations', [HomeController::class, 'donation'])->name('donationEs');

Route::get('/mini-campaign/{slug}', [HomeController::class, 'miniCampaign'])->name('miniCampaign');
Route::get('/es/mini-campaign/{slug}', [HomeController::class, 'miniCampaign'])->name('miniCampaignEs');


/*
|--------------------------------------------------------------------------
| Public Forms / Actions
|--------------------------------------------------------------------------
*/

Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe.store');
Route::post('/contact-send', [HomeController::class, 'contactMessage'])->name('contact.send');
Route::post('/donate', [HomeController::class, 'donate'])->name('donate');

Route::post('/newsletter/subscribe', [SubscribeEmailController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [SubscribeEmailController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::post('/language/status/{language}/{campaign_slug?}', [HomeController::class, 'languageUpdateStatus'])->name('languageUpdateStatus');

Route::middleware('auth')->group(function () {
    Route::post('/admin/campaign-gallery/migrate-old-data', [HomeController::class, 'migrate'])->name('campaign.gallery.migrate.old');
});

/*
|--------------------------------------------------------------------------
| Public Image / Gallery Routes
|--------------------------------------------------------------------------
| Specific image routes should stay before generic dynamic routes
*/

// Campaign gallery image
Route::get('/gallery-image/{campaignSlug}/{imageSlug}.{ext}', [HomeController::class, 'showUrlByCampaignAndSlug'])
    ->where(['ext' => 'jpg|jpeg|png|webp'])
    ->name('gallery.image');

// Story images
Route::get('/report/{reportSlug}/footer/{imageSlug}.{ext}', [HomeController::class, 'showStoryFooterImage'])
    ->where([
        'imageSlug' => '.*',
        'ext' => 'jpg|jpeg|png|webp',
    ])
    ->name('gallery.image.story.footer');

Route::get('/report/{reportSlug}/{imageSlug}.{ext}', [HomeController::class, 'showStoryImage'])
    ->where([
        'imageSlug' => '.*',
        'ext' => 'jpg|jpeg|png|webp',
    ])
    ->name('gallery.image.story');

// Gallery details
Route::get('/gallery/{slug}', [HomeController::class, 'galleryImageDetails'])->name('gallery.image.details');
Route::get('/es/galería/{slug}', [HomeController::class, 'galleryImageDetails'])->name('gallery.image.detailsEs');

/*
|--------------------------------------------------------------------------
| Public Sitemap
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', function () {
    $setting = WebsiteSetting::first();

    abort_if(!$setting || !$setting->sitemap_file, 404);

    $path = 'sitemap_file/' . $setting->sitemap_file;

    abort_unless(Storage::disk('public')->exists($path), 404);

    $xml = Storage::disk('public')->get($path);

    return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap.public');

/*
|--------------------------------------------------------------------------
| Utility
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');

    if (!file_exists(public_path('storage'))) {
        Artisan::call('storage:link');
    }

    return 'Laravel cache & routes cleared successfully';
});

/*
|--------------------------------------------------------------------------
| Guest Chat
|--------------------------------------------------------------------------
*/

Route::prefix('chat')->group(function () {
    Route::post('/send', [GuestChatController::class, 'send'])->name('guest.chat.send');
    Route::get('/fetch', [GuestChatController::class, 'fetch'])->name('guest.chat.fetch');
});

/*
|--------------------------------------------------------------------------
| Legacy Static Project Detail Routes
|--------------------------------------------------------------------------
| Keep only if you still need backward compatibility
*/

//Route::get('/project/{slug}', [HomeController::class, 'campaignsdetails'])->name('campaignsdetails');
//Route::get('/es/project/{slug}', [HomeController::class, 'campaignsdetails'])->name('campaignsdetailsEs');

/*
|--------------------------------------------------------------------------
| Dynamic Campaign Detail Routes
|--------------------------------------------------------------------------
| Keep these LAST to avoid conflicts
*/

require __DIR__ . '/auth.php';

Route::get('/es/{path}/{slug}', [HomeController::class, 'campaignsdetails'])
    ->where([
        'path' => '[a-zA-Z0-9\-_]+',
        'slug' => '^(?!.*\.(jpg|jpeg|png|webp)$)[a-zA-Z0-9\-_]+$',
    ])
    ->name('campaignsdetailsEsDyn');

Route::get('/{path}/{slug}', [HomeController::class, 'campaignsdetails'])
    ->where([
        'path' => '^(?!es$|reset-password$)[a-zA-Z0-9\-_]+$',
        'slug' => '^(?!.*\.(jpg|jpeg|png|webp)$)[a-zA-Z0-9\-_]+$',
    ])
    ->name('campaignsdetailsDyn');