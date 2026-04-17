


<?php $__env->startSection('title', translate('Double Your Help with Employee Matching Gifts page meta title')); ?>
<?php $__env->startSection('meta_description', translate('Double Your Help with Employee Matching Gifts page meta description')); ?>
<?php $__env->startSection('meta_keyword', translate('Double Your Help with Employee Matching Gifts page meta keyword')); ?>
    
<?php $__env->startSection('meta'); ?>
  <link rel="canonical" href="<?php echo e(url()->current()); ?>">

  
  <meta property="og:title" content="<?php echo e(translate('Double Your Help with Employee Matching Gifts page title')); ?>">
  <meta property="og:description" content="<?php echo e(translate('Double Your Help with Employee Matching Gifts page description')); ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo e(url()->current()); ?>">
  <meta property="og:image" content="<?php echo e(asset('storage/logo/'.$setting->logo)); ?>">

  
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo e(translate('Double Your Help with Employee Matching Gifts page title')); ?>">
  <meta name="twitter:description" content="<?php echo e(translate('Double Your Help with Employee Matching Gifts page description')); ?>"> 
  <meta name="twitter:image" content="<?php echo e(asset('storage/logo/'.$setting->logo)); ?>">
<?php $__env->stopSection(); ?>
<?php
    $locale = session('locale', config('app.locale'));
    ?>

<?php $__env->startSection('frontend'); ?>
<!-- TOP : DOUBLE YOUR HELP (IMAGE CLONE) -->
<section class="bg-[#f5f5f5] pt-48 pb-8 -mt-48 md:-mt-36">
    <div class="max-w-6xl md:mx-auto md:px-4">
        <?php if(!empty($setting->emp_match_section_1)): ?>
                            <?php echo $setting->emp_match_section_1; ?>

                    <?php endif; ?>
    </div>
</section>

<!-- ======= BENEvity STRIP : LEFT CARD + EMPTY RIGHT CARD ======= -->
<section class="bg-gradient-to-br from-[#ff5b5b] via-[#ff6d4c] to-[#ff7c7c] py-8">
    <div class="max-w-6xl mx-auto px-6">

        <?php if(!empty($setting->emp_match_section_2)): ?>
            <?php echo $setting->emp_match_section_2; ?>

        <?php endif; ?>

    </div>
</section> 


<!-- ========= MISSION TEXT + BULLET LIST BLOCK ========= -->
<section class="bg-[#f5f5f5]- py-10">
    <div class="max-w-6xl md:mx-auto md:px-4">

        <!-- outer white box -->
        <div class="border-gray-200- shadow-md- px-8 py-8">
            <?php if(!empty($setting->emp_match_section_3)): ?>
                            <?php echo $setting->emp_match_section_3; ?>

                    <?php endif; ?>
        </div>

    </div>
</section>


<!-- ============ COMPANY MATCH + DONATION SIDEBAR ============ -->
<section class="bg-[#f5f5f5] py-10">
    <div class="max-w-6xl mx-auto px-4">

        <div class="grid lg:grid-cols-[2.3fr,1.1fr] gap-6 items-start">

            <!-- ========== LEFT : TWO STACKED MATCH CARDS ========== -->
            <div class="space-y-5">

                <!-- CARD 1 : RED HEADER (BENEvity) -->
                <?php if(!empty($setting->emp_match_section_4)): ?>
                            <?php echo $setting->emp_match_section_4; ?>

                    <?php endif; ?>

                <!-- CARD 2 : BLUE HEADER (BENEvity / অন্য প্ল্যাটফর্ম) -->
                <?php if(!empty($setting->emp_match_section_5)): ?>
                            <?php echo $setting->emp_match_section_5; ?>

                    <?php endif; ?>

            </div>

            <!-- ========== RIGHT : DONATION SIDEBAR CARD ========== -->
            <aside class="bg-white border border-gray-200 shadow-md rounded-sm text-xs text-gray-700">
                <div class="">
                    <?php if(!empty($setting->global_donorbox_code)): ?>
                        <section class="space-y-2 prose max-w-none">
                            <?php echo $setting->global_donorbox_code; ?>

                        </section>
                    <?php endif; ?>
                </div>
            </aside>

        </div>
    </div>
</section>


<!-- ================== KEEP DONATING TO URGENT CAMPAIGNS ================== -->
<section class="bg-[#f3f4f6] pt-12">
    <div class="max-w-6xl mx-auto px-4">

        <!-- heading -->
        <h2 class="text-3xl md:text-4xl font-semibold uppercase text-[#D94647] mb-8">
             <?php echo translate('Keep donating to urgent'); ?>

        </h2>

        <!-- cards -->
        <div class="grid gap-6 md:grid-cols-3">

            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                        $slug = $item->getTranslation('slug', app()->getLocale(), false) ?? $item->getTranslation('slug', 'en');
                        ?>
            <article class="relative flex flex-col  rounded-tl-[14px] rounded-tr-[14px]  rounded-bl-none rounded-br-none bg-[#f97373] shadow-xl overflow-hidden">
              <div class="relative">
                <img src="<?php echo e(asset('storage/hero_image/'.$item->hero_image)); ?>" alt="<?php echo e($item->title); ?>"  title="<?php echo e($item->title); ?>" class="w-full h-56 object-cover" />
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2
                                bg-white text-slate-900 px-10 py-3 rounded-t-md shadow-md 
                                text-center text-sm font-semibold whitespace-nowrap min-w-[240px]"> 
                        <?php echo e(\Illuminate\Support\Str::limit($item->title ?? '', 35)); ?>

                    </div>
              </div>

              <div class="flex-1 flex flex-col pt-9 pb-6 px-6 text-md text-white/95">
                <p class="leading-relaxed">
                   <?php echo e(\Illuminate\Support\Str::limit($item->sub_title ?? '', 100)); ?>

                </p>
                <div class="text-center mb-5 md:mb-8">
<?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $campaignPath = $locale === 'es'
                                        ? ($item->getTranslation('path', 'es', false) ?: $item->getTranslation('path', 'en', false))
                                        : ($item->getTranslation('path', 'en', false) ?: $item->getTranslation('path', 'es', false));

                                    $campaignSlug = $locale === 'es'
                                        ? ($item->getTranslation('slug', 'es', false) ?: $item->getTranslation('slug', 'en', false))
                                        : ($item->getTranslation('slug', 'en', false) ?: $item->getTranslation('slug', 'es', false));

                                    $campaignPath = is_string($campaignPath) ? trim($campaignPath) : '';
                                    $campaignSlug = is_string($campaignSlug) ? trim($campaignSlug) : '';

                                    $campaignUrl = null;

                                    if ($campaignPath !== '' && $campaignSlug !== '') {
                                        $campaignUrl = $locale === 'es'
                                            ? route('campaignsdetailsEsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug])
                                            : route('campaignsdetailsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug]);
                                    }
                                ?>

                                <?php if($campaignUrl): ?>
                                    <a href="<?php echo e($campaignUrl); ?>"
                                       class="block px-4 py-2 border-b border-slate-100 hover:bg-red-50 hover:text-[#f04848] normal-case capitalize">
                                        <?php echo e($item->title); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>

              <div class="h-[10px] w-full" style="background-color: <?php echo e($item->bg_color ?? '#FFE36B'); ?>;"></div>  
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <!-- explore link -->
        <div class="mt-6 text-right">
            <a href="<?php echo e(route('campaigns')); ?>"
               class="text-sm text-[#e24b4b] underline">
                  <?php echo e(translate('Explore all Campaigns')); ?>

            </a>
        </div>

    </div>
</section>


 <?php echo $__env->make('frontend.includes.news_letter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="py-5 bg-[#f6f6f6]"> 
      <?php echo $__env->make('frontend.includes.scroll_element', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/frontend/double_donation.blade.php ENDPATH**/ ?>