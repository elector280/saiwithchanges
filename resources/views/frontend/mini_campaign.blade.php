@extends('frontend.layouts.master')

@section('title', $cam->title ?? 'Mini Campaign')
@section('meta_description', $cam->meta_description ?? '')
@section('meta_keyword', $cam->meta_keywords ?? '')

@section('meta')
@php
    $cover_image_url = !empty($cam->cover_image) ? asset('storage/cover_image/' . $cam->cover_image) : null;
    $og_image_url    = !empty($cam->og_image)    ? asset('storage/og_image/'    . $cam->og_image)    : null;

    if (isset($cam->cover_image_url)) { $cover_image_url = $cam->cover_image_url; }
    if (isset($cam->og_image_url))    { $og_image_url    = $cam->og_image_url;    }

    $donation_box = method_exists($cam, 'getLocalValue') ? $cam->getLocalValue('donation_box') : ($cam->donation_box ?? '');
    if (is_array($donation_box)) {
        $locale       = app()->getLocale();
        $donation_box = $donation_box[$locale] ?? $donation_box['en'] ?? (is_string(reset($donation_box)) ? reset($donation_box) : '');
    }
@endphp
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type"              content="website">
    <meta property="og:site_name"         content="{{ config('app.name') }}">
    <meta property="og:locale"            content="en_US">
    <meta property="og:url"               content="{{ url()->current() }}">
    @if(!empty($cam->og_title) || !empty($cam->title))
        <meta property="og:title"         content="{{ $cam->og_title ?: $cam->title }}">
        <meta name="twitter:title"        content="{{ $cam->og_title ?: $cam->title }}">
    @endif
    @if(!empty($cam->og_description) || !empty($cam->meta_description))
        <meta property="og:description"   content="{{ $cam->og_description ?: $cam->meta_description }}">
        <meta name="twitter:description"  content="{{ $cam->og_description ?: $cam->meta_description }}">
    @endif
    @if(!empty($og_image_url))
        <meta property="og:image"         content="{{ $og_image_url }}">
        <meta property="og:image:secure_url" content="{{ $og_image_url }}">
        <meta name="twitter:image"        content="{{ $og_image_url }}">
    @elseif(!empty($cover_image_url))
        <meta property="og:image"         content="{{ $cover_image_url }}">
        <meta property="og:image:secure_url" content="{{ $cover_image_url }}">
        <meta name="twitter:image"        content="{{ $cover_image_url }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('frontend')

<!-- ========= EXTRA CSS ========= -->
<style>
    .tab-active   { background:#e54545; color:#ffffff; }
    .tab-inactive { background:#f1f1f1; color:#d3564f; }
</style>

{{-- HERO SECTION --}}
<section id="top" class="pt-4 pb-10 -mt-10 md:-mt-36 relative z-0">
    <div class="relative rounded-sm overflow-hidden shadow-lg bg-no-repeat bg-cover bg-center"
         style="{{ !empty($cover_image_url) ? \"background-image: url('\" . $cover_image_url . \"');\" : (!empty($setting->donate_hero_image) ? \"background-image: url('\" . asset('storage/donate_hero_image/'.$setting->donate_hero_image) . \"');\" : '') }} height: 600px;">

        <!-- RED GRADIENT OVERLAY -->
        <div class="absolute inset-0 pointer-events-none z-10"
             style="background: radial-gradient(120% 120% at left bottom,
                rgba(217,70,71,0.95) 0%, rgba(217,70,71,0.70) 22%,
                rgba(217,70,71,0.45) 40%, rgba(217,70,71,0.22) 58%,
                rgba(217,70,71,0.10) 70%, rgba(217,70,71,0.00) 85%);"></div>

        <div class="relative z-20 max-w-7xl mx-auto px-4 grid lg:grid-cols-[2fr,1fr] gap-6">
            {{-- space for future hero content --}}
        </div>
    </div>
</section>

{{-- MAIN SECTION --}}
<section class="pb-20 -mt-48 relative z-10">
    <div class="max-w-7xl md:mx-auto md:px-4 grid lg:grid-cols-[3fr,1fr] gap-6">

        {{-- LEFT SIDE --}}
        <div class="space-y-6">
            <span class="inline-flex w-fit shrink-0 px-6 py-1 font-semibold rounded-tr-lg rounded-bl-lg bg-[#D94647] text-white ml-2">
                {{ $cam->tag_line ?? $setting->tag_line ?? 'Urgent Help' }}
            </span>

            <article id="mainDiv" class="mainDiv overflow-visible space-y-12">

                {{-- CARD 1: TITLE + CONTENT --}}
                <div class="bg-white shadow-md border border-gray-200 overflow-hidden mx-2 md:mx-0 rounded-[4px]">

                    <!-- TOP RED HEADER -->
                    <div class="relative bg-[#D94647] text-white px-2 md:px-8 py-3 overflow-hidden">
                        <h1 class="px-5 md:px-8 text-[22px] sm:text-[26px] md:text-[34px] lg:text-[40px] font-bold uppercase leading-tight">
                            {{ $cam->title }}
                        </h1>
                        <!-- right ribbon (blue + yellow) -->
                        <div class="absolute top-0 -right-2 hidden w-16 h-full md:block">
                            <div class="absolute inset-y-0 right-5 w-7 bg-[#2261aa] skew-x-[42deg]"></div>
                            <div class="absolute inset-y-0 right-0 w-6 bg-[#fff0a1] skew-x-[42deg]"></div>
                        </div>
                    </div>

                    <!-- Mobile donate button -->
                    <a href="javascript:void(0)" id="donateBtn"
                       class="md:hidden w-[300px] block text-center mb-4 mx-5 my-3 border border-[#f3b6b6] bg-[#fff1f1] text-[#D94647] font-semibold uppercase tracking-[0.10em] py-3 rounded-[2px]">
                        {{ translate('Donate') }}
                    </a>

                    <!-- BODY -->
                    <div class="px-5 md:px-8 md:pt-5 pb-6">

                        @php
                            $icons = App\Models\Sponsor::where('type', 'campaign_icon')->latest()->get();
                        @endphp

                        <div class="flex flex-wrap items-center gap-4 md:gap-6 mb-4 text-[12px] text-gray-700 justify-center md:justify-start">
                            @foreach($icons as $icon)
                                <button type="button" class="flex items-center gap-2 focus:outline-none"
                                    onclick="openCertModal(
                                        @js($icon->title ?? $icon->company_name ?? 'Certified'),
                                        @js($icon->sub_title ?? ''),
                                        @js($icon->content ?? ''),
                                        @js(asset('storage/company_logo/'.$icon->company_logo)),
                                        @js($icon->website_link ?? ''))">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-200 overflow-hidden">
                                        <img src="{{ asset('storage/company_logo/'.$icon->company_logo) }}"
                                             alt="{{ $icon->title ?? $icon->company_name ?? 'Certification' }}"
                                             class="w-full h-full object-contain p-1">
                                    </span>
                                    <span class="font-medium text-gray-700">{{ $icon->title ?? $icon->company_name ?? 'Certified' }}</span>
                                </button>
                            @endforeach
                        </div>

                        @include('frontend.includes.campaign_det_img')

                        <!-- Short Description -->
                        @if(!empty($cam->short_description))
                            <h2 class="text-[22px] sm:text-[26px] md:text-[30px] font-semibold leading-tight text-[#3e3e3e]">
                                {!! strip_tags($cam->short_description) !!}
                            </h2>
                        @endif

                        <!-- Paragraphs -->
                        @if(!empty($cam->paragraph_one))
                            <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">
                                {!! $cam->paragraph_one !!}
                            </p>
                        @endif
                        @if(!empty($cam->paragraph_two))
                            <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">
                                {!! $cam->paragraph_two !!}
                            </p>
                        @endif

                        <!-- CTA Link -->
                        @if(!empty($cam->view_project_url))
                            <div class="mt-4">
                                <a href="{{ $cam->view_project_url }}" target="_blank" class="text-[#E13B35] font-semibold hover:underline">
                                    Visit Website &gt;
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- CARD 2: CERTIFICATIONS --}}
                <div class="bg-white shadow-md border border-gray-200 mx-2 md:mx-0 overflow-hidden rounded-[4px]">
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
                            <div class="mt-6 grid grid-cols-4 gap-3 justify-items-center">
                                @foreach($certifications as $item)
                                    <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}"
                                         class="object-contain" style="height:150px; width:150px;"
                                         alt="{{ $item->title ?? $item->company_name ?? 'Certification' }}"
                                         title="{{ $item->title ?? $item->company_name ?? 'Certification' }}">
                                @endforeach
                            </div>
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
            <div>
                @if(!empty($donation_box))
                    <section class="prose max-w-none">
                        {!! $donation_box !!}
                    </section>
                @elseif(!empty($setting->global_donorbox_code))
                    <section class="prose max-w-none">
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

<script>
function openCertModal(title, subTitle, content, imgUrl, websiteLink) {
    const modal = document.getElementById('certModal');
    document.getElementById('certModalTitle').textContent    = title    || '';
    document.getElementById('certModalSubTitle').textContent = subTitle || '';
    document.getElementById('certModalContent').textContent  = content  || '';
    const img  = document.getElementById('certModalImg');
    img.src    = imgUrl || '';
    img.alt    = title  || 'Certification';
    const link = document.getElementById('certModalLink');
    if (websiteLink && websiteLink.trim() !== '') {
        link.href = websiteLink;
        link.classList.remove('hidden');
    } else {
        link.href = '#';
        link.classList.add('hidden');
    }
    modal.classList.remove('hidden');
    document.addEventListener('keydown', certEscClose);
}
function closeCertModal() {
    document.getElementById('certModal').classList.add('hidden');
    document.removeEventListener('keydown', certEscClose);
}
function certEscClose(e) { if (e.key === 'Escape') closeCertModal(); }
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const donateBtn      = document.getElementById("donateBtn");
    const mainDiv        = document.getElementById("mainDiv");
    const donationSideBar = document.getElementById("donationSideBar");
    const backBtn        = document.getElementById("backBtn");

    donateBtn?.addEventListener("click", () => {
        mainDiv?.classList.add("hidden");
        donationSideBar?.classList.remove("hidden");
        donationSideBar?.classList.add("block");
    });
    backBtn?.addEventListener("click", () => {
        mainDiv?.classList.remove("hidden");
        donationSideBar?.classList.add("hidden");
        donationSideBar?.classList.remove("block");
    });
});
</script>

@endsection