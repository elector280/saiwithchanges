@extends('frontend.layouts.master')

@section('title',  $setting->title ?? translate('Home page meta title'))
@section('meta_description',  $setting->subtitle ?? translate('Home page meta description'))
@section('meta_keyword',  $setting->meta_keyword ?? translate('Home page meta keyword'))
 

@section('meta')
  <link rel="canonical" href="{{ url()->current() }}">
  {{-- Open Graph --}}
  <meta property="og:title" content="{{ translate('Home page og:title') }}">
  <meta property="og:description" content="{{ translate('Home page og:description') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ asset('storage/logo/'.$setting->logo) }}">

 
  {{-- Twitter --}}
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ translate('Home page og:title') }}">
  <meta name="twitter:description" content="{{ translate('Home page og:description') }}"> 
  <meta name="twitter:image" content="{{ asset('storage/logo/'.$setting->logo) }}">
@endsection


@section('css')
    <style>
        /* Desktop: subject আরও ডানে যাবে */
        @media (min-width: 1024px) {
            #heroSection {
                background-position: 50% center;
                /* 48-55% এর মধ্যে খেললেই perfect হবে */
            }
        }
    </style>
@endsection

@section('frontend')

    @php
    $heroSlides = [];

    foreach ($sliders as $slider) {
        $heroSlides[] = [
            'title'    => $slider->localeTitleShow(),
            'subtitle' => $slider->localeSubTitleShow(),
            'button'   => $slider->localeBtnTextShow(),
            'label'    => 'Explore Campaigns',
            'image'    => asset('storage/sliders/' . $slider->bg_image),
            'url'      => $slider->btn_link ?? '',
            'target'   => ($slider->btn_link ? '_blank' : '_self'),
        ];
    }
@endphp



<section id="heroSection"  class="relative overflow-hidden text-white -mt-36 w-full h-[700px] md:min-h-[800px] lg:min-h-[800px]"  style="background-repeat:no-repeat; background-size:cover; background-position:58% center;">
    <div class="absolute inset-0 pointer-events-none"></div>

    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-r from-[#f1675f]/30 via-[#f1675f]/15 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#f1675f]/12 via-transparent to-transparent"></div>
    </div>

    
    <div class="absolute inset-0 z-[99] pointer-events-none flex items-center justify-center top-[380px] md:top-[200px] right-20 md:right-80">
        <img src="{{ asset('images/google-map.png') }}"  class="select-none opacity-90 pointer-events-none
                    h-[400px] sm:h-[360px] md:h-[380px] lg:h-[460px]  w-auto object-contain" />
    </div>

    
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


    <div class="relative z-[120] h-full max-w-6xl px-4 pt-20 pb-32 mx-auto lg:pt-28">
        <div class="grid items-center h-full gap-10 lg:grid-cols-2 mt-[280px] md:mt-[100px]"> 
            <div>
                <h1 id="heroTitle" class="text-4xl leading-none font-semibold- lg:text-[44px]">
                    SOUTH <br />AMERICAN<br /> INITIATIVE
                </h1>
                <p id="heroSubtitle" class="hidden sm:block  max-w-xl mt-6 text-lg lg:text-3xl">
                    We are a Non Profit in Venezuela <br />
                    and South America with 30+ <br />
                    active Humanitarian Campaigns.
                </p> <br>
                <a id="heroButton"
                    href="#"
                    class="sm:inline-block min-w-[280px] px-6 py-2 mt-6 text-xs font-semibold uppercase bg-white rounded-sm text-red-500 lg:text-sm text-center relative z-[130] pointer-events-auto">
                </a>
                <p class="mt-3 text-md lg:text-xs">
                    &gt; Certified Donation Partner for US Tax Deductions
                </p>
            </div>
            <div class="hidden lg:block"></div>
        </div>
    </div>

    
    <div class="absolute inset-x-0 bottom-40 hidden sm:block z-[250] pointer-events-none">
  <div class="flex flex-col items-center pointer-events-none">

    <!-- ✅ ONLY this bar is clickable -->
    <div class="flex items-center px-6 py-3 border-white/60 shadow-lg text-[11px] uppercase tracking-[0.20em] text-white pointer-events-auto">
      <button id="heroPrev" type="button"
        class="flex items-center justify-center mr-4 w-9 h-9 text-[#fff] text-6xl font-semibold hover:text-white transition">
        &#8249;
      </button>

      <span id="heroControlLabel" class="mx-2 font-semibold">
        {{ translate('Explore Campaigns') }}
      </span>

      <button id="heroNext" type="button"
        class="flex items-center justify-center ml-4 w-9 h-9 text-[#fff] text-6xl font-semibold hover:text-white transition">
        &#8250;
      </button>
    </div>

    <!-- ✅ ONLY dots are clickable -->
    <div id="heroDots" class="flex items-center gap-2 mt-2 pointer-events-auto"></div>

  </div>
</div>

</div>

</section>

    <section class="relative z-10 mt-6 md:hidden">
        <div class="max-w-sm px-4 mx-auto-">
            <article class="px-2 pb-4">

                <p class="mt-3 text-xl leading-relaxed text-slate-600 text-[#e95858]">
                    {!! translate('We are a No Profit') !!}
                </p>

                <a href="https://sai.mitwebsolutions.com/project/help-venezuelan-orphans" class="mt-5 w-full inline-flex items-center justify-center
                        bg-[#e13b35] text-white text-[11px] font-semibold  uppercase py-3 rounded-md">
                     {{ translate('Donate Orphans') }} &gt;
                </a>
            </article>
        </div>
    </section>

    <!-- ================= URGENT FUNDRAISINGS ================= -->
     <section class="relative z-20 pb-5 md:-mt-36">
         <div class="md:px-4- md:mx-auto max-w-7xl lg:px-10-">
            <div class="bg-[#E95858]  rounded-tl-[14px] rounded-tr-[14px]  rounded-bl-none rounded-br-none shadow-2xl overflow-hidden md:h-[400px]"></div>
            <div class="overflow-hidden md:rounded-[26px] md:-mt-[400px] bg-[#E95858] md:bg-transparent">

                <!-- উপরের হেডার অংশ (ডার্ক লাল) -->
                <div class="text-white text-center px-4 py-3">
                    <h2 class="text-xl lg:text-2xl font-semibold- tracking-[0.08em] uppercase">
                           {{ translate('Help Us Help Others') }}
                    </h2>
                    <p class="mt-1 text-sm lg:text-lg">
                         {{ translate('Urgent Fundraisings') }}
                    </p>
                </div>


                <!-- নিচের কার্ড অংশ (হালকা লাল) -->
                <div class="px-4 md:px-5 py-5- text-white lg:px-10 lg:py-10-">

                    <div class="grid gap-6 md:grid-cols-3">



@foreach ($campaigns as $item)

    @php
        $locale = session('locale', config('app.locale'));

        $path = $locale === 'es'
            ? ($item->getTranslation('path', 'es', false) ?: $item->getTranslation('path', 'en', false))
            : ($item->getTranslation('path', 'en', false) ?: $item->getTranslation('path', 'es', false));

        $slug = $locale === 'es'
            ? ($item->getTranslation('slug', 'es', false) ?: $item->getTranslation('slug', 'en', false))
            : ($item->getTranslation('slug', 'en', false) ?: $item->getTranslation('slug', 'es', false));
    @endphp

    <article class="relative flex flex-col rounded-tl-[14px] rounded-tr-[14px] 
            rounded-bl-none rounded-br-none bg-[#FE6668] shadow-xl overflow-hidden">

        <div class="relative">
            <img src="{{ asset('storage/hero_image/'.$item->hero_image) }}" alt="{{ $item->title }}"
                class="object-cover w-full h-56" />
            <div title="{{ $item->title }}"
                class="absolute px-5 py-2 text-lg font-semibold text-center
                    -translate-x-1/2 bg-white shadow-md -bottom-0 left-1/2
                    text-slate-900 rounded-tr-md rounded-tl-md whitespace-nowrap">

                <span class="block md:hidden" title="{{ $item->title }}">
                    {{ \Illuminate\Support\Str::limit($item->title ?? '', 15) }}
                </span>

                <span class="hidden md:block" title="{{ $item->title }}">
                    {{ \Illuminate\Support\Str::limit($item->title ?? '', 20) }}
                </span>
            </div>
        </div>

        <div class="flex flex-col flex-1 px-6 pb-6 pt-9 text-md text-white/95">
            <p class="leading-relaxed">
                {{ \Illuminate\Support\Str::limit($item->sub_title ?? '', 100) }}
            </p>
        </div>

        <div class="text-center mb-5 md:mb-8 px-4">
            @if($path && $slug)
                <a href="{{ $locale === 'es'
                        ? route('campaignsdetailsEsDyn', ['path' => $path, 'slug' => $slug])
                        : route('campaignsdetailsDyn', ['path' => $path, 'slug' => $slug]) }}"
                    class="block w-full py-2 px-5 mt-4 text-sm font-semibold tracking-widest uppercase 
                        bg-white border shadow-md text-red-500 border-white/60">
                    {{ translate('Donate') }} &gt;
                </a>
            @endif
        </div>

        <div class="h-[10px] w-full" style="background-color: {{ $item->bg_color ?? '#FFE36B' }};"></div>
    </article>
@endforeach
                    </div>

                    <div class="mt-2 text-lg text-right underline hidden md:block">
                        <a href="{{ session('locale', config('app.locale')) === 'en' ? route('campaigns') : route('campaignsEs') }}" class="text-[#FE6668] mr-4"> {{ translate('Explore all Campaigns') }}</a>
                    </div>

                    <div class="mt-2 text-lg text-center underline block md:hidden py-3 text-white">
                        <a href="{{ session('locale', config('app.locale')) === 'en' ? route('campaigns') : route('campaignsEs') }}"
                        class="text-white">
                            {{ translate('Explore Campaigns') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ========== OUR SPONSORS (AUTO SLIDE) ========== -->
    @include('frontend.includes.our_sponsors')

    <section class="pb-4 bg-[#f4f4f4]">
        <div class="relative max-w-7xl px-3 md:px-0 lg:px-0 mx-auto">
            <!-- BIG ABOUT CARD -->
            <div class="relative overflow-hidden py-12 lg:py-16
                        grid lg:grid-cols-[1.2fr,1fr] gap-10">

                <!-- HARD TOP RED GRADIENT GLOW -->
                <div class="pointer-events-none absolute top-0 left-1/2 -translate-x-1/2
                            w-[50%] h-[50px]
                            bg-gradient-to-b
                            from-[#e13b35]/55
                            via-[#e13b35]/30
                            to-transparent
                            blur-xl">
                </div>

                <!-- LEFT CONTENT -->
                <div class="relative z-10 max-w-xl">

                    <p class="text-sm uppercase tracking-widest text-[#e13b35]">
                        {{ translate('ABOUT US') }}
                    </p>

                    <h3 class="mt-4- text-[32px] lg:text-[42px] text-bold
                            leading-tight 
                            text-slate-900 uppercase">
                        {!! $setting->about_us_title_home !!} 
                    </h3>

                    <div class="mt-5- text-[15px] leading-relaxed text-slate-600 whitespace-pre-line">
                        {!! $setting->about_us_content_home !!}
                    </div>

                    <a href="{{ $setting->about_us_btn_home }}"
                    class="mt-8 inline-flex items-center justify-center
                            border border-[#e13b35]
                            text-[#e13b35] text-[12px] font-semibold
                            uppercase tracking-widest
                            px-8 py-2 transition
                             "  style="border: 1px solid red !important;">
                        {{ translate('Discover More') }} &gt;
                    </a>

                </div>

                <!-- RIGHT IMAGE -->
                <div class="relative z-10 flex justify-end">
                    <div class="overflow-hidden rounded-lg shadow-lg-">
                        <img src="{{ asset('storage/about_us_cover_image_home/' . $setting->about_us_cover_image_home) }}"
                            alt="{{ translate('Volunteers helping') }}" class="object-cover md:w-full md:h-full lg:w-[420px] lg:h-[480px]" />
                    </div>
                </div>
            </div>


            <!-- OUR VALUES -->
            @include('frontend.includes.our_values')


            <!-- ============ OUR CERTIFICATIONS (নতুন ব্লক) ============ -->
           <div class="mt-3 pt-5 pb-14 bg-[#f6f6f6] hidden sm:block">

                <div class="max-w-4xl px-4 mx-auto text-center">
                    <h3 class="text-2xl lg:text-[22px] font-bold uppercase text-[#e13b35]">
                         {{ translate('OUR CERTIFICATIONS') }}
                    </h3>



                    <!-- নিচের পাতলা লাল লাইন -->
                    <div class="mt-3 mx-auto w-24 h-[3px] bg-[#e13b35]/80 rounded-full"></div>

                    <!-- ব্যাজগুলো -->
                    <div class="flex flex-wrap items-end justify-center gap-10 mt-10">
                        @foreach($certifications as $item)
                        <div class="inline-flex items-center justify-center">
                            <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}" alt="{{ $item->company_name }}"
                                class="h-20 w-auto object-contain drop-shadow-[0_8px_18px_rgba(0,0,0,0.25)]" />
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ================= ARTICLES ================= -->
    <section class="py-10 lg:py-12 bg-[#FD6768] text-white bg-no-repeat bg-right-top bg-none lg:bg-[url('{{ asset('images/google-map.png') }}')] lg:bg-[length:500px]">
        <div class="max-w-7xl  mx-auto">

            <div class="pt-6 mt-4 px-4 sm:px-6 md:px-8 lg:px-0 border-t border-white/40">
                <div class="grid grid-cols-1 items-start gap-1 md:gap-8 lg:grid-cols-3 lg:gap-6">

                    {{-- Heading: tablet & desktop আলাদা sizing --}}
                    <!-- Mobile (default - <sm) -->
<h2 class="block sm:hidden uppercase text-white font-semibold tracking-[0.04em]
        text-xl leading-snug">
  {!! translate('ARTICLES NEWS FROM ONGOING CAMPAIGNS') !!}
</h2>

<!-- Tablet (sm to lg-1) -->
<h2 class="hidden sm:block lg:hidden uppercase text-white font-semibold tracking-[0.04em]
        text-2xl leading-snug">
  {!! translate('ARTICLES NEWS FROM ONGOING CAMPAIGNS') !!}
</h2>

<!-- Desktop (lg+) -->
<h2 class="hidden lg:block uppercase text-white font-semibold tracking-[0.04em]
        text-3xl leading-tight lg:col-span-1">
  {!! translate('ARTICLES &amp; NEWS<br /> FROM ONGOING<br /> CAMPAIGNS') !!}
</h2>



                    {{-- Content: desktop এ right side (col-span-2), tablet এ full width --}}
                    <div class="text-white text-sm sm:text-base md:text-lg lg:text-xl lg:col-span-2">

                        <p class="text-white/85 whitespace-pre-line">
                            @if(!empty($setting->article_news_content))
                                {!! $setting->article_news_content !!}
                            @endif
                        </p>

                        {{-- Link: tablet & desktop আলাদা size --}}
                        <a href="{{ route('news') }}"
                        class="mt-4 inline-block font-semibold text-[#ffe78a]
                                underline underline-offset-2
                                text-lg md:text-xl lg:text-2xl">
                            {{ translate('See all Articles') }}&gt;
                        </a>
                    </div>

                </div>
            </div>

            <!-- cards -->
            @include('frontend.includes.articles_news')

            <a href="{{ route('news') }}"
                class="block sm:hidden  pl-4 md:pl-0 lg:pl-0 mt-4 inline-block text-2xl lg:text-2xl font-semibold text-[#ffe78a] underline underline-offset-2">
                    {{ translate('See all Articles') }}&gt;
            </a>

        </div>
    </section>



 <section class="py-2 lg:py-16 bg-[#f6f6f6] overflow-hidden">
    <!-- ✅ Heading area: 6xl -->
    <div class="max-w-6xl mx-auto px-3">
        <div class="border-t border-white/40 pt-0 mt-0 md:pt-6 md:mt-4">
            <div class="grid gap-0 md:gap-6 lg:grid-cols-[1.3fr,1fr] items-start">
                
                <!-- LEFT BIG TITLE -->
                <div class="space-y-1 md:space-y-2">
                    <h2 class="text-xl sm:text-xl lg:text-[32px] leading-tight font-bold uppercase text-[#e13b35] whitespace-pre-line">
                        @if(!empty($setting->review_title))
                            {!! $setting->review_title !!}
                        @endif
                    </h2>

                    <h2 class="text-2xl sm:text-2xl lg:text-4xl font-semibold leading-tight uppercase mt-0 md:mt-2 whitespace-pre-line">
                        @if(!empty($setting->review_sub_title))
                            {!! $setting->review_sub_title !!}
                        @endif
                    </h2>
                </div>

                <!-- RIGHT TEXT -->
                <div class="text-sm sm:text-base lg:text-xl text-[#8b8b8b] mt-2 md:mt-0">
                    <p class="leading-relaxed whitespace-pre-line m-0">
                        @if(!empty($setting->review_content))
                            {!! $setting->review_content !!}
                        @endif
                    </p>
                </div>

            </div>
        </div>
    </div>


    <!-- ===== DATA ===== -->
    @php

        $reviewsData = $reviews
            ->map(function ($r) {
                $name = $r->name ?? 'Anonymous';

                $mainImg = $r->image
                    ? (str_starts_with($r->image, 'http')
                        ? $r->image
                        : asset('storage/review_image/' . $r->image))
                    : asset('images/hosp21.jpg');

                $profileImg = $r->profile_image
                    ? (str_starts_with($r->profile_image, 'http')
                        ? $r->profile_image
                        : asset('storage/review_image/' . $r->profile_image))
                    : null;

                return [
                    'name' => $name,
                    'initial' => mb_substr($name, 0, 1),
                    'text' => strip_tags($r->description ?? ''),
                    'img' => $mainImg,
                    'profileImage' => $profileImg,
                ];
            })
            ->values();
    @endphp

    <!-- ✅ Slider wrapper: 7xl + cropped sides only on desktop -->
    <div class="mt-10 lg:mt-12" id="reviewsWrapper">
        <div class="max-w-7xl mx-auto px-3 overflow-hidden">

         <div class="flex justify-center mt-8 lg:mt-10 mb-3 block md:hidden">
                <div class="flex items-center select-none gap-8 sm:gap-14 text-slate-600">
                    <button id="reviewsPrev" type="button" class="text-3xl leading-none hover:text-slate-900">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <span class="uppercase tracking-[0.28em] sm:tracking-[0.35em] text-[12px] sm:text-[13px] font-semibold">
                        {{ translate('Read Reviews') }}
                    </span>

                    <button id="reviewsNext" type="button" class="text-3xl leading-none hover:text-slate-900">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- desktop এ crop, mobile এ no crop -->
            <div class="lg:-mx-28">
                <div class="grid items-stretch gap-6 lg:gap-10 lg:grid-cols-[260px,minmax(0,1fr),300px]">

                    <!-- LEFT preview (desktop only) -->
                    <div class="hidden lg:block">
                        <div class="h-[240px] rounded-xl shadow-md overflow-hidden bg-white/70 opacity-60">
                            <img id="ghostLeftImg" src="{{ asset('images/hosp21.jpg') }}"
                                 class="object-cover w-full h-full" alt="Left preview">
                        </div>
                    </div>

                    <!-- CENTER main card (mobile: stacked, desktop: split) -->
                    <div class="min-w-0 bg-white rounded-xl shadow-xl overflow-hidden
                                grid grid-rows-[240px,auto]
                                lg:grid-rows-none lg:grid-cols-[1.15fr,1fr] min-h-[340px]">

                        <!-- image (mobile top) -->
                        <div class="relative lg:order-2">
                            <img id="reviewImage" src="{{ asset('images/hosp21.jpg') }}"
                                 class="object-cover w-full h-full" alt="Review image" />
                        </div>

                        <!-- text (mobile bottom) -->
                        <article class="relative p-6 lg:p-10 lg:order-1">
                            <span class="absolute left-6 top-6 text-4xl text-[#f4b3b3] leading-none">&ldquo;</span>
                            <span class="absolute right-6 bottom-6 text-4xl text-[#f4b3b3] leading-none">&rdquo;</span>

                            <div class="flex items-center gap-4">
                                <div id="reviewAvatar"
                                     class="w-12 h-12 rounded-full bg-[#ffe1e1] overflow-hidden
                                            flex items-center justify-center font-bold text-[#e13b35]">
                                    <span id="reviewInitial">M</span>
                                    <img id="reviewProfileImg" src=""
                                         class="hidden w-full h-full object-cover" alt="Profile">
                                </div>

                                <p id="reviewName" class="font-bold text-[18px] text-slate-900">Martha L.</p>
                            </div>

                            <p id="reviewText" class="mt-5 text-[15px] leading-relaxed text-slate-700">
                                ...
                            </p>

                            <a href="{{ route('donation') }}"
                               class="mt-6 inline-flex items-center justify-center border border-[#e13b35] text-[#e13b35]
                                      text-[11px] font-semibold uppercase tracking-[0.16em]- px-10 py-2.5 rounded-sm w-full" style="border: 1px solid red !important;">
                                {{ translate('Donate to this campaign') }}
                            </a>
                        </article>
                    </div>

                    <!-- RIGHT preview (desktop only) -->
                    <div class="hidden lg:block">
                        <div class="h-[240px] rounded-xl shadow-md overflow-hidden bg-white/70 opacity-60">
                            <div class="flex flex-col justify-center w-full h-full px-8 py-8">
                                <div class="text-[#f4b3b3] text-4xl leading-none">&ldquo;</div>

                                <div class="mt-6 space-y-3">
                                    <div class="h-3 w-[75%] bg-slate-200 rounded"></div>
                                    <div class="h-3 w-[90%] bg-slate-200 rounded"></div>
                                    <div class="h-3 w-[82%] bg-slate-200 rounded"></div>
                                    <div class="h-3 w-[88%] bg-slate-200 rounded"></div>
                                </div>

                                <div class="flex items-center gap-3 mt-10">
                                    <div class="w-10 h-10 rounded-full bg-[#ffe1e1]"></div>
                                    <div class="w-24 h-3 rounded bg-slate-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


    <!-- ================= OUR NUMBERS (IMAGE CLONE) ================= -->
    <section class="py-5 bg-[#f3f3f3]">
        <div class="max-w-6xl px-3- md:px-0 mx-auto">
            @include('frontend.includes.our_number_section')
        
        <div class="border-t border-slate-100 px-6 py-3 lg:px-8 text-end lg:text-left text-xl text-[#e13b35]">
            <a href="{{ route('aboutUs') }}" class="hover:underline">
                {{ translate('Read More about us ') }}
            </a>
        </div>
        </div>
    </section>


    <!-- ================= CTA + 3 CARDS (IMAGE CLONE) ================= -->
    <section class="py-6 lg:py-16 bg-[#f6f6f6]">
        <div class="max-w-6xl px-3 md:px-0 mx-auto space-y-10">

            <!-- BIG RED BANNER -->
            <div class="bg-[#D94647] text-white rounded-[8px] overflow-hidden flex flex-col md:flex-row">

                <!-- LEFT CONTENT -->
                <div class="flex flex-col justify-between flex-1 px-5 sm:px-8 py-6 md:py-8 lg:py-10">
                    <div>
                        <p class="text-lg sm:text-xl lg:text-2xl uppercase text-[#ffe36b]">
                            {{ translate('Help People in Need') }}
                        </p>

                        <h2 class="mt-1 md:mt-4 text-base sm:text-lg md:text-xl lg:text-3xl leading-snug tracking-[0.03em] uppercase whitespace-pre-line">
                            @if(!empty($setting->help_people_need_content))
                                {!! $setting->help_people_need_content !!}
                            @endif
                        </h2>
                    </div>

                    <!-- Donate (Tablet+ Desktop) -->
                    <a href="{{ $setting->help_people_need_btn }}"
                    class="hidden md:inline-flex mt-6 w-fit
                            items-center justify-center
                            bg-[#ffe36b] text-[#201C1B]
                            text-[14px] uppercase
                            px-9 py-2 rounded-[2px]">
                        {{ translate('Donate') }}&gt;
                    </a>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="relative flex-1">
                    <img
                        src="{{ asset('storage/help_people_need_image/' . $setting->help_people_need_image) }}"
                        alt="{{ translate('Help people in need') }}"
                        class="object-cover w-full h-[220px] sm:h-[260px] md:h-full md:min-h-[320px] lg:min-h-[360px]"
                    />

                    <!-- Donate (Mobile only, overlay bottom) -->
                    <a href="{{ $setting->help_people_need_btn }}"
                    class="md:hidden absolute left-1/2 -translate-x-1/2 bottom-4
                            w-[calc(100%-2.5rem)] max-w-[340px]
                            inline-flex items-center justify-center
                            bg-[#ffeded] text-[#b53030]
                            text-[14px] uppercase px-9 py-2 rounded-[2px]">
                        {{ translate('Donate') }}&gt;
                    </a>
                </div>

            </div>


            <!-- THREE SMALL CARDS UNDER BANNER -->
            <div class="grid text-sm text-slate-800 md:grid-cols-3 gap-6 md:gap-10 items-start">
                <!-- CARD 1 -->
                <article class="flex flex-col h-full">
                    <h3 class="text-[26px] font-bold tracking-[0.04em] text-[#e13b35] uppercase">
                        {{ translate('Start Volunteering') }}
                    </h3>

                    <p class="mt-2 text-[16px] leading-relaxed text-slate-600 flex-1">
                        @if (!empty($setting->start_volunteering_content))
                            {!! $setting->start_volunteering_content !!}
                        @endif
                    </p>

                    <a href="{{ $setting->contact_us_button_volun }}"
                    class="w-[220px] mt-4 inline-flex items-center justify-center border border-[#e13b35]
                            text-[#e13b35] text-[11px] uppercase px-6 py-2"  style="border: 1px solid red !important;">
                        {{ translate('Contact Us') }} &gt;
                    </a>
                </article>

                <!-- CARD 2 -->
                <article class="flex flex-col h-full">
                    <h3 class="text-[26px] font-bold tracking-[0.04em] text-[#e13b35] uppercase">
                        {{ translate('Become Sponsor') }}
                    </h3>

                    <p class="mt-2 text-[16px] leading-relaxed text-slate-600 flex-1">
                        @if (!empty($setting->become_sponsor_content))
                            {!! $setting->become_sponsor_content !!}
                        @endif
                    </p>

                    <a href="{{ $setting->contact_us_button_volun }}"
                    class="w-[220px] mt-4 inline-flex items-center justify-center border border-[#e13b35]
                            text-[#e13b35] text-[11px] uppercase px-6 py-2"  style="border: 1px solid red !important;">
                        {{ translate('Contact Us') }} &gt;
                    </a>
                </article>

                <!-- CARD 3 -->
                <article class="flex flex-col h-full">
                    <h3 class="text-[26px] font-bold tracking-[0.04em] text-[#e13b35] uppercase">
                        {{ translate('Download Annual Report') }}
                    </h3>

                    <p class="mt-2 text-[16px] leading-relaxed text-slate-600 flex-1">
                        @if (!empty($setting->download_annual_report_content))
                            {!! $setting->download_annual_report_content !!}
                        @endif
                    </p>

                    @if(!empty($setting->download_annual_report_file))
                        <a href="{{ asset('storage/download_annual_report_file/'.$setting->download_annual_report_file) }}"
                        download
                        style="border: 1px solid red !important;"
                        class="w-[220px] mt-4 inline-flex items-center justify-center border border-[#e13b35]
                                text-[#e13b35] text-[11px] tracking-[0.16em] uppercase px-6 py-2">
                            {{ translate('Download') }} &gt;
                        </a>
                    @else
                        <button type="button"
                                style="border: 1px solid red !important;"
                                class="w-[220px] mt-4 inline-flex items-center justify-center border border-[#e13b35]
                                    text-[#e13b35] text-[11px] tracking-[0.16em] uppercase px-6 py-2 opacity-60 cursor-not-allowed">
                            {{ translate('File Not Available') }}
                        </button>
                    @endif
                </article>
            </div>
        </div>

        @include('frontend.includes.news_letter')

        <div class="pt-5"> 
            @include('frontend.includes.scroll_element')
        </div>
      

    </section>



    <script>
        const reviews = @json($reviewsData, JSON_UNESCAPED_SLASHES);

        const reviewName = document.getElementById("reviewName");
        const reviewInitial = document.getElementById("reviewInitial");
        const reviewText = document.getElementById("reviewText");
        const reviewImage = document.getElementById("reviewImage");
        const ghostLeftImg = document.getElementById("ghostLeftImg");
        const reviewProfileImg = document.getElementById("reviewProfileImg");

        const btnPrev = document.getElementById("reviewsPrev");
        const btnNext = document.getElementById("reviewsNext");

        let index = 0;

        function render(i) {
            if (!reviews || !reviews.length) return;

            const len = reviews.length;
            const cur = reviews[i];

            // ✅ previous item for left preview
            const prevIndex = (i - 1 + len) % len;
            const prev = reviews[prevIndex];

            reviewName.textContent = cur.name || "Anonymous";
            reviewInitial.textContent = cur.initial || "A";
            reviewText.textContent = cur.text || "";
            reviewImage.src = cur.img || "";

            // ✅ LEFT PREVIEW = previous review image
            if (ghostLeftImg) ghostLeftImg.src = (prev && prev.img) ? prev.img : (cur.img || "");

            // ✅ profile image show/hide
            if (cur.profileImage) {
                reviewProfileImg.src = cur.profileImage;
                reviewProfileImg.classList.remove("hidden");
                reviewInitial.classList.add("hidden");
            } else {
                reviewProfileImg.classList.add("hidden");
                reviewInitial.classList.remove("hidden");
            }
        }

        btnPrev?.addEventListener("click", () => {
            index = (index - 1 + reviews.length) % reviews.length;
            render(index);
        });

        btnNext?.addEventListener("click", () => {
            index = (index + 1) % reviews.length;
            render(index);
        });

        // ✅ swipe mobile
        let startX = 0;
        const wrapper = document.getElementById("reviewsWrapper");
        wrapper?.addEventListener("touchstart", (e) => startX = e.touches[0].clientX);
        wrapper?.addEventListener("touchend", (e) => {
            const diff = e.changedTouches[0].clientX - startX;
            if (Math.abs(diff) > 40) diff > 0 ? btnPrev.click() : btnNext.click();
        });

        render(index);
    </script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const heroSlides = @json($heroSlides);

    if (!heroSlides || heroSlides.length === 0) {
        console.warn('Hero slides not found');
        return;
    }

    const heroSection  = document.getElementById('heroSection');
    const heroTitle    = document.getElementById('heroTitle');
    const heroSubtitle = document.getElementById('heroSubtitle');
    const heroButton   = document.getElementById('heroButton');
    const heroLabel    = document.getElementById('heroControlLabel');
    const heroPrevBtn  = document.getElementById('heroPrev');
    const heroNextBtn  = document.getElementById('heroNext');
    const heroDotsWrap = document.getElementById('heroDots');

    let heroIndex = 0;
    let autoSlideInterval = null;

    function renderDots() {
        if (!heroDotsWrap) return;
        heroDotsWrap.innerHTML = '';

        heroSlides.forEach((slide, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className =
                'w-2.5 h-2.5 rounded-full transition-all duration-300 ' +
                (index === heroIndex ? 'bg-white scale-110' : 'bg-white/60');

            dot.addEventListener('click', () => {
                heroIndex = index;
                updateHero();
                restartAutoSlide();
            });

            heroDotsWrap.appendChild(dot);
        });
    }

    function updateHero() {
        const slide = heroSlides[heroIndex] || {};

        // background
        if (heroSection) {
            heroSection.style.background =
                `url('${slide.image || ''}') no-repeat 58% center / cover`;
        }

        // title/subtitle
        if (heroTitle) {
            heroTitle.innerHTML = slide.title ? String(slide.title).replace(/\n/g, '<br>') : '';
        }
        if (heroSubtitle) {
            heroSubtitle.innerHTML = slide.subtitle ? String(slide.subtitle).replace(/\n/g, '<br>') : '';
        }

        // ✅ button text + url
        const btnText = (slide.button ?? '').toString().trim();
        const url = (slide.url ?? '').toString().trim();

        if (btnText.length) {
            heroButton.classList.remove('hidden');
            heroButton.textContent = `${btnText} >`;
        } else {
            heroButton.classList.add('hidden');
            heroButton.textContent = '';
        }

        // ✅ set href (real url না থাকলে #)
        heroButton.href = url.length ? url : '#';

        // ✅ target
        heroButton.target = (slide.target ?? '_self');
        heroButton.rel = heroButton.target === '_blank' ? 'noopener noreferrer' : '';

        if (heroLabel) heroLabel.textContent = slide.label ?? '';

        renderDots();
    }

    if (heroPrevBtn) {
  heroPrevBtn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    heroIndex = (heroIndex - 1 + heroSlides.length) % heroSlides.length;
    updateHero();
    restartAutoSlide();
  });
}

if (heroNextBtn) {
  heroNextBtn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    heroIndex = (heroIndex + 1) % heroSlides.length;
    updateHero();
    restartAutoSlide();
  });
}



function startAutoSlide() {
  autoSlideInterval = setInterval(() => {
    heroIndex = (heroIndex + 1) % heroSlides.length;
    updateHero();
  }, 8000);
}

function restartAutoSlide() {
  clearInterval(autoSlideInterval);
  startAutoSlide();
}




    updateHero();
    startAutoSlide();
});
</script>

@endsection
