extends('frontend.layouts.master')


@section('title', $donation_campaigns->meta_title ?? translate('Donation Campaigns meta title'))
@section('meta_description', $donation_campaigns->meta_description ?? translate('donation campaign meta description'))
@section('meta_keyword',  $donation_campaigns->meta_keyword ?? translate('donation page meta keyword'))

@section('meta')
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- Open Graph --}}
  <meta property="og:title" content="{{ $donation_campaigns->og_title }}">
  <meta property="og:description" content="{{ $donation_campaigns->og_description }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ asset('storage/og_image/'.$donation_campaigns->og_image) }}">

  {{-- Twitter --}}
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $donation_campaigns->og_title }}">
  <meta name="twitter:description" content="{{ $donation_campaigns->og_description }}"> 
  <meta name="twitter:image" content="{{ asset('storage/og_image/'.$donation_campaigns->og_image) }}"> 
@endsection



@section('frontend')



<!-- ========= EXTRA CSS FOR TABS ========= -->
<style>
    .tab-active   { background:#e54545; color:#ffffff; }
    .tab-inactive { background:#f1f1f1; color:#d3564f; }
</style>

{{-- HERO SECTION --}}
<section id="top" class="pt-4 pb-10 bg-[#f5f5f5]- -mt-10 md:-mt-36 relative z-0">
  <div  class="relative rounded-sm overflow-hidden shadow-lg bg-no-repeat bg-cover bg-center"
    style="background-image: url('{{ !empty($donation_campaigns?->cover_image) ? asset('storage/cover_image/'.$donation_campaigns->cover_image) : asset('storage/donate_hero_image/'.$setting->donate_hero_image) }}'); height: 600px;" >
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



{{-- MAIN SECTION --}}
<section class="pb-20 -mt-48 relative z-10"> 
    <div class="max-w-7xl md:mx-auto md:px-4 grid lg:grid-cols-[3fr,1fr] gap-6">

       <div class="space-y-6">
        <span class="inline-flex w-fit shrink-0 px-6 py-1 font-semibold rounded-tr-lg rounded-bl-lg bg-[#D94647] text-white ml-2">
            {{ $donation_campaigns->tag_line ?? $setting->tag_line }}
        </span>

        {{-- LEFT SIDE --}}
        <article id="mainDiv" class="mainDiv overflow-visible space-y-12">

            {{-- CARD 1 : TITLE + BADGES --}}
           <!-- ✅ RESPONSIVE CARD (desktop + mobile like screenshot) -->
            <div class="bg-white shadow-md border border-gray-200 overflow-hidden  mx-2 md:mx-0 rounded-[4px]">

               
                <!-- TOP RED HEADER -->
                <div class="relative bg-[#D94647] text-white px-2 md:px-8 py-3 overflow-hidden">
                    <h1 class="px-5 md:px-8 text-[22px] sm:text-[26px] md:text-[34px] lg:text-[40px]  font-bold uppercase leading-tight">
                    @if(!empty($donation_campaigns->title))
                        {!! $donation_campaigns->title !!}
                    @elseif(!empty($setting->donate_title))
                        {!! $setting->donate_title !!}
                    @endif
                    </h1>

                    <!-- right ribbon (blue + yellow) -->
                    <div class="absolute top-0 -right-2 hidden w-16 h-full md:block">
                        <div class="absolute inset-y-0 right-5 w-7 bg-[#2261aa] skew-x-[42deg]">  </div>
                        <div class="absolute inset-y-0 right-0 w-6 bg-[#fff0a1] skew-x-[42deg]">  </div>
                    </div>
                </div>

                <a href="javascript:void(0)"  id="donateBtn"
                    class="md:hidden w-[300px] block text-center mb-4 mx-5 my-3 border border-[#f3b6b6] bg-[#fff1f1] text-[#D94647] font-semibold uppercase tracking-[0.10em] py-3 rounded-[2px]">
                    {{ translate('Donate Refugees') }}
                </a>

                <!-- BODY -->
                <div class="px-5 md:px-8 md:pt-5 pb-6">

                    <!-- ✅ MOBILE: Donate button under header (only mobile) -->
                     @php
                        $icons = App\Models\Sponsor::where('type', 'campaign_icon')->latest()->get();
                    @endphp

                    <div class="flex flex-wrap items-center gap-4 md:gap-6 mb-4 text-[12px] text-gray-700 justify-center md:justify-start">
                        @foreach($icons as $icon)
                            <button type="button"
                                class="flex items-center gap-2 focus:outline-none"
                                onclick="openCertModal(
                                    @js($icon->title ?? $icon->company_name ?? 'Certified'),
                                    @js($icon->sub_title ?? ''),
                                    @js($icon->content ?? ''),
                                    @js(asset('storage/company_logo/'.$icon->company_logo)),
                                    @js($icon->website_link ?? '')
                                )">

                                {{-- Round icon image --}}
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-200 overflow-hidden">
                                    <img
                                        src="{{ asset('storage/company_logo/'.$icon->company_logo) }}"
                                        alt="{{ $icon->title ?? $icon->company_name ?? 'Certification' }}" title="{{ $icon->title ?? $icon->company_name ?? 'Certification' }}"
                                        class="w-full h-full object-contain p-1">
                                </span>

                                {{-- Title --}}
                                <span class="font-medium text-gray-700">
                                    {{ $icon->title ?? $icon->company_name ?? 'Certified' }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                      @include('frontend.includes.campaign_det_img')

                    <!-- TITLE -->
                    <h2 class="text-[22px] sm:text-[26px] md:text-[30px] font-semibold leading-tight text-[#3e3e3e]">
                    @if(!empty($donation_campaigns->short_description)) 
                        {!! $donation_campaigns->short_description !!}
                    @elseif(!empty($setting->donate_subtitle))
                        {!! $setting->donate_subtitle !!}
                    @endif
                    </h2>

                    <!-- TEXT -->
                    <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">
                    @if(!empty($donation_campaigns->paragraph_one)) 
                        {!! $donation_campaigns->paragraph_one !!}
                    @elseif(!empty($setting->donate_description)) 
                        {!! $setting->donate_description !!}
                    @endif
                    </p>
                    <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">
                    @if(!empty($donation_campaigns->paragraph_two)) 
                        {!! $donation_campaigns->paragraph_two !!}
                    @endif
                    </p>

                </div>
            </div>


            <div class="bg-white shadow-md border border-gray-200 mx-2 md:mx-0 lg:mx-0 overflow-hidden rounded-[4px]">
                <div class="grid md:grid-cols-2">

                    <!-- LEFT (RED) -->
                    <div class="bg-[#ff6b6b] text-white px-6 md:px-8 py-6 md:py-8">
                    <h2 class="text-[22px] sm:text-[26px] md:text-[28px] leading-tight uppercase">
                         {!! translate('DONATIONS ARE 100% SECURE') !!}
                    </h2>


                    @php 
                        $certifications = App\Models\Sponsor::where('type', 'certifications')->latest()->get();
                    @endphp

                    </div>

                    <!-- RIGHT (WHITE) -->
                    <div class="bg-white px-6 md:px-8 py-6 md:py-8 border-t md:border-t-0 md:border-l border-gray-200">
                    <p class="text-center text-slate-600 text-[13px] md:text-[14px] leading-snug">
                         {!! translate('OUR CERTIFICATIONS') !!}
                    </p> 

                    <!-- service icons / placeholders -->
                    <div class="mt-6 grid grid-cols-4 gap-3 justify-items-center">
                        @foreach($certifications as $item)
                        <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}" class="object-contain" style="height:150px; width:150px;" alt="{{ $item->title ?? $item->company_name ?? 'Certification' }}" title="{{ $item->title ?? $item->company_name ?? 'Certification' }}">
                        @endforeach
                    </div>

                    <!-- যদি আপনার কাছে payment logos থাকে, উপরের placeholder এর বদলে এটা দিন -->
                    <!-- <div class="mt-6 grid grid-cols-4 gap-5 items-center justify-items-center">
                        <img src="{{ asset('images/payments/paypal.png') }}" class="h-10 w-auto opacity-80" alt="PayPal">
                        <img src="{{ asset('images/payments/stripe.png') }}" class="h-10 w-auto opacity-80" alt="Stripe">
                        <img src="{{ asset('images/payments/applepay.png') }}" class="h-10 w-auto opacity-80" alt="Apple Pay">
                        <img src="{{ asset('images/payments/googlepay.png') }}" class="h-10 w-auto opacity-80" alt="Google Pay">
                    </div> -->
                    </div>

                </div>
            </div>

        </article>
</div>

        {{-- RIGHT SIDE / SIDEBAR --}}
       <aside id="donationSideBar" class="hidden md:block space-y-14 donationSideBar">
        <button id="backBtn" class="md:hidden w-full border px-4 py-3 rounded">
             {{ translate('Back') }}
        </button>


           <div class="">
                @if(!empty($donation_campaigns->donation_box))
                    <section class="space-y-2- prose max-w-none">
                        {!! $donation_campaigns->donation_box !!}
                    </section>
                @elseif(!empty($setting->global_donorbox_code))
                    <section class="space-y-2- prose max-w-none">
                        {!! $setting->global_donorbox_code !!}
                    </section>
                @endif
            </div>
        </aside>
    </div>
</section> 


    @include('frontend.includes.news_letter')

     <div class="py-5 bg-[#f6f6f6]"> 
      @include('frontend.includes.scroll_element')
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



@endsection 