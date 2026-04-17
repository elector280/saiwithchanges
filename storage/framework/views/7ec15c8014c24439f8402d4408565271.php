


<?php $__env->startSection('title', $donation_campaigns->meta_title ?? translate('Donation Campaigns meta title')); ?>
<?php $__env->startSection('meta_description', $donation_campaigns->meta_description ?? translate('donation campaign meta description')); ?>
<?php $__env->startSection('meta_keyword',  $donation_campaigns->meta_keyword ?? translate('donation page meta keyword')); ?>

<?php $__env->startSection('meta'); ?>
  <link rel="canonical" href="<?php echo e(url()->current()); ?>">

  
  <meta property="og:title" content="<?php echo e($donation_campaigns->og_title); ?>">
  <meta property="og:description" content="<?php echo e($donation_campaigns->og_description); ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo e(url()->current()); ?>">
  <meta property="og:image" content="<?php echo e(asset('storage/og_image/'.$donation_campaigns->og_image)); ?>">

  
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo e($donation_campaigns->og_title); ?>">
  <meta name="twitter:description" content="<?php echo e($donation_campaigns->og_description); ?>"> 
  <meta name="twitter:image" content="<?php echo e(asset('storage/og_image/'.$donation_campaigns->og_image)); ?>"> 
<?php $__env->stopSection(); ?>



<?php $__env->startSection('frontend'); ?>



<!-- ========= EXTRA CSS FOR TABS ========= -->
<style>
    .tab-active   { background:#e54545; color:#ffffff; }
    .tab-inactive { background:#f1f1f1; color:#d3564f; }
</style>


<section id="top" class="pt-4 pb-10 bg-[#f5f5f5]- -mt-10 md:-mt-36 relative z-0">
  <div  class="relative rounded-sm overflow-hidden shadow-lg bg-no-repeat bg-cover bg-center"
    style="background-image: url('<?php echo e(!empty($donation_campaigns?->cover_image) ? asset('storage/cover_image/'.$donation_campaigns->cover_image) : asset('storage/donate_hero_image/'.$setting->donate_hero_image)); ?>'); height: 600px;" >
    <!-- RED GRADIENT OVERLAY (ON TOP OF IMAGE) -->
    <div
      class="absolute inset-0 pointer-events-none z-10"
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
      "
    ></div>

    <!-- CONTENT -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 grid lg:grid-cols-[2fr,1fr] gap-6">
      <!-- content here -->
    </div>
  </div>
</section>




<section class="pb-20 -mt-48 relative z-10"> 
    <div class="max-w-7xl md:mx-auto md:px-4 grid lg:grid-cols-[3fr,1fr] gap-6">

       <div class="space-y-6">
        <span class="inline-flex w-fit shrink-0 px-6 py-1 font-semibold rounded-tr-lg rounded-bl-lg bg-[#D94647] text-white ml-2">
            <?php echo e($donation_campaigns->tag_line ?? $setting->tag_line); ?>

        </span>

        
        <article id="mainDiv" class="mainDiv overflow-visible space-y-12">

            
           <!-- ✅ RESPONSIVE CARD (desktop + mobile like screenshot) -->
            <div class="bg-white shadow-md border border-gray-200 overflow-hidden  mx-2 md:mx-0 rounded-[4px]">

               
                <!-- TOP RED HEADER -->
                <div class="relative bg-[#D94647] text-white px-2 md:px-8 py-3 overflow-hidden">
                    <h1 class="px-5 md:px-8 text-[22px] sm:text-[26px] md:text-[34px] lg:text-[40px]  font-bold uppercase leading-tight">
                    <?php if(!empty($donation_campaigns->title)): ?>
                        <?php echo $donation_campaigns->title; ?>

                    <?php elseif(!empty($setting->donate_title)): ?>
                        <?php echo $setting->donate_title; ?>

                    <?php endif; ?>
                    </h1>

                    <!-- right ribbon (blue + yellow) -->
                    <div class="absolute top-0 -right-2 hidden w-16 h-full md:block">
                        <div class="absolute inset-y-0 right-5 w-7 bg-[#2261aa] skew-x-[42deg]">  </div>
                        <div class="absolute inset-y-0 right-0 w-6 bg-[#fff0a1] skew-x-[42deg]">  </div>
                    </div>
                </div>

                <a href="javascript:void(0)"  id="donateBtn"
                    class="md:hidden w-[300px] block text-center mb-4 mx-5 my-3 border border-[#f3b6b6] bg-[#fff1f1] text-[#D94647] font-semibold uppercase tracking-[0.10em] py-3 rounded-[2px]">
                    <?php echo e(translate('Donate Refugees')); ?>

                </a>

                <!-- BODY -->
                <div class="px-5 md:px-8 md:pt-5 pb-6">

                    <!-- ✅ MOBILE: Donate button under header (only mobile) -->
                     <?php
                        $icons = App\Models\Sponsor::where('type', 'campaign_icon')->latest()->get();
                    ?>

                    <div class="flex flex-wrap items-center gap-4 md:gap-6 mb-4 text-[12px] text-gray-700 justify-center md:justify-start">
                        <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button"
                                class="flex items-center gap-2 focus:outline-none"
                                onclick="openCertModal(
                                    <?php echo \Illuminate\Support\Js::from($icon->title ?? $icon->company_name ?? 'Certified')->toHtml() ?>,
                                    <?php echo \Illuminate\Support\Js::from($icon->sub_title ?? '')->toHtml() ?>,
                                    <?php echo \Illuminate\Support\Js::from($icon->content ?? '')->toHtml() ?>,
                                    <?php echo \Illuminate\Support\Js::from(asset('storage/company_logo/'.$icon->company_logo))->toHtml() ?>,
                                    <?php echo \Illuminate\Support\Js::from($icon->website_link ?? '')->toHtml() ?>
                                )">

                                
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-200 overflow-hidden">
                                    <img
                                        src="<?php echo e(asset('storage/company_logo/'.$icon->company_logo)); ?>"
                                        alt="<?php echo e($icon->title ?? $icon->company_name ?? 'Certification'); ?>" title="<?php echo e($icon->title ?? $icon->company_name ?? 'Certification'); ?>"
                                        class="w-full h-full object-contain p-1">
                                </span>

                                
                                <span class="font-medium text-gray-700">
                                    <?php echo e($icon->title ?? $icon->company_name ?? 'Certified'); ?>

                                </span>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                      <?php echo $__env->make('frontend.includes.campaign_det_img', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <!-- TITLE -->
                    <h2 class="text-[22px] sm:text-[26px] md:text-[30px] font-semibold leading-tight text-[#3e3e3e]">
                    <?php if(!empty($donation_campaigns->short_description)): ?> 
                        <?php echo $donation_campaigns->short_description; ?>

                    <?php elseif(!empty($setting->donate_subtitle)): ?>
                        <?php echo $setting->donate_subtitle; ?>

                    <?php endif; ?>
                    </h2>

                    <!-- TEXT -->
                    <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">
                    <?php if(!empty($donation_campaigns->paragraph_one)): ?> 
                        <?php echo $donation_campaigns->paragraph_one; ?>

                    <?php elseif(!empty($setting->donate_description)): ?> 
                        <?php echo $setting->donate_description; ?>

                    <?php endif; ?>
                    </p>
                    <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">
                    <?php if(!empty($donation_campaigns->paragraph_two)): ?> 
                        <?php echo $donation_campaigns->paragraph_two; ?>

                    <?php endif; ?>
                    </p>

                </div>
            </div>


            <div class="bg-white shadow-md border border-gray-200 mx-2 md:mx-0 lg:mx-0 overflow-hidden rounded-[4px]">
                <div class="grid md:grid-cols-2">

                    <!-- LEFT (RED) -->
                    <div class="bg-[#ff6b6b] text-white px-6 md:px-8 py-6 md:py-8">
                    <h2 class="text-[22px] sm:text-[26px] md:text-[28px] leading-tight uppercase">
                         <?php echo translate('DONATIONS ARE 100% SECURE'); ?>

                    </h2>


                    <?php 
                        $certifications = App\Models\Sponsor::where('type', 'certifications')->latest()->get();
                    ?>

                    </div>

                    <!-- RIGHT (WHITE) -->
                    <div class="bg-white px-6 md:px-8 py-6 md:py-8 border-t md:border-t-0 md:border-l border-gray-200">
                    <p class="text-center text-slate-600 text-[13px] md:text-[14px] leading-snug">
                         <?php echo translate('OUR CERTIFICATIONS'); ?>

                    </p> 

                    <!-- service icons / placeholders -->
                    <div class="mt-6 grid grid-cols-4 gap-3 justify-items-center">
                        <?php $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/company_logo/'.$item->company_logo)); ?>" class="object-contain" style="height:150px; width:150px;" alt="<?php echo e($item->title ?? $item->company_name ?? 'Certification'); ?>" title="<?php echo e($item->title ?? $item->company_name ?? 'Certification'); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- যদি আপনার কাছে payment logos থাকে, উপরের placeholder এর বদলে এটা দিন -->
                    <!-- <div class="mt-6 grid grid-cols-4 gap-5 items-center justify-items-center">
                        <img src="<?php echo e(asset('images/payments/paypal.png')); ?>" class="h-10 w-auto opacity-80" alt="PayPal">
                        <img src="<?php echo e(asset('images/payments/stripe.png')); ?>" class="h-10 w-auto opacity-80" alt="Stripe">
                        <img src="<?php echo e(asset('images/payments/applepay.png')); ?>" class="h-10 w-auto opacity-80" alt="Apple Pay">
                        <img src="<?php echo e(asset('images/payments/googlepay.png')); ?>" class="h-10 w-auto opacity-80" alt="Google Pay">
                    </div> -->
                    </div>

                </div>
            </div>

        </article>
</div>

        
       <aside id="donationSideBar" class="hidden md:block space-y-14 donationSideBar">
        <button id="backBtn" class="md:hidden w-full border px-4 py-3 rounded">
             <?php echo e(translate('Back')); ?>

        </button>


           <div class="">
                <?php if(!empty($donation_campaigns->donation_box)): ?>
                    <section class="space-y-2- prose max-w-none">
                        <?php echo $donation_campaigns->donation_box; ?>

                    </section>
                <?php elseif(!empty($setting->global_donorbox_code)): ?>
                    <section class="space-y-2- prose max-w-none">
                        <?php echo $setting->global_donorbox_code; ?>

                    </section>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</section> 


    <?php echo $__env->make('frontend.includes.news_letter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

     <div class="py-5 bg-[#f6f6f6]"> 
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

            // sidebar content
            sidebarPanels.forEach(panel => {
                const name = panel.getAttribute('data-sidebar-panel');
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
function openCertModal(title, subTitle, content, imgUrl, websiteLink) {
    const modal = document.getElementById('certModal');

    document.getElementById('certModalTitle').textContent = title || '';
    document.getElementById('certModalSubTitle').textContent = subTitle || '';
    document.getElementById('certModalContent').textContent = content || '';

    const img = document.getElementById('certModalImg');
    img.src = imgUrl || '';
    img.alt = title || 'Certification';

    const link = document.getElementById('certModalLink');

    // ✅ website_link থাকলে show, না থাকলে hide
    if (websiteLink && websiteLink.trim() !== '') {
        link.href = websiteLink;
        link.classList.remove('hidden');
    } else {
        link.href = '#';
        link.classList.add('hidden');
    }

    modal.classList.remove('hidden');

    // ESC close
    document.addEventListener('keydown', certEscClose);
}

function closeCertModal() {
    document.getElementById('certModal').classList.add('hidden');
    document.removeEventListener('keydown', certEscClose);
}

function certEscClose(e){
    if(e.key === 'Escape') closeCertModal();
}
</script>



<script>
  document.addEventListener("DOMContentLoaded", () => {
    const donateBtn = document.getElementById("donateBtn");
    const mainDiv = document.getElementById("mainDiv");
    const donationSideBar = document.getElementById("donationSideBar");

    donateBtn?.addEventListener("click", () => {
      // hide main
      mainDiv?.classList.add("hidden");

      // show sidebar (mobile এ দেখাতে md:block না দিয়ে block দিচ্ছি)
      donationSideBar?.classList.remove("hidden");
      donationSideBar?.classList.add("block");
    });

    const backBtn = document.getElementById("backBtn");
        backBtn?.addEventListener("click", () => {
        mainDiv?.classList.remove("hidden");
        donationSideBar?.classList.add("hidden");
        donationSideBar?.classList.remove("block");
    });

  });
</script>



<?php $__env->stopSection(); ?> 
<?php echo $__env->make('frontend.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/frontend/donation.blade.php ENDPATH**/ ?>