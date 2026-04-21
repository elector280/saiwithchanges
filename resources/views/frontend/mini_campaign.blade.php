@extends('frontend.layouts.master')

@section('title', $cam->title ?? 'Mini Campaign Preview')
@section('meta_description', $cam->meta_description ?? '')
@section('meta_keyword', $cam->meta_keywords ?? '')

@section('meta')
@php
    $cover_image_url = !empty($cam->cover_image) ? asset('storage/cover_image/' . $cam->cover_image) : null;
    $og_image_url = !empty($cam->og_image) ? asset('storage/og_image/' . $cam->og_image) : null;
    
    // For admin preview fallback compatibility
    if (isset($cam->cover_image_url)) {
        $cover_image_url = $cam->cover_image_url;
    }
    if (isset($cam->og_image_url)) {
        $og_image_url = $cam->og_image_url;
    }

    $donation_box = method_exists($cam, 'getLocalValue') ? $cam->getLocalValue('donation_box') : ($cam->donation_box ?? '');
    if (is_array($donation_box)) {
        $locale = app()->getLocale();
        $donation_box = $donation_box[$locale] ?? $donation_box['en'] ?? (is_string(reset($donation_box)) ? reset($donation_box) : '');
    }
@endphp
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

    @if(!empty($og_image_url))
        <meta property="og:image" content="{{ $og_image_url }}">
        <meta property="og:image:secure_url" content="{{ $og_image_url }}">
        <meta property="og:image:alt" content="{{ $cam->og_title ?: $cam->title }}">
    @elseif(!empty($cover_image_url))
        <meta property="og:image" content="{{ $cover_image_url }}">
        <meta property="og:image:secure_url" content="{{ $cover_image_url }}">
        <meta property="og:image:alt" content="{{ $cam->og_title ?: $cam->title }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">

    @if(!empty($cam->og_title) || !empty($cam->title))
        <meta name="twitter:title" content="{{ $cam->og_title ?: $cam->title }}">
    @endif

    @if(!empty($cam->og_description) || !empty($cam->meta_description))
        <meta name="twitter:description" content="{{ $cam->og_description ?: $cam->meta_description }}">
    @endif

    @if(!empty($og_image_url))
        <meta name="twitter:image" content="{{ $og_image_url }}">
    @elseif(!empty($cover_image_url))
        <meta name="twitter:image" content="{{ $cover_image_url }}">
    @endif

    @if(!empty($cam->canonical_url))
        <link rel="canonical" href="{{ $cam->canonical_url }}">
    @endif
@endsection

@section('frontend')
<style>
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
        .title-banner {
            width: 100%;
        }
    }
</style>

<!-- Hero Section -->
<section id="top" class="relative w-full h-[400px] md:h-[500px] bg-center bg-cover bg-no-repeat hero-fallback" 
         style="{{ !empty($cover_image_url) ? "background-image: url('".$cover_image_url."');" : '' }}">
</section>

<!-- Main container -->
<section class="max-w-7xl mx-auto px-4 pb-20 relative z-10">
    <div class="grid lg:grid-cols-[1.5fr,1fr] gap-10">
        
        <!-- Left Content -->
        <div class="relative">
            <!-- Title Block overlapping Hero -->
            <div class="relative inline-block w-[95%] md:w-[85%] mt-[-40px] md:mt-[-60px] z-20">
                <!-- Outer right area transparent to allow clip-path to show elements underneath? No, the div itself has width -->
                
                <!-- Yellow Stripe (Back) -->
                <div class="absolute inset-0 bg-[#FFD100] shadow-lg hidden md:block" style="clip-path: polygon(0 0, 100% 0, calc(100% - 30px) 100%, 0 100%); z-index: 1;"></div>
                
                <!-- Blue Stripe (Middle) -->
                <div class="absolute inset-0 bg-[#003893] hidden md:block" style="clip-path: polygon(0 0, calc(100% - 15px) 0, calc(100% - 45px) 100%, 0 100%); z-index: 2;"></div>
                
                <!-- Red Box (Front) -->
                <div class="absolute inset-0 bg-[#E13B35] hidden md:block" style="clip-path: polygon(0 0, calc(100% - 30px) 0, calc(100% - 60px) 100%, 0 100%); z-index: 3;"></div>
                
                <!-- Red Box (Mobile - no clip-path) -->
                <div class="absolute inset-0 bg-[#E13B35] md:hidden z-3 shadow-lg"></div>

                <!-- Content -->
                <div class="relative z-10 px-6 md:px-8 py-5 md:py-6 pr-[20px] md:pr-[80px]">
                    <div class="mb-2">
                        <span class="border border-white text-white text-xs px-2 py-1 rounded-sm">Urgent Help</span>
                    </div>
                    <h1 class="text-[26px] md:text-[36px] font-bold uppercase leading-tight tracking-wide text-white">
                        {{ $cam->title }}
                    </h1>
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
                @if(!empty($cam->short_description))
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-5 leading-snug">
                        {!! strip_tags($cam->short_description) !!}
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
                                <img src="{{ asset('storage/company_logo/'.$cert->company_logo) }}" class="h-10 w-auto object-contain" alt="{{ $cert->company_name }}">
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
        </div>

        <!-- Right Content (Widget) -->
        <div class="lg:mt-[-100px] relative z-20">
            <div class="sticky top-24 bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
                @if(!empty($donation_box))
                    <div class="w-full text-center">
                        {!! $donation_box !!}
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