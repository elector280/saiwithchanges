@extends('frontend.layouts.master')

@section('title', 'Mini Campaign Preview')

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

    @media (max-width: 768px) {
        .title-banner-wrapper {
            width: 100%;
        }
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

<!-- Hero Section -->
<section id="top" class="relative w-full h-[400px] md:h-[500px] bg-center bg-cover bg-no-repeat hero-fallback" 
         style="{{ !empty($cam->cover_image_url) ? "background-image: url('".$cam->cover_image_url."');" : '' }}">
</section>

<!-- Main container -->
<section class="max-w-7xl mx-auto px-4 pb-20 relative z-10">
    <div class="grid lg:grid-cols-[1.5fr,1fr] gap-10">
        
        <!-- Left Content -->
        <div class="relative">
            <!-- Title Block overlapping Hero (matching live donation page) -->
            <div class="relative inline-block w-[95%] md:w-[85%] mt-[-40px] md:mt-[-60px] z-20 shadow-lg title-banner-wrapper">
                <!-- TOP RED HEADER -->
                <div class="relative bg-[#D94647] text-white px-2 md:px-8 py-4 overflow-hidden rounded-[2px]">
                    <div class="mb-2 px-3 md:px-0">
                        <span class="border border-white text-white text-xs px-2 py-1 rounded-sm">Urgent Help</span>
                    </div>
                    <h1 class="px-3 md:px-0 text-[26px] md:text-[34px] lg:text-[40px] font-bold uppercase leading-tight relative z-10 w-[90%]">
                        {{ $cam->title }}
                    </h1>

                    <!-- right ribbon (blue + yellow) -->
                    <div class="absolute top-0 -right-2 hidden w-16 h-full md:block z-0">
                        <div class="absolute inset-y-0 right-5 w-7 bg-[#2261aa] skew-x-[42deg]"></div>
                        <div class="absolute inset-y-0 right-0 w-6 bg-[#fff0a1] skew-x-[42deg]"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 pt-10 mt-[-20px] shadow-sm border border-gray-100 relative z-10">
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-6 text-sm font-semibold text-gray-800 mb-6 border-b border-gray-100 pb-4">
                    <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500 text-lg"></i> Verified</div>
                    <div class="flex items-center gap-2"><i class="fas fa-trophy text-blue-600 text-lg"></i> Best NGO</div>
                    <div class="flex items-center gap-2"><i class="fas fa-star text-red-500 text-lg"></i> Favorite</div>
                    <div class="flex items-center gap-2"><i class="fas fa-certificate text-yellow-500 text-lg"></i> Certified</div>
                </div>

                <!-- Short Description / Subtitle -->
                @if(!empty($cam->short_description) || !empty($cam->description))
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-5 leading-snug">
                        {!! strip_tags($cam->short_description ?? $cam->description) !!}
                    </h2>
                @endif

                <!-- Dynamic Content (Paragraphs) -->
                <div class="prose max-w-none text-gray-600 text-base md:text-[17px] leading-relaxed space-y-6 mb-8">
                    @if(!empty($cam->paragraph_one))
                        <div>{!! $cam->paragraph_one !!}</div>
                    @endif
                    @if(!empty($cam->paragraph_two))
                        <div>{!! $cam->paragraph_two !!}</div>
                    @endif
                </div>

                <!-- CTA Link -->
                @if(!empty($cam->view_project_url))
                    <div class="mb-2">
                        <a href="{{ $cam->view_project_url }}" target="_blank" class="text-[#E13B35] font-semibold hover:underline">
                            Visit Website >
                        </a>
                    </div>
                @endif
            </div>

            <!-- Secure Donations Block -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm border border-gray-100 flex flex-col md:flex-row">
                <div class="bg-[#e45151] p-6 text-white w-full md:w-3/5 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold uppercase leading-tight mb-6">
                        Donations Are 100% Secure & Tax Deductible
                    </h3>
                    <p class="text-xs uppercase font-semibold tracking-wider text-white/90 mb-3">Our Certifications</p>
                    <div class="flex flex-wrap items-center gap-3">
                        @php
                            $certifications = \App\Models\Sponsor::where('type', 'certifications')->latest()->take(4)->get();
                        @endphp
                        @if($certifications->count() > 0)
                            @foreach($certifications as $cert)
                                <img src="{{ asset('storage/sponsor/'.$cert->image) }}" class="h-10 w-10 object-contain" alt="">
                            @endforeach
                        @else
                            <img src="{{ asset('images/cert-1.png') }}" class="h-10 object-contain rounded" onerror="this.style.display='none'" alt="Candid">
                            <img src="{{ asset('images/cert-2.png') }}" class="h-10 object-contain rounded" onerror="this.style.display='none'" alt="Great Nonprofits">
                        @endif
                    </div>
                </div>
                <div class="bg-[#Fdfdfd] p-6 w-full md:w-2/5 flex flex-col justify-center items-center text-center">
                    <p class="text-sm font-semibold text-gray-700 mb-4">You can donate with your <br> Favorite service</p>
                    <div class="flex justify-center gap-3">
                        <div class="w-12 h-8 bg-gray-200 border border-gray-300 rounded flex items-center justify-center"><i class="fab fa-cc-visa text-gray-600 text-xl"></i></div>
                        <div class="w-12 h-8 bg-gray-200 border border-gray-300 rounded flex items-center justify-center"><i class="fab fa-cc-mastercard text-gray-600 text-xl"></i></div>
                        <div class="w-12 h-8 bg-gray-200 border border-gray-300 rounded flex items-center justify-center"><i class="fab fa-paypal text-gray-600 text-xl"></i></div>
                        <div class="w-12 h-8 bg-gray-200 border border-gray-300 rounded flex items-center justify-center"><i class="fab fa-cc-amex text-gray-600 text-xl"></i></div>
                    </div>
                </div>
            </div>

            <!-- Preivew SEO Summary -->
            <div class="bg-white shadow-sm border border-gray-100 overflow-hidden mt-8">
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

        </div>

        <!-- Right Content (Widget) -->
        <div class="lg:mt-[-100px] relative z-20">
            <div class="sticky top-24 bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
                @if(!empty($cam->donation_box))
                    <div class="w-full text-center">
                        {!! $cam->donation_box !!}
                    </div>
                @else
                    <div class="p-10 text-center text-gray-500 bg-gray-50">
                        <i class="fas fa-hand-holding-heart text-4xl mb-3 text-gray-300"></i>
                        <p class="font-medium">No donation widget provided.</p>
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</section>
@endsection