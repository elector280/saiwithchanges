<?php $__env->startSection('title', translate('Contact Us page meta title')); ?>
<?php $__env->startSection('meta_description', translate('Contact Us page meta description')); ?>
<?php $__env->startSection('meta_keyword', translate('Contact Us page meta keyword')); ?>

<?php $__env->startSection('meta'); ?>
  <link rel="canonical" href="<?php echo e(url()->current()); ?>">

  
  <meta property="og:title" content="<?php echo e(translate('Contact Us page title')); ?>">
  <meta property="og:description" content="<?php echo e(translate('Contact Us page description')); ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo e(url()->current()); ?>">
  <meta property="og:image" content="<?php echo e(asset('storage/logo/'.$setting->logo)); ?>">

  
  <meta name="twitter:card" content="<?php echo e(asset('storage/logo/'.$setting->logo)); ?>">
  <meta name="twitter:title" content="<?php echo e(translate('Contact Us page title')); ?>">
  <meta name="twitter:description" content="<?php echo e(translate('Contact Us page description')); ?>"> 
  <meta name="twitter:image" content="<?php echo e(asset('storage/logo/'.$setting->logo)); ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('frontend'); ?>

<!-- ===================== HERO SECTION ===================== -->
<section class="py-6 lg:py-8 bg-[#F4F4F4] -mt-10 md:-mt-36 ">
  <div class="max-w-6xl md:px-4 md:mx-auto lg:px-10 md:pt-48">

    <!-- ONE CARD -->
    <div class="grid overflow-hidden bg-white shadow-sm lg:grid-cols-2 md:rounded-xl">

      <!-- LEFT IMAGE -->
      <div class="relative min-h-[320px] lg:min-h-[420px]">
        <img src="<?php echo e(asset('storage/contact_us_cover_image/'.$setting->contact_us_cover_image)); ?>"
             class="absolute inset-0 object-cover w-full h-full" alt="<?php echo e(translate('contact us cover image alt')); ?>" title="<?php echo e(translate('Annual report cover image title')); ?>" /> 

        <!-- dark overlay -->
        <div class="absolute inset-0 bg-black/35"></div>

        <!-- text -->
        <div class="absolute inset-0 flex flex-col justify-between p-10">
          <div>
            <h2 class="text-2xl sm:text-4xl font-semibold leading-tight text-[#E9D48A] whitespace-pre-line">
              <?php if(!empty($setting->contact_us_title)): ?>
                <?php echo $setting->contact_us_title; ?>

              <?php endif; ?>
            </h2>
          </div>

          <p class="max-w-sm text-sm leading-relaxed text-white/85 whitespace-pre-line">
            <?php if(!empty($setting->contact_us_content)): ?>
              <?php echo $setting->contact_us_content; ?>

            <?php endif; ?>
          </p>
        </div>
      </div>

      <!-- RIGHT FORM -->
      <div class="bg-[#D94A4A] p-8 sm:p-10 lg:p-12">
        <?php if(session('success')): ?>
            <p class="mb-2 text-white"><?php echo e(session('success')); ?></p>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('contact.send')); ?>" class="space-y-4">
          <?php echo csrf_field(); ?>
          <input type="text" placeholder="Name Surname" name="name"
            class="w-full px-4 py-2 text-black placeholder-gray-500 bg-white border rounded-md border-white/70 focus:outline-none focus:ring-2 focus:ring-black/30" />

          <input type="email" placeholder="Your Email Address" name="email"
            class="w-full px-4 py-2 text-black placeholder-gray-500 bg-white border rounded-md border-white/70 focus:outline-none focus:ring-2 focus:ring-black/30" />

          <input type="text" placeholder="Email Subject" name="subject"
            class="w-full px-4 py-2 text-black placeholder-gray-500 bg-white border rounded-md border-white/70 focus:outline-none focus:ring-2 focus:ring-black/30" />

          <textarea placeholder="Type message" name="message"
            class="w-full h-40 px-4 py-2 text-black placeholder-gray-500 bg-white border rounded-md resize-none border-white/70 focus:outline-none focus:ring-2 focus:ring-black/30"></textarea>

            <!-- ✅ Terms checkbox (button এর উপরে) -->
            <label class="flex items-center gap-3 text-white text-md">
                <input type="checkbox" name="terms" required
                    class="w-4 h-4 rounded-full accent-white border border-white/70 bg-transparent
                          focus:ring-2 focus:ring-white/40" />
                <span> <?php echo e(translate('I accept term and conditions')); ?></span>
            </label>



          <!-- button like screenshot (not full width) -->
          <button type="submit"
            class="mt-2 inline-flex items-center justify-center px-10 py-1 bg-white text-[#D94A4A]
                   font-semibold rounded-sm hover:bg-white/90 transition">
             <?php echo e(translate('SEND EMAIL')); ?> &gt;
          </button>

        </form>
      </div>

    </div>
  </div>
</section>


<!-- ===================== MAP & OFFICE SECTION ===================== -->
<section class="md:py-6 lg:py-8 bg-[#F4F4F4]">
 <div class="max-w-6xl mx-5 mx-auto px-16 py-5 w-full md:mx-auto">
    <!-- Wrapper: Title Left + Content Right -->
    <div class="flex flex-col md:gap-10 md:flex-row md:items-start md:justify-between">
    <hr>
      <!-- LEFT SIDE TITLE -->
      <div class="md:w-1/4">
        <h2 class="text-2xl font-bold text-left">
           <?php echo translate('OUR CONTACTS INFOS'); ?>

        </h2>
      </div>

      <!-- RIGHT SIDE CONTENT -->
      <div class="grid grid-cols-1 gap-10 text-sm sm:grid-cols-2 md:grid-cols-3 md:w-3/4">

        <!-- Email Section -->
        <div class="space-y-1">
          <h3 class="text-base font-bold text-red-600"> <?php echo e(translate('Email Address')); ?></h3>
          <p class="text-gray-700"><?php echo e($setting->telephone); ?></p>
          <p class="text-gray-700"><?php echo e($setting->email); ?></p>
        </div>

        <!-- Address Section -->
        <div class="space-y-1">
          <h3 class="text-base font-bold text-red-600"> <?php echo e(translate('Address')); ?></h3>
          <div  class="whitespace-pre-line">
          <?php if(!empty($setting->address)): ?>
              <?php echo $setting->address; ?>

          <?php endif; ?>
          </div>
        </div>

        <!-- Social Media Section -->
        <div>
          <h3 class="mb-3 text-base font-bold text-red-600"> <?php echo e(translate('Social Media Channels')); ?></h3>

          <div class="flex items-center gap-3 text-white">
            <!-- Facebook -->
            <a href="<?php echo e($setting->fb_url); ?>" class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full">
              <i class="text-sm fab fa-facebook-f"></i>
            </a>

            <!-- Twitter/X -->
            <a href="<?php echo e($setting->twitter_url); ?>" class="flex items-center justify-center w-8 h-8 bg-blue-900 rounded-full">
              <i class="text-sm fab fa-x-twitter"></i>
            </a>

            <!-- Instagram -->
            <a href="<?php echo e($setting->instragram_url); ?>" class="flex items-center justify-center w-8 h-8 bg-pink-500 rounded-full">
              <i class="text-sm fab fa-instagram"></i>
            </a>

            <!-- Linkedin -->
            <a href="<?php echo e($setting->youtube_url); ?>" class="flex items-center justify-center w-8 h-8 bg-red-500 rounded-full">
              <i class="text-sm fab fa-youtube"></i>
            </a>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="py-6 lg:py-8 bg-[#F4F4F4]">
  <div class="max-w-6xl px-4 py-5 mx-auto">
    <div class="grid gap-6 md:grid-cols-3">
      <div class="bg-[#fbe8e8] p-6 rounded-md">
        <h3 class="text-lg font-bold"> <?php echo e(translate('START VOLUNTEERING')); ?></h3>
        <p class="mt-3 text-sm whitespace-pre-line">
          <?php if(!empty($setting->start_volunteering_content)): ?>
              <?php echo $setting->start_volunteering_content; ?>

          <?php endif; ?>
        </p>
        <button class="group w-[70%] border border-red-600 text-red-600 py-1 mt-4 rounded-lg font-semibold
            hover:bg-red-600 hover:text-white transition shadow-md flex items-center justify-center gap-2"  style="border: 1px solid red !important;">
             <?php echo e(translate('APPLY')); ?>

            <i class="text-red-600 transition fa-solid fa-arrow-right-long group-hover:text-white"></i>
        </button>

      </div>

      <div class="bg-[#fbe8e8] p-6 rounded-md">
        <h3 class="text-lg font-bold"> <?php echo e(translate('BECOME SPONSOR')); ?></h3>
        <p class="mt-3 text-sm whitespace-pre-line">
          <?php if(!empty($setting->become_sponsor_content)): ?>
            <?php echo $setting->become_sponsor_content; ?>

          <?php endif; ?>
        </p>
        <button class="group w-[70%] border border-red-600 text-red-600 py-1 mt-4 rounded-lg font-semibold
            hover:bg-red-600 hover:text-white transition shadow-md flex items-center justify-center gap-2"  style="border: 1px solid red !important;">
            <?php echo e(translate('APPLY')); ?>

            <i class="text-red-600 transition fa-solid fa-arrow-right-long group-hover:text-white"></i>
        </button>
      </div>



      <div class="bg-[#fbe8e8] p-6 rounded-md">
        <h3 class="text-lg font-bold "> <?php echo e(translate('DOWNLOAD ANNUAL REPORT')); ?></h3>
        <p class="mt-3 text-sm whitespace-pre-line">
           <?php if(!empty($setting->download_annual_report_content)): ?>
              <?php echo $setting->download_annual_report_content; ?>

          <?php endif; ?>
        </p>
        <?php if(!empty($setting->download_annual_report_file)): ?>
          <a href="<?php echo e(asset('storage/download_annual_report_file/'.$setting->download_annual_report_file)); ?>"
            download
            class="inline-block group w-[70%] border border-red-600 text-red-600 py-1 mt-4 rounded-lg font-semibold
                    hover:bg-red-600 hover:text-white transition shadow-md text-center"  style="border: 1px solid red !important;">

               <?php echo e(translate('Download')); ?>

              <i class="ml-2 transition fa-solid fa-download text-md group-hover:text-white"></i>
          </a>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>

<section class="py-6 lg:py-8 bg-[#F4F4F4]">
  <div class="max-w-6xl px-4 py-10 mx-auto space-y-10">
    <div class="grid items-center gap-8 md:grid-cols-2">

      <!-- Google Map -->
      <div class="bg-white border rounded-xl p-4-">
        <div class="w-full h-[220px] md:h-[300px] rounded-lg overflow-hidden">
          <?php if(!empty($setting->google_map)): ?>
              <?php echo $setting->google_map; ?>

          <?php endif; ?>
        </div>
      </div>

      <!-- Right Address Section -->
      <div class="space-y-8 text-sm">
        <div>
          <h3 class="font-bold text-red-600"> <?php echo e(translate('Our offices in the USA:')); ?></h3>
          <div  class="whitespace-pre-line">
          <?php if(!empty($setting->office_usa)): ?>
              <?php echo $setting->office_usa; ?>

          <?php endif; ?>
          </div>
        </div>

        <div>
          <h3 class="font-bold text-red-600"> <?php echo e(translate('Our Offices in Venezuela:')); ?></h3>
          <div  class="whitespace-pre-line">
          <?php if(!empty($setting->office_venezuela)): ?>
              <?php echo $setting->office_venezuela; ?>

          <?php endif; ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/frontend/contact_us.blade.php ENDPATH**/ ?>