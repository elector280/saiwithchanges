@extends('frontend.layouts.master')

@section('title', $cam->title ?? 'Mini Campaign Preview')
@section('meta_description', $cam->meta_description ?? '')
@section('meta_keyword', $cam->meta_keywords ?? '')

@section('meta')
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="{{ url()->current() }}">

    @if(!empty($cam->og_title) || !empty($cam->title))
        <meta property="og:title" content="{{ $cam->og_title ?: $cam->title }}">
    @endif

    @if(!empty($cam->og_description) || !empty($cam->meta_description))
        <meta property="og:description" content="{{ $cam->og_description ?: $cam->meta_description }}">
    @endif

    @if(!empty($cam->og_image_url))
        <meta property="og:image" content="{{ $cam->og_image_url }}">
        <meta property="og:image:secure_url" content="{{ $cam->og_image_url }}">
        <meta property="og:image:alt" content="{{ $cam->og_title ?: $cam->title }}">
    @elseif(!empty($cam->cover_image_url))
        <meta property="og:image" content="{{ $cam->cover_image_url }}">
        <meta property="og:image:secure_url" content="{{ $cam->cover_image_url }}">
        <meta property="og:image:alt" content="{{ $cam->og_title ?: $cam->title }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">

    @if(!empty($cam->og_title) || !empty($cam->title))
        <meta name="twitter:title" content="{{ $cam->og_title ?: $cam->title }}">
    @endif

    @if(!empty($cam->og_description) || !empty($cam->meta_description))
        <meta name="twitter:description" content="{{ $cam->og_description ?: $cam->meta_description }}">
    @endif

    @if(!empty($cam->og_image_url))
        <meta name="twitter:image" content="{{ $cam->og_image_url }}">
    @elseif(!empty($cam->cover_image_url))
        <meta name="twitter:image" content="{{ $cam->cover_image_url }}">
    @endif

    @if(!empty($cam->canonical_url))
        <link rel="canonical" href="{{ $cam->canonical_url }}">
    @endif
@endsection

@section('frontend')
<style>
    .preview-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffe69c;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
    }

    .mc-thumb {
        height: 64px;
        width: 96px;
        object-fit: cover;
        border-radius: 10px;
    }

    .hero-fallback {
        background-color: #e5e7eb;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>

<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="preview-badge mb-2 mb-md-0">
                <i class="fas fa-eye"></i> Preview Mode — Not Published
            </div>

            <div class="small text-muted">
                Status: {{ ($cam->status ?? '0') == '1' ? 'Published' : 'Draft' }}
                @if(!empty($cam->start_date))
                    | Start: {{ \Carbon\Carbon::parse($cam->start_date)->format('M d, Y h:i A') }}
                @endif
                @if(!empty($cam->end_date))
                    | End: {{ \Carbon\Carbon::parse($cam->end_date)->format('M d, Y h:i A') }}
                @endif
            </div>
        </div>
    </div>
</section>

<section id="top" class="pt-4 pb-10 bg-[#f5f5f5] -mt-10 md:-mt-36 relative z-0">
    <div class="relative rounded-sm overflow-hidden shadow-lg bg-center hero-fallback"
         style="{{ !empty($cam->cover_image_url) ? "background-image: url('".$cam->cover_image_url."');" : '' }} height: 600px;">
        <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-[2fr,1fr] gap-6"></div>
    </div>
</section>

<section class="pb-20 -mt-48 relative z-10">
    <div class="max-w-7xl md:mx-auto grid lg:grid-cols-1 gap-6">

        <article id="mainDiv" class="mainDiv overflow-visible space-y-12-">

            <div class="bg-white shadow-md border border-gray-200 overflow-hidden md:mx-0 rounded-[4px]">

                <div class="relative bg-[#D94647] text-white px-5 md:px-8 py-2 pb-1 overflow-hidden">
                    <h2 class="text-[22px] sm:text-[26px] md:text-[34px] lg:text-[40px] font-bold uppercase leading-tight">
                        {{ $cam->title }}
                    </h2>

                    <div class="mt-1 flex flex-wrap gap-2">
                        @if(!empty($cam->slug))
                            <span class="inline-flex items-center gap-2 bg-white/15 px-3 py-1 rounded-full text-[12px] uppercase tracking-wider">
                                <i class="fa-solid fa-link"></i> {{ $cam->slug }}
                            </span>
                        @endif

                        @if(!empty($cam->tag_line))
                            <span class="inline-flex items-center gap-2 bg-yellow-400 text-black px-3 py-1 rounded-full text-[12px] uppercase tracking-wider">
                                <i class="fa-solid fa-bolt"></i> {{ $cam->tag_line }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="px-5 md:px-8 pt-2 pb-2">
                    @if(!empty($cam->short_description))
                        <div class="mt-1 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed prose max-w-none">
                            {!! $cam->short_description !!}
                        </div>
                    @endif

                    @if(!empty($cam->view_project_url))
                        <a href="{{ $cam->view_project_url }}" target="_blank"
                           class="mt-1 inline-block text-[13px] font-semibold text-[#f04848] hover:underline">
                            {{ translate('Visit Website') }} &gt;
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white shadow-md border border-gray-200 overflow-hidden rounded-[4px]">
                <div class="px-5 md:px-8 py-2">
                    <div class="mt-2 space-y-6 text-[15px] leading-relaxed text-gray-600">
                        @if(!empty($cam->paragraph_one))
                            <div class="prose max-w-none">
                                {!! $cam->paragraph_one !!}
                            </div>
                        @endif

                        @if(!empty($cam->paragraph_two))
                            <div class="prose max-w-none">
                                {!! $cam->paragraph_two !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(!empty($cam->donation_box))
                <div class="bg-white shadow-md border border-gray-200 overflow-hidden rounded-[4px]">
                    <div class="px-5 md:px-8 py-5">
                        <div class="prose max-w-none">
                            {!! $cam->donation_box !!}
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-md border border-gray-200 overflow-hidden rounded-[4px]">
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
                                    <div class="mt-2">
                                        <img src="{{ $cam->og_image_url }}" class="mc-thumb" alt="OG Preview">
                                    </div>
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </article>
    </div>
</section>
@endsection