


<?php $__env->startSection('title', $campaign->seo_title); ?>
<?php $__env->startSection('meta_description', $campaign->seo_description); ?>
<?php $__env->startSection('meta_keyword',  $campaign->meta_keyword ?? translate('Home page meta keyword')); ?>
 
<?php $__env->startSection('meta'); ?>
<?php

  $desc  = $campaign->seo_description ?? strip_tags($campaign->short_description ?? $campaign->sub_title ?? '');

  // limit (SEO best practice)
  $title = \Illuminate\Support\Str::limit($campaign->seo_title ?? $campaign->title ?? 'Campaign', 60, '');
  $desc  = \Illuminate\Support\Str::limit($desc, 160, '');

  $locale = session('locale', config('app.locale'));
  $url = $locale === 'es'
      ? route('campaignsdetailsEsDyn', ['path' => $campaign->path, 'slug' => $campaign->slug])
      : route('campaignsdetailsDyn', ['path' => $campaign->path, 'slug' => $campaign->slug]);

  $ogImage = $campaign->og_image
      ? asset('storage/og_image/'.$campaign->og_image)
      : ($campaign->hero_image
          ? asset('storage/hero_image/'.$campaign->hero_image)
          : asset('storage/logo/'.($setting->logo ?? 'default-logo.jpg')));
?>

<?php echo $__env->make('frontend.seo.campaign_details', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<link rel="canonical" href="<?php echo e($url); ?>"> 


<link rel="alternate" hreflang="<?php echo e(app()->getLocale()); ?>" href="<?php echo e($url); ?>"> 
<link rel="alternate" hreflang="x-default" href="<?php echo e($url); ?>">


<meta property="og:site_name" content="South American Initiative">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($desc); ?>">
<meta property="og:url" content="<?php echo e($url); ?>">
<meta property="og:image" content="<?php echo e($ogImage); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:secure_url" content="<?php echo e($ogImage); ?>">
<meta property="og:locale" content="<?php echo e(app()->getLocale()); ?>">


<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($desc); ?>">
<meta name="twitter:image" content="<?php echo e($ogImage); ?>">


<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('frontend'); ?>

<!-- ========= EXTRA CSS FOR TABS ========= -->
<style>
    .tab-active   { background:#e54545; color:#ffffff; }
    .tab-inactive { background:#f1f1f1; color:#d3564f; }
</style>




<section id="top" class="pt-4 pb-10 bg-[#f5f5f5]- -mt-10 md:-mt-36 relative z-0">
  <div class="relative rounded-sm overflow-hidden shadow-lg bg-no-repeat bg-cover bg-center
              transform-gpu- will-change-transform-
              transition-transform- ease-in-out- duration-[2000ms]-
              hover:scale-[1.08]- hover:z-10"
       style="background-image: url('<?php echo e(asset('storage/hero_image/'.$campaign->hero_image)); ?>'); height: 600px;">
    <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-[2fr,1fr] gap-6"></div>


    <img
    src="<?php echo e(asset('storage/hero_image/'.$campaign->hero_image)); ?>"
    alt="<?php echo e($campaign->title); ?>" title="<?php echo e($campaign->title); ?>"
    class="sr-only"
  />

    <!-- ✅ HARD AT LEFT-BOTTOM, FADES UPWARD -->
<div class="absolute inset-0 pointer-events-none"
     style="
        background: radial-gradient(
          120% 120% at left bottom,
          rgba(217,70,71,0.95) 0%,
          rgba(217,70,71,0.70) 22%,
          rgba(217,70,71,0.45) 40%,
          rgba(217,70,71,0.22) 58%,
          rgba(217,70,71,0.10) 70%,
          rgba(217,70,71,0.00) 85%
        );
     ">
</div>


<!-- <div class="absolute left-0 bottom-0 w-full h-full pointer-events-none"
     style="
        background: radial-gradient(circle at left bottom,
          rgba(217,70,71,0.92) 0%,
          rgba(217,70,71,0.45) 35%,
          rgba(217,70,71,0.00) 70%
        );
        clip-path: polygon(0 100%, 0 0, 55% 100%);
     ">
</div> -->


  </div>
</section>



 
<section class="pb-5- -mt-48 relative z-10">
    
    <div class="max-w-7xl md:mx-auto md:px-4- grid lg:grid-cols-[3fr,1fr] gap-6 my-3">
        <div class="">
             <?php 
            $slogan = $campaign->slogans;
            ?>

            <?php $__currentLoopData = $slogan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="shrink-0 px-6 py-1 font-semibold rounded-tr-lg rounded-bl-lg mr-3"
                    style="background-color: <?php echo e($item->slogan_bg_color ?? 'black'); ?>; color: <?php echo e($item->slogan_text_color ?? 'white'); ?>;">
                        <?php echo e($item->slogan_title); ?>

            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="max-w-7xl md:mx-auto md:px-4- grid lg:grid-cols-[3fr,1fr] gap-6">

    
        
        
        <article class="overflow-visible space-y-6 mainDiv">
           

            
           <!-- ✅ RESPONSIVE CARD (desktop + mobile like screenshot) -->
            <div class="bg-white shadow-md border border-gray-200 overflow-hidden
                        mx-5- md:mx-0 rounded-[4px]">

                <!-- TOP RED HEADER -->
                <div class="relative bg-[#D94647] text-white px-5 md:px-8 py-3 overflow-hidden">
                    <h1 class="text-[22px] sm:text-[26px] md:text-[34px] lg:text-[40px]  font-bold uppercase leading-tight">
                    <?php echo e(\Illuminate\Support\Str::limit($campaign->title ?? '', 100)); ?>

                    </h1>

                    <!-- right ribbon (blue + yellow) -->
                    <div class="absolute -top-6 right-0 h-28 w-24 pointer-events-none"> 
                    <div class="absolute inset-y-0 right-4 w-6 bg-[#2261aa]
                            skew-x-[42deg]">
                        </div>

                        <div class="absolute inset-y-0 right-0 w-5 bg-[#fff0a1]
                            skew-x-[42deg]">
                        </div>
                    </div>
                </div>

                <!-- BODY -->
                <div class="px-5 md:px-8 pt-5 pb-6">

                    <!-- ✅ MOBILE: Donate button under header (only mobile) -->
                   <a href="javascript:void(0)"
                    class="lg:hidden w-full block text-center mb-4 border border-[#f3b6b6] bg-[#fff1f1] text-[#D94647] font-semibold uppercase tracking-[0.10em] py-3 rounded-[2px] hiddenBtnClick">
                    <?php echo e(translate('Donate Refugees')); ?>

                    </a>



                    <?php
                        $icons = App\Models\Sponsor::where('type', 'certifications')->latest()->get();
                    ?>

                    <div class="flex flex-wrap items-center gap-4 md:gap-6 mb-4 text-[12px] text-gray-700 justify-center md:justify-start">
                        <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button"
                        class="flex items-center gap-2 focus:outline-none"
                        onmouseenter="openCertModal(this,
                            <?php echo \Illuminate\Support\Js::from($icon->title ?? $icon->company_name ?? 'Certified')->toHtml() ?>,
                            <?php echo \Illuminate\Support\Js::from($icon->sub_title ?? '')->toHtml() ?>,
                            <?php echo \Illuminate\Support\Js::from($icon->content ?? '')->toHtml() ?>,
                            <?php echo \Illuminate\Support\Js::from($icon->website_link ?? '')->toHtml() ?>,
                            <?php echo \Illuminate\Support\Js::from(asset('storage/company_logo/'.$icon->company_logo))->toHtml() ?>  
                        )"
                        onmouseleave="scheduleCloseCertModal()"
                    >
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-200 overflow-hidden">
                            <img
                                src="<?php echo e(asset('storage/campaign_icon/'.$icon->campaign_icon)); ?>"
                                alt="<?php echo e($icon->title ?? $icon->company_name ?? 'Certification'); ?>"  title="<?php echo e($icon->title ?? $icon->company_name ?? 'Certification'); ?>"
                                class="w-full h-full object-contain p-1">
                        </span>

                        <span class="hidden sm:block font-medium text-gray-700">
                            <?php echo e($icon->title ?? $icon->company_name ?? 'Certified'); ?>

                        </span>

                    </button>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- TITLE -->
                    <h2 class="text-[22px] sm:text-[26px] md:text-[30px] font-semibold leading-tight text-[#3e3e3e]">
                    <?php echo $campaign->sub_title; ?>

                    </h2> 

                    <!-- TEXT -->
                    <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">
                   <?php echo $campaign->short_description; ?>

                    </p>


                </div>
            </div>

            <?php echo $__env->make('frontend.includes.campaign_det_img', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


            
            <div class="bg-white shadow-md border border-gray-200 md:mx-5 md:mx-0 lg:mx-0">

                
                <div class="flex text-xs font-semibold uppercase tracking-[0.18em]">
                    <button class="tab-btn flex-1 text-center px-6 py-3 border-r border-white tab-active"
                            data-tab-btn="story">
                         <?php echo e(translate('Story')); ?> 
                    </button>
                    <button class="tab-btn flex-1 text-center px-6 py-3 border-r border-white tab-inactive"
                            data-tab-btn="gallery">
                         <?php echo e(translate('Gallery')); ?> 
                    </button>
                    <button class="tab-btn flex-1 text-center px-6 py-3 tab-inactive"
                            data-tab-btn="reports">
                         <?php echo e(translate('Reports')); ?> 
                    </button>
                </div>

                
                <div class="tab-panel px-8 py-8 text-gray-700 space-y-6 bg-[#fafafa]"
                     data-tab-panel="story">
                     <?php if(!empty($campaign->summary)): ?>
                    <section>
                        <h3 class="font-semibold text-3xl mb-3 text-gray-800">
                             <?php echo e(translate('Summary')); ?> 
                        </h3>
                        <p class="text-1xl md:text-1xl text-gray-500">
                            <?php echo $campaign->summary; ?>

                        </p>
                        
                    </section>
                    <?php endif; ?>


                    <section class="grid md:grid-cols-[2.2fr,1.1fr] gap-3 items-stretch mt-4">
                        <div class="relative bg-gray-200 h-56 md:h-64 overflow-hidden rounded-sm">
                            <?php $__currentLoopData = $campaign->galleryImages->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // title JSON হলে locale অনুযায়ী text বের করো
                                    $title = $galItem->title;
                                    if (is_string($title)) {
                                        $d = json_decode($title, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                                            $title = $d[app()->getLocale()] ?? ($d['en'] ?? reset($d));
                                        }
                                    } elseif (is_array($title)) {
                                        $title = $title[app()->getLocale()] ?? ($title['en'] ?? reset($title));
                                    }

                                    $seoSlug =
                                        $galItem->slug ?:
                                        \Illuminate\Support\Str::slug($title ?: 'gallery-' . $galItem->id);
                                    $ext = pathinfo($galItem->image, PATHINFO_EXTENSION) ?: 'jpg';
                                ?>
                                <img 
                                    src="<?php echo e(route('gallery.image', [
                                'campaignSlug' => $campaign->slug['en'] ?? $campaign->slug,
                                'imageSlug' => $galItem->slug,
                                'ext' => $ext,
                            ])); ?>" class="w-full h-full object-cover"  alt="<?php echo e($galItem->alt_text ?? $galItem->title ?? 'Gallery Image'); ?>" title="<?php echo e($galItem->title ?? $galItem->alt_text ?? 'Gallery Image'); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>  


                        <div class="grid grid-rows-3 gap-2 h-56 md:h-64">
                            
                            <?php $__currentLoopData = $campaign->galleryImages->skip(1)->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                // title JSON হলে locale অনুযায়ী text বের করো
                                $title = $galItem->title;
                                if (is_string($title)) {
                                    $d = json_decode($title, true);
                                    if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                                        $title = $d[app()->getLocale()] ?? ($d['en'] ?? reset($d));
                                    }
                                } elseif (is_array($title)) {
                                    $title = $title[app()->getLocale()] ?? ($title['en'] ?? reset($title));
                                }

                                $seoSlug =
                                    $galItem->slug ?:
                                    \Illuminate\Support\Str::slug($title ?: 'gallery-' . $galItem->id);
                                $ext = pathinfo($galItem->image, PATHINFO_EXTENSION) ?: 'jpg';
                            ?>
                            <img src="<?php echo e(route('gallery.image', [
                                'campaignSlug' => $campaign->slug['en'] ?? $campaign->slug,
                                'imageSlug' => $galItem->slug,
                                'ext' => $ext,
                            ])); ?>" class="w-full h-full object-cover rounded-sm" alt="<?php echo e($galItem->alt_text ?? $galItem->title ?? 'Gallery Image'); ?>" title="<?php echo e($galItem->title ?? $galItem->alt_text ?? 'Gallery Image'); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             
                        </div>
                    </section>

                    

                    <?php if(!empty($campaign->video)): ?>
                    <section class="w-full flex justify-center">
                        <div class="w-full max-w-7xl">
                            <div class="relative w-full aspect-video overflow-hidden rounded-lg">
                                <?php echo $campaign->video; ?>

                            </div>
                        </div>
                    </section>
                    <style>
                    /* embed করা iframe/video কে wrapper-এর ভিতরে ফুল ফিট করাবে */
                    section .aspect-video iframe,
                    section .aspect-video video {
                        position: absolute !important;
                        inset: 0 !important;
                        width: 100% !important;
                        height: 100% !important;
                    }
                    </style>
                    <?php endif; ?>


                    

                    <?php if(!empty($campaign->standard_webpage_content)): ?>
                        <section class="space-y-2 prose max-w-none">
                            <?php echo $campaign->standard_webpage_content; ?>

                        </section>
                    <?php endif; ?>

                    <?php if(!empty($campaign->problem)): ?>
                        <section class="space-y-2 prose max-w-none">
                            <?php echo $campaign->problem; ?>

                        </section>
                    <?php endif; ?>

                    <?php if(!empty($campaign->solution)): ?>
                        <section class="space-y-2 prose max-w-none">
                            <?php echo $campaign->solution; ?>

                        </section>
                    <?php endif; ?>

                    <?php if(!empty($campaign->impact)): ?>
                        <section class="space-y-2 prose max-w-none">
                            <?php echo $campaign->impact; ?>

                        </section>
                    <?php endif; ?>

                </div>

                
                

                
                <div class="tab-panel px-8 py-8 bg-[#fafafa] hidden" data-tab-panel="gallery">
                    <h3 class="font-semibold text-3xl mb-6 text-gray-800">Gallery</h3>

                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        <?php $__currentLoopData = $campaign->galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $galItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                // title JSON হলে locale অনুযায়ী text বের করো
                                $title = $galItem->title;
                                if (is_string($title)) {
                                    $d = json_decode($title, true);
                                    if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                                        $title = $d[app()->getLocale()] ?? ($d['en'] ?? reset($d));
                                    }
                                } elseif (is_array($title)) {
                                    $title = $title[app()->getLocale()] ?? ($title['en'] ?? reset($title));
                                }

                                $seoSlug =
                                    $galItem->slug ?:
                                    \Illuminate\Support\Str::slug($title ?: 'gallery-' . $galItem->id);
                                $ext = pathinfo($galItem->image, PATHINFO_EXTENSION) ?: 'jpg';
                            ?>

                            <img src="<?php echo e(route('gallery.image', [
                                'campaignSlug' => $campaign->slug['en'] ?? $campaign->slug,
                                'imageSlug' => $galItem->slug,
                                'ext' => $ext,
                            ])); ?>"
                                class="gallery-thumb" alt="<?php echo e($galItem->alt_text ?? $galItem->title ?? 'Gallery Image'); ?>" title="<?php echo e($galItem->title ?? $galItem->alt_text ?? 'Gallery Image'); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>

                <?php
                // ✅ Send src + title + description to JS
                $galleryItems = $campaign->galleryImages->map(function ($g) use ($campaign) {

                    // title JSON হলে locale অনুযায়ী text বের করো
                    $title = $g->title;
                    if (is_string($title)) {
                        $d = json_decode($title, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                            $title = $d[app()->getLocale()] ?? ($d['en'] ?? reset($d));
                        }
                    } elseif (is_array($title)) {
                        $title = $title[app()->getLocale()] ?? ($title['en'] ?? reset($title));
                    }

                    // slug fallback (যদি DB slug খালি থাকে)
                    $seoSlug = $g->slug ?: \Illuminate\Support\Str::slug($title ?: 'gallery-' . $g->id);

                    // image extension
                    $ext = pathinfo($g->image, PATHINFO_EXTENSION) ?: 'jpg';

                    return [
                        'src' => route('gallery.image', [
                            'campaignSlug' => is_array($campaign->slug) ? ($campaign->slug['en'] ?? reset($campaign->slug)) : $campaign->slug,
                            'imageSlug'    => $seoSlug, // ✅ same idea as foreach
                            'ext'          => $ext,
                        ]),
                        'slug'          => $g->slug,
                        'title'          => $title ?? '',
                        'alt_text'          => $g->alt_text ?? $title ?? 'Gallery Image',
                        'caption'        => $g->caption ?? '',
                        'description'    => $g->description ?? '',
                        'campaign_title' => optional($g->campaign)->title ?? '',
                    ];
                })->values();
            ?>


                <?php echo $__env->make('frontend.includes.gallery_light_box', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


                
                <div class="tab-panel px-8 py-8 bg-[#fafafa] space-y-6 hidden"
                     data-tab-panel="reports">
                    <h3 class="font-semibold text-3xl mb-6 text-gray-800">
                         <?php echo e(translate('Project Stories')); ?> 
                    </h3>
                    <div class="grid md:grid-cols-2 gap-5">
                       
                        <?php $__currentLoopData = $campaign->stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="bg-white shadow border border-gray-200 flex flex-col">
                                <div class="h-40 bg-gray-200">
                                    <img src="<?php echo e(asset('storage/story_image/'.$story->image)); ?>"
                                         class="w-full h-full object-cover" alt="<?php echo e($story->title ?? 'Story Image'); ?>" title="<?php echo e($story->title ?? 'Story Image'); ?>">
                                </div>
                                <div class="p-4 flex-1 flex flex-col">
                                    <h4 class="font-semibold text-sm mb-2 text-gray-800">
                                        <?php echo e(\Illuminate\Support\Str::limit($story->title ?? '', 40)); ?>

                                    </h4>
                                    <p class="text-[13px] text-gray-500 flex-1 mb-3">
                                        <?php echo e(\Illuminate\Support\Str::limit($story->seo_title ?? '', 200)); ?>

                                    </p>
                                    <div class="flex items-center justify-between text-[11px] text-gray-400 mb-3">
                                        <span><?php echo e($story->created_at->format('j M Y')); ?></span>
                                        <span>by <?php echo e($story->user->name ?? ''); ?></span>
                                    </div>
                                    <a href="<?php echo e(route('blogDetails', $story->slug)); ?>"
                                        class="mt-auto inline-flex items-center justify-center px-4 py-2 text-[11px] font-bold uppercase bg-[#f04848] text-white rounded-sm">
                                         <?php echo e(translate('Read more')); ?>  &gt;
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>
                </div>

                
                <section class="hidden md:block mt-8 ">
                    <div class="max-w-5xl mx-auto">
                        <article
                            class="flex flex-col md:flex-row rounded-[10px] overflow-hidden shadow-[0_20px_45px_rgba(0,0,0,0.18)]">

                            <!-- LEFT: TEXT SIDE -->
                            <div class="w-full md:w-1/2 bg-[#f04848] text-white px-8 py-8 flex flex-col justify-center">
                                <p class="text-xs font-semibold uppercase tracking-[0.03em] mb-4">
                                     <?php echo e($campaign->footer_title); ?> 
                                </p> 

                                <h3 class="text-xl md:text-2xl font-semibold leading-snug tracking-[0.03em] uppercase">
                                    <?php echo $campaign->footer_subtitle; ?> 
                                </h3>

                                <a  href="<?php echo e($campaign->footer_button_link); ?>" class="mt-6 inline-flex items-center justify-center bg-white text-[#f04848]
                                        px-8 py-1 text-[11px] font-extrabold uppercase tracking-[0.03em]
                                        rounded-sm shadow-md">
                                     <?php echo e(translate('Donate to this project')); ?>  &gt;
                                </a> 
                            </div>


                            <!-- RIGHT: IMAGE SIDE -->
                            <div class="relative w-full md:w-1/2 h-52 md:h-auto">
                                <img src="<?php echo e(asset('storage/hero_image/'.$campaign->hero_image)); ?>" alt="<?php echo e($setting->title); ?>" title="<?php echo e($setting->title); ?>" class="w-full h-full object-cover">

                                <!-- soft red overlay যেন ইমেজ একটু ফেইড লাগে -->
                                <div class="absolute inset-0 bg-[#f04848]/30"></div>

                                <!-- top-right multi-color ribbon -->
                                <div class="absolute -top-6 right-0 w-16 h-16 overflow-hidden"> 
                                    <!-- ribbon main bar -->
                                    <div
                                        class="absolute -right-4 -top-4 h-24 w-6
                                            bg-gradient-to-b from-[#ffcf34] via-[#0047ab] to-[#ff3b3b]
                                            shadow-[0_4px_10px_rgba(0,0,0,0.35)]">
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
            </div>
        </article>

        
        <?php echo $__env->make('frontend.includes.donate_box', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div>
</section>

    <div class="py-5"> 
      <?php echo $__env->make('frontend.includes.scroll_element', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>

<!-- ========= JAVASCRIPT FOR TABS + SIDEBAR ========= -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons    = document.querySelectorAll('[data-tab-btn]');
        const tabPanels     = document.querySelectorAll('[data-tab-panel]');
        const sidebarPanels = document.querySelectorAll('[data-sidebar-panel]');

        function activateTab(tabName) {
            // buttons
            tabButtons.forEach(btn => {
                const name = btn.getAttribute('data-tab-btn');
                if (name === tabName) {
                    btn.classList.add('tab-active');
                    btn.classList.remove('tab-inactive');
                } else {
                    btn.classList.remove('tab-active');
                    btn.classList.add('tab-inactive');
                }
            });

            // main content
            tabPanels.forEach(panel => {
                const name = panel.getAttribute('data-tab-panel');
                if (name === tabName) {
                    panel.classList.remove('hidden');
                } else {
                    panel.classList.add('hidden');
                }
            });

        }

        tabButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const tabName = this.getAttribute('data-tab-btn');
                activateTab(tabName);
            });
        });

        // default
        activateTab('story');
    });
</script>




<script>
  document.addEventListener('DOMContentLoaded', () => {

    // ---------- Steps ----------
    const form = document.getElementById('donationWizardForm');
    const steps = form ? form.querySelectorAll('.sidebar-step') : [];
    let currentStep = 1;

    function showStep(stepNo){
      steps.forEach(s => {
        const no = parseInt(s.dataset.step, 10);
        if(no === stepNo){
          s.classList.remove('hidden');
          s.style.display = '';
        }else{
          s.classList.add('hidden');
          s.style.display = 'none';
        }
      });
      currentStep = stepNo;
    }

    // Next/Prev buttons (global within wizard)
    form.addEventListener('click', (e) => {
      const next = e.target.closest('[data-next]');
      const prev = e.target.closest('[data-prev]');
      if(next){
        e.preventDefault();
        showStep(Math.min(currentStep + 1, 4));
      }
      if(prev){
        e.preventDefault();
        showStep(Math.max(currentStep - 1, 1));
      }
    });

    // Continue buttons
    const btnToStep2 = document.getElementById('btnToStep2');
    const btnToStep3 = document.getElementById('btnToStep3');

    if(btnToStep2){
      btnToStep2.addEventListener('click', (e) => {
        e.preventDefault();

        // if custom selected, validate input
        const mode = document.getElementById('amountMode').value;
        if(mode === 'custom'){
          const custom = form.querySelector('input[name="custom_amount"]');
          if(!custom.value || parseFloat(custom.value) <= 0){
            custom.focus();
            return;
          }
          document.getElementById('finalAmount').value = custom.value;
        }
        updateDonateButtonText();
        showStep(2);
      });
    }

    if(btnToStep3){
      btnToStep3.addEventListener('click', (e) => {
        e.preventDefault();
        updateDonateButtonText();
        showStep(3);
      });
    }

    // ---------- Amount selection + Custom Amount ----------
    const amountList = document.getElementById('amountList');
    const customCard = document.getElementById('customAmountCard');
    const customBox  = document.getElementById('customAmountBox');
    const finalAmount = document.getElementById('finalAmount');
    const amountMode  = document.getElementById('amountMode');

    function resetAmountUI(){
      amountList.querySelectorAll('.amount-item').forEach(el => {
        el.classList.remove('border-[#f04848]','bg-[#fff5f5]');
        if(!el.dataset.custom){
          el.classList.add('border-gray-300');
          el.classList.remove('bg-white');
        }
        const dot = el.querySelector('.dot');
        const fill = el.querySelector('.dotFill');
        if(dot){
          dot.classList.remove('border-[#f04848]');
          dot.classList.add('border-gray-400');
        }
        if(fill){
          fill.classList.add('hidden');
        }
      });
    }

    function setActive(el){
      resetAmountUI();

      el.classList.add('border-[#f04848]');
      el.classList.remove('border-gray-300');
      if(!el.dataset.custom){
        el.classList.add('bg-[#fff5f5]');
      }

      const dot = el.querySelector('.dot');
      const fill = el.querySelector('.dotFill');
      if(dot){
        dot.classList.add('border-[#f04848]');
        dot.classList.remove('border-gray-400');
      }
      if(fill){
        fill.classList.remove('hidden');
        fill.classList.add('bg-[#f04848]');
      }
    }

    if(amountList){
      amountList.addEventListener('click', (e) => {
        const item = e.target.closest('.amount-item');
        if(!item) return;

        // custom selected
        if(item.dataset.custom){
          setActive(item);
          amountMode.value = 'custom';
          customBox.classList.remove('hidden');
          customBox.style.display = '';
          // don't set finalAmount yet (from input)
          const customInput = form.querySelector('input[name="custom_amount"]');
          customInput.focus();
          updateDonateButtonText();
          return;
        }

        // preset selected
        setActive(item);
        amountMode.value = 'preset';
        customBox.classList.add('hidden');
        customBox.style.display = 'none';

        const amt = item.dataset.amount;
        finalAmount.value = amt;
        updateDonateButtonText();
      });
    }

    // custom input updates donate button text live
    const customInput = form.querySelector('input[name="custom_amount"]');
    if(customInput){
      customInput.addEventListener('input', () => {
        if(amountMode.value === 'custom'){
          if(customInput.value && parseFloat(customInput.value) > 0){
            finalAmount.value = customInput.value;
          }
          updateDonateButtonText();
        }
      });
    }

    // ---------- Payment Tabs (CARD/PAYPAL/BANK) ----------
    const payTabs = form.querySelectorAll('[data-paytab]');
    const payPanels = form.querySelectorAll('[data-paypanel]');

    function activatePayTab(name){
      payTabs.forEach(t => {
        const active = t.dataset.paytab === name;
        t.classList.toggle('bg-white/20', active);
      });

      payPanels.forEach(p => {
        if(p.dataset.paypanel === name){
          p.classList.remove('hidden');
          p.style.display = '';
        }else{
          p.classList.add('hidden');
          p.style.display = 'none';
        }
      });
    }

    payTabs.forEach(t => {
      t.addEventListener('click', (e) => {
        e.preventDefault();
        activatePayTab(t.dataset.paytab);
      });
    });

    // default pay tab
    activatePayTab('card');

    // ---------- Donate button text ----------
    const donateBtnText = document.getElementById('donateBtnText');
    function updateDonateButtonText(){
      const amt = parseFloat(finalAmount.value || '0');
      const nice = isNaN(amt) ? '0.00' : amt.toFixed(2);
      if(donateBtnText){
        donateBtnText.textContent = `Donate $${nice} One-time`;
      }
    }
    updateDonateButtonText();

    // default first step
    showStep(1);
  });
</script>



<script>
  document.addEventListener('DOMContentLoaded', () => {
    const companyField = document.getElementById('companyField');
    const donorRadios  = document.querySelectorAll('input[name="donor_type"]');

    function syncCompanyField(){
      const selected = document.querySelector('input[name="donor_type"]:checked')?.value;
      if(selected === 'company'){
        companyField.classList.remove('hidden');
        companyField.style.display = '';
      }else{
        companyField.classList.add('hidden');
        companyField.style.display = 'none';
      }
    }

    donorRadios.forEach(r => r.addEventListener('change', syncCompanyField));
    syncCompanyField();
  });
</script>



<script>
    window.__GALLERY_ITEMS__ = <?php echo json_encode($galleryItems, 15, 512) ?>;

    (function () {
        const items = window.__GALLERY_ITEMS__ || [];
        if (!items.length) return;

        const modal    = document.getElementById('galleryLightbox');
        const backdrop = document.getElementById('galleryBackdrop');
        const closeBtn = document.getElementById('closeGalleryBtn');

        const campaignTitleEl = document.getElementById('galleryCampaignTitle');
        const mainImg  = document.getElementById('galleryMainImage');
        const titleEl  = document.getElementById('galleryTitle');
        const altTextEl  = document.getElementById('galleryAltText');
        const captionEl  = document.getElementById('galleryCaption');
        const descEl   = document.getElementById('galleryDescription');
        const counter  = document.getElementById('galleryCounter');
        const detailsBtn = document.getElementById('galleryDetailsBtn');

        const prevBtn  = document.getElementById('prevGalleryBtn');
        const nextBtn  = document.getElementById('nextGalleryBtn');
        const thumbs   = document.getElementById('galleryThumbs');

        const shareBtn = document.getElementById('sharePhotoBtn');

        let index = 0;

        function renderThumbs() {
            thumbs.innerHTML = '';

            items.forEach((it, i) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = "flex-shrink-0";

                const active = (i === index)
                    ? 'ring-2 ring-blue-500'
                    : 'ring-1 ring-gray-200';

                btn.innerHTML = `
                    <img src="${it.src}"
                         class="h-14 w-20 object-cover rounded-sm ${active}"
                         alt="${it.title || ''}">
                `;

                btn.addEventListener('click', () => {
                    index = i;
                    update();
                });

                thumbs.appendChild(btn);
            });

            const activeThumb = thumbs.querySelector('img.ring-2');
            if (activeThumb) activeThumb.scrollIntoView({behavior:'smooth', inline:'center', block:'nearest'});
        }

        function update() {
            const it = items[index];
            mainImg.src = it.src;
            mainImg.alt = it.alt_text || it.title || '';
            if (captionEl) {
                captionEl.textContent = it.caption || '';
            }
            campaignTitleEl.slug = it.slug || '';
            campaignTitleEl.textContent = it.campaign_title || '';
            titleEl.textContent = it.title || '';
            descEl.textContent  = it.description || '';
            counter.textContent = `${index + 1} / ${items.length}`;
            // ✅ DETAILS BUTTON SHOW/HIDE
           if (detailsBtn) {
                if (it.slug && it.slug.trim() !== '') {
                    const locale = window.__CURRENT_LOCALE__ || 'en';
                    const galleryBase = window.__GALLERY_BASE__ || 'gallery';

                    // build multilingual gallery detail URL
                    let href = `/${galleryBase}/${it.slug}`;
                    if (locale !== 'en') {
                        href = `/${locale}/${galleryBase}/${it.slug}`;
                    }

                    detailsBtn.href = href;
                    detailsBtn.classList.remove('hidden');
                } else {
                    detailsBtn.classList.add('hidden');
                }
            }

            renderThumbs();
        }


        function open(start = 0) {
            index = Math.max(0, Math.min(start, items.length - 1));
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            update();
        }

        function close() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function prev() {
            index = (index - 1 + items.length) % items.length;
            update();
        }

        function next() {
            index = (index + 1) % items.length;
            update();
        }

        // Thumb click -> open
        document.querySelectorAll('.gallery-thumb').forEach(img => {
            img.addEventListener('click', () => {
                open(parseInt(img.dataset.galleryIndex, 10) || 0);
            });
        });

        // Close
        closeBtn.addEventListener('click', close);
        backdrop.addEventListener('click', close);

        // Prev/Next
        prevBtn.addEventListener('click', prev);
        nextBtn.addEventListener('click', next);

        // Keyboard
        document.addEventListener('keydown', (e) => {
            if (modal.classList.contains('hidden')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') prev();
            if (e.key === 'ArrowRight') next();
        });

        // Share (copy current image URL)
        if (shareBtn) {
            shareBtn.addEventListener('click', async () => {
                try {
                    const url = items[index]?.src || '';
                    await navigator.clipboard.writeText(url);
                    shareBtn.textContent = 'Copied!';
                    setTimeout(() => shareBtn.textContent = 'Share Photo', 1200);
                } catch (e) {
                    alert('Copy failed. Your browser may block clipboard.');
                }
            });
        }

    })();
</script>




<script>
let closeTimer = null;

function openCertModal(targetEl, title, subTitle, content, websiteLink, badgeUrl) {
  const modal = document.getElementById('certModal');
  const box   = document.getElementById('certModalBox');
  const arrow = document.getElementById('certModalArrow');

  // Fill content
  document.getElementById('certModalTitle').textContent = title || '';
  document.getElementById('certModalSubTitle').textContent = subTitle || '';
  document.getElementById('certModalContent').textContent = content || '';

  const badge = document.getElementById('certModalBadge');
  badge.src = badgeUrl || '';
  badge.alt = title || 'Certification';

  const link = document.getElementById('certModalLink');
  if (websiteLink && websiteLink.trim() !== '') {
    link.href = websiteLink;
    link.classList.remove('hidden');
  } else {
    link.href = '#';
    link.classList.add('hidden');
  }

  if (closeTimer) clearTimeout(closeTimer);

  // show
  modal.classList.remove('hidden');

  // ✅ reset animation every hover
  box.classList.remove('opacity-100','translate-y-0');
  box.classList.add('opacity-0','translate-y-2');

  // --- POSITIONING (✅ আগের মতো left aligned) ---
  const rect = targetEl.getBoundingClientRect();
  const gap = 0; // চাইলে -2

  box.style.left = '0px';
  box.style.top  = '0px';
  let boxRect = box.getBoundingClientRect();

  // ✅ Default left align to trigger (আগের মতো)
  let left = rect.left;
  let top  = rect.bottom + gap;

  // Keep inside viewport
  const maxLeft = window.innerWidth - boxRect.width - 8;
  if (left > maxLeft) left = Math.max(8, maxLeft);
  if (left < 8) left = 8;

  // If bottom overflow -> show above
  const maxTop = window.innerHeight - boxRect.height - 8;
  if (top > maxTop) top = rect.top - boxRect.height - gap;

  box.style.left = `${left}px`;
  box.style.top  = `${top}px`;

  // re-measure for accurate arrow
  boxRect = box.getBoundingClientRect();

  // Arrow position (point to hovered icon center)
  const iconCenter = rect.left + rect.width / 2;
  const arrowLeft = Math.max(14, Math.min(boxRect.width - 14, iconCenter - left));
  arrow.style.left = `${arrowLeft - 10}px`;

  // ✅ animate IN (slide-up)
  requestAnimationFrame(() => {
    box.classList.remove('opacity-0','translate-y-2');
    box.classList.add('opacity-100','translate-y-0');
  });
}

function scheduleCloseCertModal(){
  closeTimer = setTimeout(closeCertModal, 160);
}

function closeCertModal(){
  const modal = document.getElementById('certModal');
  const box   = document.getElementById('certModalBox');

  // animate out
  box.classList.remove('opacity-100','translate-y-0');
  box.classList.add('opacity-0','translate-y-2');

  setTimeout(() => modal.classList.add('hidden'), 180);
}

document.addEventListener('DOMContentLoaded', () => {
  const box = document.getElementById('certModalBox');

  box.addEventListener('mouseenter', () => {
    if (closeTimer) clearTimeout(closeTimer);
  });
  box.addEventListener('mouseleave', scheduleCloseCertModal);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeCertModal();
  });

  window.addEventListener('scroll', closeCertModal, true);
  window.addEventListener('resize', closeCertModal);
});
</script>





<script>
    document.addEventListener("DOMContentLoaded", function() {
    const lazyImages = document.querySelectorAll("img.lazy");

    const lazyLoad = (image) => {
        const src = image.getAttribute('data-src');
        if(src){
            image.src = src;
            image.classList.remove('lazy');
        }
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                lazyLoad(entry.target);
                obs.unobserve(entry.target);
            }
        });
    }, {
        rootMargin: "0px 0px 200px 0px" // scroll হলে আগে লোড হবে
    });

    lazyImages.forEach(img => observer.observe(img));
});

</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.querySelector('.hiddenBtnClick');
  const mainDiv = document.querySelector('.mainDiv');
  const sidebar = document.getElementById('campaignSidebar');

  if (!btn || !mainDiv || !sidebar) return;

  btn.addEventListener('click', (e) => {
    e.preventDefault();

    // hide article
    mainDiv.classList.add('hidden');

    // show aside (mobile+tablet)
    sidebar.classList.remove('hidden');
    sidebar.classList.add('flex', 'flex-col');

    sidebar.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
});

const backBtn = document.getElementById('backBtn');
backBtn?.addEventListener('click', () => {
  mainDiv.classList.remove('hidden');
  sidebar.classList.add('hidden');
  sidebar.classList.remove('flex', 'flex-col');
});

</script>




<?php $__env->stopSection(); ?> 
<?php echo $__env->make('frontend.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/frontend/campaign_details.blade.php ENDPATH**/ ?>