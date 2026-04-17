@extends('frontend.layouts.master')


@section('title', translate('Double Your Help with Employee Matching Gifts page meta title'))
@section('meta_description', translate('Double Your Help with Employee Matching Gifts page meta description'))
@section('meta_keyword', translate('Double Your Help with Employee Matching Gifts page meta keyword'))
    
@section('meta')
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- Open Graph --}}
  <meta property="og:title" content="{{ translate('Double Your Help with Employee Matching Gifts page title') }}">
  <meta property="og:description" content="{{ translate('Double Your Help with Employee Matching Gifts page description') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ asset('storage/logo/'.$setting->logo) }}">

  {{-- Twitter --}}
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ translate('Double Your Help with Employee Matching Gifts page title') }}">
  <meta name="twitter:description" content="{{ translate('Double Your Help with Employee Matching Gifts page description') }}"> 
  <meta name="twitter:image" content="{{ asset('storage/logo/'.$setting->logo) }}">
@endsection
@php
    $locale = session('locale', config('app.locale'));
    @endphp

@section('frontend')
<!-- TOP : DOUBLE YOUR HELP (IMAGE CLONE) -->
<section class="bg-[#f5f5f5] pt-48 pb-8 -mt-48 md:-mt-36">
    <div class="max-w-6xl md:mx-auto md:px-4">
        @if(!empty($setting->emp_match_section_1))
                            {!! $setting->emp_match_section_1 !!}
                    @endif
    </div>
</section>

<!-- ======= BENEvity STRIP : LEFT CARD + EMPTY RIGHT CARD ======= -->
<section class="bg-gradient-to-br from-[#ff5b5b] via-[#ff6d4c] to-[#ff7c7c] py-8">
    <div class="max-w-6xl mx-auto px-6">

        @if(!empty($setting->emp_match_section_2))
            {!! $setting->emp_match_section_2 !!}
        @endif

    </div>
</section> 


<!-- ========= MISSION TEXT + BULLET LIST BLOCK ========= -->
<section class="bg-[#f5f5f5]- py-10">
    <div class="max-w-6xl md:mx-auto md:px-4">

        <!-- outer white box -->
        <div class="border-gray-200- shadow-md- px-8 py-8">
            @if(!empty($setting->emp_match_section_3))
                            {!! $setting->emp_match_section_3 !!}
                    @endif
        </div>

    </div>
</section>


<!-- ============ COMPANY MATCH + DONATION SIDEBAR ============ -->
<section class="bg-[#f5f5f5] py-10">
    <div class="max-w-6xl mx-auto px-4">

        <div class="grid lg:grid-cols-[2.3fr,1.1fr] gap-6 items-start">

            <!-- ========== LEFT : TWO STACKED MATCH CARDS ========== -->
            <div class="space-y-5">

                <!-- CARD 1 : RED HEADER (BENEvity) -->
                @if(!empty($setting->emp_match_section_4))
                            {!! $setting->emp_match_section_4 !!}
                    @endif

                <!-- CARD 2 : BLUE HEADER (BENEvity / অন্য প্ল্যাটফর্ম) -->
                @if(!empty($setting->emp_match_section_5))
                            {!! $setting->emp_match_section_5 !!}
                    @endif

            </div>

            <!-- ========== RIGHT : DONATION SIDEBAR CARD ========== -->
            <aside class="bg-white border border-gray-200 shadow-md rounded-sm text-xs text-gray-700">
                <div class="">
                    @if(!empty($setting->global_donorbox_code))
                        <section class="space-y-2 prose max-w-none">
                            {!! $setting->global_donorbox_code !!}
                        </section>
                    @endif
                </div>
            </aside>

        </div>
    </div>
</section>


<!-- ================== KEEP DONATING TO URGENT CAMPAIGNS ================== -->
<section class="bg-[#f3f4f6] pt-12">
    <div class="max-w-6xl mx-auto px-4">

        <!-- heading -->
        <h2 class="text-3xl md:text-4xl font-semibold uppercase text-[#D94647] mb-8">
             {!! translate('Keep donating to urgent') !!}
        </h2>

        <!-- cards -->
        <div class="grid gap-6 md:grid-cols-3">

            @foreach($campaigns as $item)
            @php
                        $slug = $item->getTranslation('slug', app()->getLocale(), false) ?? $item->getTranslation('slug', 'en');
                        @endphp
            <article class="relative flex flex-col  rounded-tl-[14px] rounded-tr-[14px]  rounded-bl-none rounded-br-none bg-[#f97373] shadow-xl overflow-hidden">
              <div class="relative">
                <img src="{{ asset('storage/hero_image/'.$item->hero_image) }}" alt="{{ $item->title }}"  title="{{ $item->title }}" class="w-full h-56 object-cover" />
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2
                                bg-white text-slate-900 px-10 py-3 rounded-t-md shadow-md 
                                text-center text-sm font-semibold whitespace-nowrap min-w-[240px]"> 
                        {{ \Illuminate\Support\Str::limit($item->title ?? '', 35) }}
                    </div>
              </div>

              <div class="flex-1 flex flex-col pt-9 pb-6 px-6 text-md text-white/95">
                <p class="leading-relaxed">
                   {{ \Illuminate\Support\Str::limit($item->sub_title ?? '', 100) }}
                </p>
                <div class="text-center mb-5 md:mb-8">
@foreach($campaigns as $item)
                                @php
                                    $campaignPath = $locale === 'es'
                                        ? ($item->getTranslation('path', 'es', false) ?: $item->getTranslation('path', 'en', false))
                                        : ($item->getTranslation('path', 'en', false) ?: $item->getTranslation('path', 'es', false));

                                    $campaignSlug = $locale === 'es'
                                        ? ($item->getTranslation('slug', 'es', false) ?: $item->getTranslation('slug', 'en', false))
                                        : ($item->getTranslation('slug', 'en', false) ?: $item->getTranslation('slug', 'es', false));

                                    $campaignPath = is_string($campaignPath) ? trim($campaignPath) : '';
                                    $campaignSlug = is_string($campaignSlug) ? trim($campaignSlug) : '';

                                    $campaignUrl = null;

                                    if ($campaignPath !== '' && $campaignSlug !== '') {
                                        $campaignUrl = $locale === 'es'
                                            ? route('campaignsdetailsEsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug])
                                            : route('campaignsdetailsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug]);
                                    }
                                @endphp

                                @if($campaignUrl)
                                    <a href="{{ $campaignUrl }}"
                                       class="block px-4 py-2 border-b border-slate-100 hover:bg-red-50 hover:text-[#f04848] normal-case capitalize">
                                        {{ $item->title }}
                                    </a>
                                @endif
                            @endforeach
                </div>
              </div>

              <div class="h-[10px] w-full" style="background-color: {{ $item->bg_color ?? '#FFE36B' }};"></div>  
            </article>
            @endforeach

        </div>

        <!-- explore link -->
        <div class="mt-6 text-right">
            <a href="{{ route('campaigns') }}"
               class="text-sm text-[#e24b4b] underline">
                  {{ translate('Explore all Campaigns') }}
            </a>
        </div>

    </div>
</section>


 @include('frontend.includes.news_letter')

  <div class="py-5 bg-[#f6f6f6]"> 
      @include('frontend.includes.scroll_element')
  </div>
@endsection