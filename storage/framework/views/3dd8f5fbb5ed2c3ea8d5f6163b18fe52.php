

<?php $__env->startSection('title', $story->seo_title); ?>
<?php $__env->startSection('meta_description', $story->meta_description); ?>
<?php $__env->startSection('meta_keyword', $story->tags); ?>
 
<?php $__env->startSection('meta'); ?>
<?php
  $title = $story->seo_title ?? $story->localeTitleShow();
  $desc  = $story->meta_description ?? strip_tags($story->description ?? '');
  $locale = session('locale', config('app.locale'));
  $url = $locale === 'es'
      ? route('blogDetailsEs', $story->slug)
      : route('blogDetails', $story->slug);
      
  $img   = !empty($story->image) ? asset('storage/story_image/'.$story->image) : asset('images/og-default.jpg');
?>


<link rel="canonical" href="<?php echo e($url); ?>">  


<link rel="alternate" hreflang="<?php echo e(app()->getLocale()); ?>" href="<?php echo e($url); ?>"> 
<link rel="alternate" hreflang="x-default" href="<?php echo e($url); ?>">


<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($desc); ?>">
<meta property="og:image" content="<?php echo e($img); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="<?php echo e($url); ?>">
<meta property="og:type" content="article">
<meta property="og:site_name" content="South American Initiatives">



<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($desc); ?>">
<meta name="twitter:image" content="<?php echo e($img); ?>">

<?php echo $__env->make('frontend.seo.blog_details', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('frontend'); ?>

<style>
  /* small helper (optional) */
  .shadow-soft{ box-shadow: 0 10px 30px rgba(0,0,0,.08); }
</style>


<section id="top" class="hidden sm:block bg-[#FE6668] sm:h-72 md:h-56 md:-mt-36"></section>




<section class="md:h-32"></section>
<section class=" md:-mt-48 pb-10 relative z-10">
  <div class="max-w-7xl md:mx-auto md:px-4">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,3fr)_minmax(0,1fr)]">

      
      <div class="space-y-6">

        
        <article class="bg-white border border-gray-200 shadow-soft overflow-hidden">

          
          <div class="relative w-full h-[190px] md:h-[300px] overflow-hidden bg-gray-200">
            <?php
                $locale = app()->getLocale();

                // Title normalize (আপনার আগের মতোই)
                $title = $story->title;
                if (is_string($title)) {
                    $d = json_decode($title, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                        $title = $d[$locale] ?? ($d['en'] ?? reset($d));
                    }
                } elseif (is_array($title)) {
                    $title = $title[$locale] ?? ($title['en'] ?? reset($title));
                }

                // Story slug normalize (json/string/array)
                $sSlug = $story->slug;
                if (is_string($sSlug)) {
                    $d = json_decode($sSlug, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                        $sSlug = $d[$locale] ?? ($d['en'] ?? reset($d));
                    }
                } elseif (is_array($sSlug)) {
                    $sSlug = $sSlug[$locale] ?? ($sSlug['en'] ?? reset($sSlug));
                }

                // imageSlug: DB image_url prefer, fallback seo slug
                $imageSlug = $story->image_url ?: \Illuminate\Support\Str::slug($title ?: ('gallery-' . $story->id));

                // ext from original file name
                $ext = strtolower(pathinfo($story->image ?? '', PATHINFO_EXTENSION) ?: 'jpg');
            ?>

            <?php if(!empty($story->image)): ?>
                <img
                    src="<?php echo e(route('gallery.image.story', [
                        'reportSlug' => $sSlug,
                        'imageSlug'  => $imageSlug,
                        'ext'        => $ext,
                    ])); ?>"
                    alt="<?php echo e($title ?? ''); ?>"
                >
            <?php endif; ?>


            
            <div class="absolute inset-0 bg-black/20"></div>

            
            <a href="<?php echo e(route('news')); ?>"
              class="absolute top-3 left-3 md:top-4 md:left-4 z-20
                      text-white text-[12px] md:text-[13px] flex items-center gap-2 drop-shadow">
              <span class="text-[18px] leading-none">‹</span>
              <span> <?php echo e(translate('Back to News')); ?></span>
            </a>

            
            <div class="absolute left-0 right-0 bottom-0 z-20 px-3- md:px-6- pb-3- md:pb-4-">

              
              <div class="flex flex-wrap items-center gap-2 md:gap-3 mb-2 px-4">

                <span class="hidden sm:block  bg-[#f3f3f3] text-gray-600 text-[12px] font-extrabold uppercase tracking-wide px-4 py-2 rounded-md- shadow">
                  <?php echo e(translate('Campaign')); ?>

                </span> 

                <span class="bg-[#ff6b6b] text-white text-[12px] font-extrabold uppercase tracking-wide   px-6 py-2 rounded-sm shadow">
                  <?php echo e(\Illuminate\Support\Str::limit($story->campaign->title ?? '', 20)); ?>

                </span>

                <?php if(!empty($story->campaign->slug)): ?>
                <a href="<?php echo e(session('locale', config('app.locale')) === 'es' ? route('campaignsdetailsEsDyn', ['path' => $story->campaign->path, 'slug' => $story->campaign->slug]) : route('campaignsdetailsDyn', ['path' => $story->campaign->path, 'slug' => $story->campaign->slug])); ?>">
                <span class="bg-[#ff6b6b] text-white px-4 py-2 rounded-sm shadow text-[12px] font-extrabold">
                  ↗
                </span> 
                </a>
                 <?php endif; ?>

                <?php 
                $category = $story->category;
                ?>
                <a href="<?php echo e(route('news', array_filter(['category' => $category->id, 'q' => request('q')]))); ?>">
                  <span class="hidden sm:block  text-[12px] px-6 py-2 rounded-sm shadow" style="background-color: <?php echo e($category->bg_color); ?>; color:black;">
                    <?php echo e($category->name ?? ''); ?>

                  </span>
                </a>
              </div>

              
              <div class="bg-[#ff6b6b] text-white rounded-md- shadow px-4 md:px-6 py-3 md:py-4">
                <h1 class="text-[18px] md:text-[30px] font-extrabold leading-tight">
                  <?php echo e($story->title); ?>

                </h1>
              </div>

            </div>
          </div>

  
 

          
          <div class="px-4 md:px-8 py-6">

            
            <div class="flex flex-wrap items-center justify-between gap-3 mb-3">

              <div class="flex flex-wrap items-center gap-2 text-[11px]">
                <span class="px-3 py-1 rounded-full bg-[#f04848] text-white font-bold uppercase tracking-[.12em]">
                   <?php echo e(translate('Report')); ?>

                </span>
                <span class="text-gray-400">|</span>

                <span class="inline-flex items-center gap-1 text-gray-500">
                  <i class="far fa-calendar-alt"></i>
                  <?php echo e(optional($story->created_at)->format('M d, Y')); ?>

                </span>

                <span class="text-gray-400">|</span>

                <span class="inline-flex items-center gap-1 text-gray-500">
                  <i class="far fa-user"></i>
                  <?php echo e($story->user->name ?? ''); ?>

                </span>

                <!-- <span class="text-gray-400">|</span>

                <span class="inline-flex items-center gap-1 text-gray-500">
                  <i class="far fa-comment"></i>
                  0
                </span> -->
              </div>

              
              <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#ff5c5c]"></span>
                <span class="w-2 h-2 rounded-full bg-[#ffcf34]"></span>
                <span class="w-2 h-2 rounded-full bg-[#0047ab]"></span>
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
              </div>
            </div>


            
            <?php if(!empty($story->description)): ?>
              <div class="text-[13px] md:text-[14px] text-gray-500 leading-relaxed mb-5">
                <?php echo $story->description; ?>

              </div>
            <?php endif; ?>

            
            <div class="space-y-5 text-[13px] md:text-[14px] text-gray-600 leading-relaxed">

              <?php if(!empty($story->summary)): ?>
                <div class="prose max-w-none">
                  <?php echo $story->summary; ?>

                </div>
              <?php endif; ?>

            </div>

            
             <div class="mt-8 border border-gray-200 overflow-hidden">
                <div class="grid md:grid-cols-2">
                  <div class="bg-[#f04848] text-white p-6">
                    <p class="text-[10px] font-bold uppercase opacity-90">
                      <?php echo $story->footer_title; ?>

                    </p>
                    <h3 class="mt-2 text-[16px] md:text-[18px] font-extrabold uppercase leading-snug">
                        <?php echo $story->footer_subtitle; ?>

                    </h3> 
                    <?php if(!empty($story->campaign->slug)): ?>
                    <a href="<?php echo e(session('locale', config('app.locale')) === 'es' ? route('campaignsdetailsEsDyn', ['path' => $story->campaign->path, 'slug' => $story->campaign->slug]) : route('campaignsdetailsDyn', ['path' => $story->campaign->path, 'slug' => $story->campaign->slug])); ?>" class="inline-flex mt-4 items-center justify-center bg-white text-[#f04848] px-5 py-2 text-[11px] font-extrabold uppercase">
                      <?php echo e(translate('Donate to this project')); ?>

                    </a>
                    <?php endif; ?>
                  </div> 

                  <?php
                      $locale = app()->getLocale();

                      // story slug normalize
                      $sSlug = $story->slug;
                      if (is_string($sSlug)) {
                          $d = json_decode($sSlug, true);
                          if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                              $sSlug = $d[$locale] ?? ($d['en'] ?? reset($d));
                          }
                      } elseif (is_array($sSlug)) {
                          $sSlug = $sSlug[$locale] ?? ($sSlug['en'] ?? reset($sSlug));
                      }

                      $footerSlug = $story->footer_image_url ?: ('footer-' . $story->id);
                      $footerExt  = strtolower(pathinfo($story->footer_image2 ?? '', PATHINFO_EXTENSION) ?: 'jpg');
                  ?>

                  <div class="relative h-40 md:h-auto">
                    <?php if(!empty($story->image)): ?>
                    <img
                      src="<?php echo e(route('gallery.image.story', [
                        'reportSlug' => $sSlug,
                        'imageSlug'  => $imageSlug,
                        'ext'        => $ext,
                    ])); ?>"
                    alt="<?php echo e($title ?? ''); ?>"  class="w-full h-full object-cover"  alt="<?php echo e($story->footer_title); ?>">
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-[#f04848]/25"></div>
                  </div>
                </div>
              </div>
          </div>

          
          <div class="py-2"> 
              <?php echo $__env->make('frontend.includes.scroll_element', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>
        </article>
      </div>

      
      <aside class="space-y-5" id="Payment">
        <div class="">
          <?php if(!empty($story->campaign->donorbox_code )): ?>
              <section class="space-y-2- prose max-w-none">
                  <?php echo $story->campaign->donorbox_code; ?>

              </section>
          <?php endif; ?>
        </div>
      </aside>
    </div>
  </div>
</section>


<section class="bg-[#FE6668] mt-20 md:mt-20 pb-16 relative z-10">
    <div class="max-w-7xl mx-auto px-3 md:px-4">

      
      <h2 class="text-white text-3xl md:text-4xl font-semibold pt-10">
        <?php echo e(translate('Read other Articles')); ?> 
      </h2>

      
      <div class="mt-6 h-px bg-white/45 w-full"></div>

      
      <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">

        <?php $__currentLoopData = $relatedStories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $rs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="bg-white rounded-[10px] overflow-hidden shadow-[0_14px_35px_rgba(0,0,0,.16)]">

                
                <div class="h-[210px] bg-gray-200 overflow-hidden">
                <?php if(!empty($rs->image)): ?>
                    <img
                    src="<?php echo e(asset('storage/story_image/'.$rs->image)); ?>"
                    class="w-full h-full object-cover"
                    alt="<?php echo e($rs->title); ?>" title="<?php echo e($rs->title); ?>">
                <?php endif; ?>
                </div>

                
                <div class="bg-[#ff6b6b] text-white text-center px-4 py-3">
                <p class="text-[13px] font-extrabold tracking-wide">
                     <?php echo e(\Illuminate\Support\Str::limit($rs->title ?? '', 100)); ?>

                </p>
                </div> 

                
                <div class="bg-[#f2f2f2] px-5 py-5">
                <p class="text-[14px] leading-relaxed text-gray-500">
                    <?php echo e(\Illuminate\Support\Str::limit($rs->short_description ?? '', 100)); ?>

                </p>

                
               <div class="mt-5 flex items-center justify-between flex-wrap gap-3 text-[11px] text-gray-400">

                    
                    <div class="flex items-center gap-4 flex-wrap">
                        <span><?php echo e(optional($rs->created_at)->format('j M Y')); ?></span>

                        <span class="flex items-center gap-2">
                            <span> <?php echo e(translate('Posted By')); ?> </span>
                            <span class="w-3 h-3 rounded-full border border-gray-400 inline-block"></span>
                        </span>

                        <span class="font-bold text-gray-500 uppercase">
                            <?php echo e($rs->user->name ?? '--'); ?>

                        </span>
                    </div>

                    
                    <a href="<?php echo e(route('blogDetails', $rs->slug)); ?>"
                    class="inline-flex items-center justify-center
                            border border-[#ff6b6b] text-[#ff6b6b]
                            px-4 py-2 text-[12px] font-medium rounded-[2px]
                            hover:bg-[#ff6b6b] hover:text-white transition">
                         <?php echo e(translate('Read more')); ?> 
                    </a>
                </div>

                </div>

            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


      </div>
    </div>
</section>




<script src="https://donorbox.org/widget.js" paypalExpress="true"></script>
<script>
  document.addEventListener('click', function(e){
    const item = e.target.closest('.amount-item');
    if(!item) return;

    // check the hidden radio
    const radio = item.querySelector('input[type="radio"]');
    if(radio) radio.checked = true;

    // reset all
    document.querySelectorAll('#amountList .amount-item').forEach(el=>{
      el.classList.remove('border-[#f04848]','bg-[#fff5f5]');
      el.classList.add('border-gray-300');
      const dot = el.querySelector('.dot');
      const fill = el.querySelector('.dotFill');
      if(dot){ dot.classList.remove('border-[#f04848]'); dot.classList.add('border-gray-400'); }
      if(fill){ fill.classList.add('hidden'); }
    });

    // active styles
    item.classList.add('border-[#f04848]','bg-[#fff5f5]');
    item.classList.remove('border-gray-300');
    const dot = item.querySelector('.dot');
    const fill = item.querySelector('.dotFill');
    if(dot){ dot.classList.add('border-[#f04848]'); dot.classList.remove('border-gray-400'); }
    if(fill){ fill.classList.remove('hidden'); fill.classList.add('bg-[#f04848]'); }
  });
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/frontend/blog_details.blade.php ENDPATH**/ ?>