@extends('frontend.layouts.master')

@section('title', 'Mini Campaign Preview')

@section('meta')
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(!empty($cam->og_title) || !empty($cam->title))
        <meta property="og:title" content="{{ $cam->og_title ?: $cam->title }}">
        <meta name="twitter:title" content="{{ $cam->og_title ?: $cam->title }}">
    @endif
    @if(!empty($cam->og_description) || !empty($cam->meta_description))
        <meta property="og:description" content="{{ $cam->og_description ?: $cam->meta_description }}">
        <meta name="twitter:description" content="{{ $cam->og_description ?: $cam->meta_description }}">
    @endif
    @if(!empty($cam->og_image_url))
        <meta property="og:image" content="{{ $cam->og_image_url }}">
        <meta name="twitter:image" content="{{ $cam->og_image_url }}">
    @elseif(!empty($cam->cover_image_url))
        <meta property="og:image" content="{{ $cam->cover_image_url }}">
        <meta name="twitter:image" content="{{ $cam->cover_image_url }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    @if(!empty($cam->canonical_url))
        <link rel="canonical" href="{{ $cam->canonical_url }}">
    @endif
@endsection

@section('frontend')
<style>
    .preview-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff3cd; color: #856404;
        border: 1px solid #ffe69c; border-radius: 999px;
        padding: 8px 14px; font-size: 13px; font-weight: 600;
    }
    .mc-thumb { height: 64px; width: 96px; object-fit: cover; border-radius: 10px; }
</style>

{{-- PREVIEW BANNER --}}
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="preview-badge mb-2 mb-md-0">
                <i class="fas fa-eye"></i> Preview Mode — Not Published
            </div>
            <div class="small text-muted">
                Status: {{ ($cam->status ?? '0') == '1' ? 'Published' : 'Draft' }}
                @if(!empty($cam->start_date)) | Start: {{ \Carbon\Carbon::parse($cam->start_date)->format('M d, Y h:i A') }} @endif
                @if(!empty($cam->end_date))   | End:   {{ \Carbon\Carbon::parse($cam->end_date)->format('M d, Y h:i A') }}   @endif
            </div>
        </div>
    </div>
</section>

{{-- HERO SECTION --}}
<section id="top" class="pt-4 pb-10 -mt-10 md:-mt-36 relative z-0">
    <div class="relative rounded-sm overflow-hidden shadow-lg bg-no-repeat bg-cover bg-center"
         style="{{ !empty($cam->cover_image_url) ? \"background-image: url('\".$cam->cover_image_url.\"');\" : '' }} height: 600px;">
        <div class="absolute inset-0 pointer-events-none z-10"
             style="background: radial-gradient(120% 120% at left bottom,
                rgba(217,70,71,0.95) 0%, rgba(217,70,71,0.70) 22%,
                rgba(217,70,71,0.45) 40%, rgba(217,70,71,0.22) 58%,
                rgba(217,70,71,0.10) 70%, rgba(217,70,71,0.00) 85%);"></div>
        <div class="relative z-20 max-w-7xl mx-auto px-4 grid lg:grid-cols-[2fr,1fr] gap-6"></div>
    </div>
</section>

{{-- MAIN SECTION --}}
<section class="pb-20 -mt-48 relative z-10">
    <div class="max-w-7xl md:mx-auto md:px-4 grid lg:grid-cols-[3fr,1fr] gap-6">

        {{-- LEFT SIDE --}}
        <div class="space-y-6">
            <span class="inline-flex w-fit shrink-0 px-6 py-1 font-semibold rounded-tr-lg rounded-bl-lg bg-[#D94647] text-white ml-2">
                {{ $cam->tag_line ?? 'Urgent Help' }}
            </span>

            <article id="mainDiv" class="mainDiv overflow-visible space-y-12">

                {{-- CARD 1: TITLE + CONTENT --}}
                <div class="bg-white shadow-md border border-gray-200 overflow-hidden mx-2 md:mx-0 rounded-[4px]">

                    <div class="relative bg-[#D94647] text-white px-2 md:px-8 py-3 overflow-hidden">
                        <h1 class="px-5 md:px-8 text-[22px] sm:text-[26px] md:text-[34px] lg:text-[40px] font-bold uppercase leading-tight">
                            {{ $cam->title }}
                        </h1>
                        <div class="absolute top-0 -right-2 hidden w-16 h-full md:block">
                            <div class="absolute inset-y-0 right-5 w-7 bg-[#2261aa] skew-x-[42deg]"></div>
                            <div class="absolute inset-y-0 right-0 w-6 bg-[#fff0a1] skew-x-[42deg]"></div>
                        </div>
                    </div>

                    <div class="px-5 md:px-8 md:pt-5 pb-6">
                        @php
                            $icons = \App\Models\Sponsor::where('type', 'campaign_icon')->latest()->get();
                        @endphp
                        <div class="flex flex-wrap items-center gap-4 md:gap-6 mb-4 text-[12px] text-gray-700 justify-center md:justify-start">
                            @foreach($icons as $icon)
                                <span class="inline-flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-200 overflow-hidden">
                                        <img src="{{ asset('storage/company_logo/'.$icon->company_logo) }}"
                                             alt="{{ $icon->title ?? $icon->company_name ?? 'Certification' }}"
                                             class="w-full h-full object-contain p-1">
                                    </span>
                                    <span class="font-medium text-gray-700">{{ $icon->title ?? $icon->company_name ?? 'Certified' }}</span>
                                </span>
                            @endforeach
                        </div>

                        @if(!empty($cam->short_description) || !empty($cam->description))
                            <h2 class="text-[22px] sm:text-[26px] md:text-[30px] font-semibold leading-tight text-[#3e3e3e]">
                                {!! strip_tags($cam->short_description ?? $cam->description) !!}
                            </h2>
                        @endif
                        @if(!empty($cam->paragraph_one))
                            <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">{!! $cam->paragraph_one !!}</p>
                        @endif
                        @if(!empty($cam->paragraph_two))
                            <p class="mt-4 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed">{!! $cam->paragraph_two !!}</p>
                        @endif
                        @if(!empty($cam->view_project_url))
                            <div class="mt-4">
                                <a href="{{ $cam->view_project_url }}" target="_blank" class="text-[#E13B35] font-semibold hover:underline">Visit Website &gt;</a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- CARD 2: CERTIFICATIONS --}}
                <div class="bg-white shadow-md border border-gray-200 mx-2 md:mx-0 overflow-hidden rounded-[4px]">
                    <div class="grid md:grid-cols-2">
                        <div class="bg-[#ff6b6b] text-white px-6 md:px-8 py-6 md:py-8">
                            <h2 class="text-[22px] sm:text-[26px] md:text-[28px] leading-tight uppercase">
                                DONATIONS ARE 100% SECURE
                            </h2>
                            @php $certifications = \App\Models\Sponsor::where('type', 'certifications')->latest()->get(); @endphp
                        </div>
                        <div class="bg-white px-6 md:px-8 py-6 md:py-8 border-t md:border-t-0 md:border-l border-gray-200">
                            <p class="text-center text-slate-600 text-[13px] md:text-[14px] leading-snug">OUR CERTIFICATIONS</p>
                            <div class="mt-6 grid grid-cols-4 gap-3 justify-items-center">
                                @foreach($certifications as $item)
                                    <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}"
                                         class="object-contain" style="height:80px; width:80px;"
                                         alt="{{ $item->title ?? $item->company_name ?? 'Certification' }}">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO SUMMARY (solo en preview) --}}
                <div class="bg-white shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 md:px-8 py-5">
                        <h4 class="font-bold mb-3">SEO / Social Summary</h4>
                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <div><strong>Meta Title:</strong> {{ $cam->meta_title ?: 'N/A' }}</div>
                                <div class="mt-2"><strong>Meta Description:</strong> {{ $cam->meta_description ?: 'N/A' }}</div>
                                <div class="mt-2"><strong>Canonical:</strong> {{ $cam->canonical_url ?: 'N/A' }}</div>
                            </div>
                            <div>
                                <div><strong>OG Title:</strong> {{ $cam->og_title ?: 'N/A' }}</div>
                                <div class="mt-2"><strong>OG Description:</strong> {{ $cam->og_description ?: 'N/A' }}</div>
                                <div class="mt-2">
                                    <strong>OG Image:</strong>
                                    @if(!empty($cam->og_image_url))
                                        <div class="mt-2"><img src="{{ $cam->og_image_url }}" class="mc-thumb" alt="OG Preview"></div>
                                    @else N/A @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </article>
        </div>

        {{-- RIGHT SIDE / SIDEBAR --}}
        <aside id="donationSideBar" class="hidden md:block space-y-14">
            <div>
                @if(!empty($cam->donation_box))
                    <section class="prose max-w-none">{!! $cam->donation_box !!}</section>
                @else
                    <div class="p-10 text-center text-gray-500 bg-gray-50 border border-gray-100">
                        <i class="fas fa-hand-holding-heart text-4xl mb-3 text-gray-300"></i>
                        <p class="font-medium">No donation widget provided.</p>
                    </div>
                @endif
            </div>
        </aside>

    </div>
</section>
@endsection