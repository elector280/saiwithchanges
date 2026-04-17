


<?php $__env->startSection('title', translate('Campaigns page meta title')); ?>
<?php $__env->startSection('meta_description', translate('Campaigns page meta description')); ?>
<?php $__env->startSection('meta_keyword', translate('Campaigns page meta keyword')); ?>

<?php $__env->startSection('meta'); ?>
  <link rel="canonical" href="<?php echo e(url()->current()); ?>">

  
  <meta property="og:title" content="<?php echo e(translate('Campaigns page title')); ?>">
  <meta property="og:description" content="<?php echo e(translate('Campaigns page description')); ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo e(url()->current()); ?>">
  <meta property="og:image" content="<?php echo e(asset('storage/logo/'.$setting->logo)); ?>">

  
  <meta name="twitter:card" content="<?php echo e(asset('storage/logo/'.$setting->logo)); ?>">
  <meta name="twitter:title" content="<?php echo e(translate('Campaigns page title')); ?>">
  <meta name="twitter:description" content="<?php echo e(translate('Campaigns page description')); ?>"> 
  <meta name="twitter:image" content="<?php echo e(asset('storage/logo/'.$setting->logo)); ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('frontend'); ?>



    <!-- ================= NEWSLETTER (FINAL CLONE) ================= -->
    <section class="mt-8 lg:mt-5">
      <div class="max-w-7xl mx-auto">
        <!-- outer card -->
        <div  class="relative overflow-hidden rounded-[6px] shadow-[0_18px_40px_rgba(0,0,0,0.20)]-">

          <!-- TOP RED PANEL -->
          <div  class="relative bg-[#F56161] text-white px-6 sm:px-8 lg:px-10 py-9 lg:py-11  grid lg:grid-cols-[1.2fr,1fr] gap-8 items-center">

            <div class="absolute top-0 -right-10 hidden w-16 h-full md:block">
                <div class="absolute inset-y-0 right-5 w-7 bg-[#2261aa] skew-x-[42deg]">  </div>
                <div class="absolute inset-y-0 right-0 w-6 bg-[#fff0a1] skew-x-[42deg]">  </div>
            </div>

            <!-- LEFT : logo + texts -->
            <div class="flex items-start gap-6">
              <div>
                <p class="text-xl sm:text-sm uppercase  text-[#FFEFA0]">
                   <?php echo e(translate('Explore Fundraisings')); ?> 
                </p>
                <h1 class="mt-2 text-[22px] sm:text-[24px] lg:text-[26px] font-semibold leading-snug uppercase">
                     <?php echo translate(' SEARCH FOR OUR DONATIONS CAMPAIGNS'); ?>

                </h1>
              </div>
            </div>

            <!-- RIGHT : big email input -->
            <div class="flex justify-start lg:justify-end md:mr-10">
              <form action="<?php echo e(route('campaigns')); ?>" method="GET" class="w-full max-w-lg relative">
                <!-- Search Icon -->
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">
                    <i class="fas fa-search"></i>
                </span>
                <!-- Input -->
                <input type="text"
                      name="q"
                      value="<?php echo e(request('q')); ?>"
                      placeholder="Search campaign or keywords"
                      class="w-full pr-48 pl-12 px-5 py-2 rounded-lg bg-white text-[13px] sm:text-sm
                              text-slate-900 border border-white/70
                              shadow-[0_10px_22px_rgba(0,0,0,0.25)]
                              focus:outline-none placeholder:text-slate-400"/>

                <!-- Search Button -->
                <button type="submit"
        class="absolute inset-y-1 <?php echo e(!empty($q) ? 'right-20' : 'right-1'); ?> px-4 sm:px-6 text-[11px] sm:text-xs
               font-semibold uppercase tracking-[0.16em] rounded-lg bg-[#ffe36b] text-[#b92f2f]
                              shadow-[0_6px_14px_rgba(0,0,0,0.18)] hover:bg-[#ffea8d] transition">
                     <?php echo e(translate('Search')); ?>

                </button>

                <?php if(!empty($q)): ?>
                    <a href="<?php echo e(route('campaigns')); ?>"
                      class="absolute inset-y-1 right-1 px-4 sm:px-5 text-[11px] sm:text-xs
                              font-semibold uppercase tracking-[0.16em]- rounded-lg bg-white/90 text-slate-700 border
                              hover:bg-white transition flex items-center border-lg border-purple-500"> 
                         <?php echo e(translate('Reset')); ?>

                    </a>
                <?php endif; ?>

            </form>

            </div>

          </div>
        </div>
      </div>
    </section>


    <!-- ================= URGENT FUNDRAISINGS ================= -->
    <section class="mt-8 lg:mt-5">
      <div class="max-w-7xl mx-auto">
        <div class="py-10 lg:px-10 lg:py-12 rounded-md">
          <div class="text-center mb-8">
            <p class="mt-1 text-lg font-semibold">
              <?php echo e($campaigns->total()); ?>  <?php echo e(translate('Results found')); ?> 
              <?php if(!empty($q)): ?>
                for "<?php echo e($q); ?>"
              <?php endif; ?>
            </p>
          </div>


         
          

          <!-- কার্ডগুলো -->
          <div class="grid gap-6 mx-0 mx-5 md:grid-cols-3">
            <!-- CARD 1 -->
             <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <?php
              $slug = $item->getTranslation('slug', app()->getLocale(), false) ?? $item->getTranslation('slug', 'en');
              ?>
            <article class="relative flex flex-col bg-[#f97373] shadow-xl overflow-hidden rounded-tl-[14px] rounded-tr-[14px] rounded-bl-none rounded-br-none">
              <div class="relative">
                <img src="<?php echo e(asset('storage/hero_image/'.$item->hero_image)); ?>" alt="<?php echo e($item->title); ?>" title="<?php echo e($item->title); ?>" class="w-full h-56 object-cover" loading="lazy"/>
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
                    <a href="<?php echo e(session('locale', config('app.locale')) === 'es' ? route('campaignsdetailsEsDyn', ['path' => $item->path, 'slug' => $slug]) : route('campaignsdetailsDyn', ['path' => $item->path, 'slug' => $slug])); ?>"
                        class="block w-full py-2 px-5 mt-4 text-sm font-semibold tracking-widest uppercase 
                            bg-white border shadow-md text-red-500 border-white/60">
                        <?php echo e(translate('Donate')); ?> &gt;
                    </a>
                </div> 
              </div>

              <div class="h-[10px] w-full"  style="background-color: <?php echo e($item->bg_color ?? '#FFE36B'); ?>;"></div>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
        <div class="mt-5- flex justify-center mb-10">
          <?php echo e($campaigns->onEachSide(1)->links()); ?>

        </div>
      </div>
    </section>


<?php $__env->stopSection(); ?> 
<?php echo $__env->make('frontend.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/frontend/campaigns.blade.php ENDPATH**/ ?>