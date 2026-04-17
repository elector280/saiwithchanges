@extends('frontend.layouts.master')

@section('title', $story->seo_title)
@section('meta_description', $story->meta_description)
@section('meta_keyword', $story->tags)
 
@section('meta')
@php
  $title = $story->seo_title ?? $story->localeTitleShow();
  $desc  = $story->meta_description ?? strip_tags($story->description ?? '');
  $locale = session('locale', config('app.locale'));
  $url = $locale === 'es'
      ? route('blogDetailsEs', $story->slug)
      : route('blogDetails', $story->slug);
      
  $img   = !empty($story->image) ? asset('storage/story_image/'.$story->image) : asset('images/og-default.jpg');
@endphp


<link rel="canonical" href="{{ $url }}">  

{{-- ✅ hreflang (EN/ES switch থাকলে খুব দরকার) --}}
<link rel="alternate" hreflang="{{ app()->getLocale() }}" href="{{ $url }}"> 
<link rel="alternate" hreflang="x-default" href="{{ $url }}">
{{-- ================= Open Graph / Twitter Card ================= --}}

<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:image" content="{{ $img }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ $url }}">
<meta property="og:type" content="article">
<meta property="og:site_name" content="South American Initiatives">

{{-- ✅ Twitter Card --}}

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:image" content="{{ $img }}">

@include('frontend.seo.blog_details')

@endsection

@section('frontend')

<style>
  /* small helper (optional) */
  .shadow-soft{ box-shadow: 0 10px 30px rgba(0,0,0,.08); }
</style>

{{-- TOP RED STRIP BACKGROUND (like screenshot) --}}
<section id="top" class="hidden sm:block bg-[#FE6668] sm:h-72 md:h-56 md:-mt-36"></section>



{{-- MAIN WRAP --}}
<section class="md:h-32"></section>
<section class=" md:-mt-48 pb-10 relative z-10">
  <div class="max-w-7xl md:mx-auto md:px-4">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,3fr)_minmax(0,1fr)]">

      {{-- ================= LEFT: STORY CARD ================= --}}
      <div class="space-y-6">

        {{-- MAIN STORY CARD --}}
        <article class="bg-white border border-gray-200 shadow-soft overflow-hidden">

          {{-- FEATURED IMAGE (top banner) --}}
          <div class="relative w-full h-[190px] md:h-[300px] overflow-hidden bg-gray-200">
            @php
                $locale = app()->getLocale();

                // Title normalize (আপনার আগের মতোই)
                $title = $story->title;
                if (is_string($title)) {
                    $d = json_decode($title, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                        $title = $d[$locale] ?? ($d['en'] ?? reset($d));
                    }
                } elseif (is_array($title)) {
                    $title = $title[$locale] ?? ($title['en'] ?? reset($title));
                }

                // Story slug normalize (json/string/array)
                $sSlug = $story->slug;
                if (is_string($sSlug)) {
                    $d = json_decode($sSlug, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                        $sSlug = $d[$locale] ?? ($d['en'] ?? reset($d));
                    }
                } elseif (is_array($sSlug)) {
                    $sSlug = $sSlug[$locale] ?? ($sSlug['en'] ?? reset($sSlug));
                }

                // imageSlug: DB image_url prefer, fallback seo slug
                $imageSlug = $story->image_url ?: \Illuminate\Support\Str::slug($title ?: ('gallery-' . $story->id));

                // ext from original file name
                $ext = strtolower(pathinfo($story->image ?? '', PATHINFO_EXTENSION) ?: 'jpg');
            @endphp

            @if(!empty($story->image))
                <img
                    src="{{ route('gallery.image.story', [
                        'reportSlug' => $sSlug,
                        'imageSlug'  => $imageSlug,
                        'ext'        => $ext,
                    ]) }}"
                    alt="{{ $title ?? '' }}"
                >
            @endif


            {{-- dark overlay like screenshot --}}
            <div class="absolute inset-0 bg-black/20"></div>

            {{-- Back to News (top-left) --}}
            <a href="{{ route('news') }}"
              class="absolute top-3 left-3 md:top-4 md:left-4 z-20
                      text-white text-[12px] md:text-[13px] flex items-center gap-2 drop-shadow">
              <span class="text-[18px] leading-none">‹</span>
              <span> {{ translate('Back to News') }}</span>
            </a>

            {{-- Bottom overlay content --}}
            <div class="absolute left-0 right-0 bottom-0 z-20 px-3- md:px-6- pb-3- md:pb-4-">

              {{-- badges row --}}
              <div class="flex flex-wrap items-center gap-2 md:gap-3 mb-2 px-4">

                <span class="hidden sm:block  bg-[#f3f3f3] text-gray-600 text-[12px] font-extrabold uppercase tracking-wide px-4 py-2 rounded-md- shadow">
                  {{ translate('Campaign') }}
                </span> 

                <span class="bg-[#ff6b6b] text-white text-[12px] font-extrabold uppercase tracking-wide   px-6 py-2 rounded-sm shadow">
                  {{ \Illuminate\Support\Str::limit($story->campaign->title ?? '', 20) }}
                </span>

                @if (!empty($story->campaign->slug))
                <a href="{{ session('locale', config('app.locale')) === 'es' ? route('campaignsdetailsEsDyn', ['path' => $story->campaign->path, 'slug' => $story->campaign->slug]) : route('campaignsdetailsDyn', ['path' => $story->campaign->path, 'slug' => $story->campaign->slug]) }}">
                <span class="bg-[#ff6b6b] text-white px-4 py-2 rounded-sm shadow text-[12px] font-extrabold">
                  ↗
                </span> 
                </a>
                 @endif

                @php 
                $category = $story->category;
                @endphp
                <a href="{{ route('news', array_filter(['category' => $category->id, 'q' => request('q')])) }}">
                  <span class="hidden sm:block  text-[12px] px-6 py-2 rounded-sm shadow" style="background-color: {{ $category->bg_color }}; color:black;">
                    {{ $category->name ?? '' }}
                  </span>
                </a>
              </div>

              {{-- big title bar --}}
              <div class="bg-[#ff6b6b] text-white rounded-md- shadow px-4 md:px-6 py-3 md:py-4">
                <h1 class="text-[18px] md:text-[30px] font-extrabold leading-tight">
                  {{ $story->title }}
                </h1>
              </div>

            </div>
          </div>

  
 

          {{-- CONTENT --}}
          <div class="px-4 md:px-8 py-6">

            {{-- META ROW (category/date/author/comments + social dots) --}}
            <div class="flex flex-wrap items-center justify-between gap-3 mb-3">

              <div class="flex flex-wrap items-center gap-2 text-[11px]">
                <span class="px-3 py-1 rounded-full bg-[#f04848] text-white font-bold uppercase tracking-[.12em]">
                   {{ translate('Report') }}
                </span>
                <span class="text-gray-400">|</span>

                <span class="inline-flex items-center gap-1 text-gray-500">
                  <i class="far fa-calendar-alt"></i>
                  {{ optional($story->created_at)->format('M d, Y') }}
                </span>

                <span class="text-gray-400">|</span>

                <span class="inline-flex items-center gap-1 text-gray-500">
                  <i class="far fa-user"></i>
                  {{ $story->user->name ?? '' }}
                </span>

                <!-- <span class="text-gray-400">|</span>

                <span class="inline-flex items-center gap-1 text-gray-500">
                  <i class="far fa-comment"></i>
                  0
                </span> -->
              </div>

              {{-- SOCIAL DOTS (right) --}}
              <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#ff5c5c]"></span>
                <span class="w-2 h-2 rounded-full bg-[#ffcf34]"></span>
                <span class="w-2 h-2 rounded-full bg-[#0047ab]"></span>
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
              </div>
            </div>


            {{-- SHORT DESCRIPTION --}}
            @if(!empty($story->description))
              <div class="text-[13px] md:text-[14px] text-gray-500 leading-relaxed mb-5">
                {!! $story->description !!}
              </div>
            @endif

            {{-- MAIN BODY (summary + long parts) --}}
            <div class="space-y-5 text-[13px] md:text-[14px] text-gray-600 leading-relaxed">

              @if(!empty($story->summary))
                <div class="prose max-w-none">
                  {!! $story->summary !!}
                </div>
              @endif

            </div>

            {{-- CTA MINI CARD (bottom inside story card like screenshot) --}}
             <div class="mt-8 border border-gray-200 overflow-hidden">
                <div class="grid md:grid-cols-2">
                  <div class="bg-[#f04848] text-white p-6">
                    <p class="text-[10px] font-bold uppercase opacity-90">
                      {!! $story->footer_title !!}
                    </p>
                    <h3 class="mt-2 text-[16px] md:text-[18px] font-extrabold uppercase leading-snug">
                        {!! $story->footer_subtitle !!}
                    </h3> 
                    @if (!empty($story->campaign->slug))
                    <a href="{{ session('locale', config('app.locale')) === 'es' ? route('campaignsdetailsEsDyn', ['path' => $story->campaign->path, 'slug' => $story->campaign->slug]) : route('campaignsdetailsDyn', ['path' => $story->campaign->path, 'slug' => $story->campaign->slug]) }}" class="inline-flex mt-4 items-center justify-center bg-white text-[#f04848] px-5 py-2 text-[11px] font-extrabold uppercase">
                      {{ translate('Donate to this project') }}
                    </a>
                    @endif
                  </div> 

                  @php
                      $locale = app()->getLocale();

                      // story slug normalize
                      $sSlug = $story->slug;
                      if (is_string($sSlug)) {
                          $d = json_decode($sSlug, true);
                          if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                              $sSlug = $d[$locale] ?? ($d['en'] ?? reset($d));
                          }
                      } elseif (is_array($sSlug)) {
                          $sSlug = $sSlug[$locale] ?? ($sSlug['en'] ?? reset($sSlug));
                      }

                      $footerSlug = $story->footer_image_url ?: ('footer-' . $story->id);
                      $footerExt  = strtolower(pathinfo($story->footer_image2 ?? '', PATHINFO_EXTENSION) ?: 'jpg');
                  @endphp

                  <div class="relative h-40 md:h-auto">
                    @if(!empty($story->image))
                    <img
                      src="{{ route('gallery.image.story', [
                        'reportSlug' => $sSlug,
                        'imageSlug'  => $imageSlug,
                        'ext'        => $ext,
                    ]) }}"
                    alt="{{ $title ?? '' }}"  class="w-full h-full object-cover"  alt="{{ $story->footer_title }}">
                    @endif
                    <div class="absolute inset-0 bg-[#f04848]/25"></div>
                  </div>
                </div>
              </div>
          </div>

          {{-- FOOT LINK --}}
          <div class="py-2"> 
              @include('frontend.includes.scroll_element')
          </div>
        </article>
      </div>

      {{-- ================= RIGHT: SIDEBAR (Donation + Newsletter) ================= --}}
      <aside class="space-y-5" id="Payment">
        <div class="">
          @if(!empty($story->campaign->donorbox_code ))
              <section class="space-y-2- prose max-w-none">
                  {!! $story->campaign->donorbox_code  !!}
              </section>
          @endif
        </div>
      </aside>
    </div>
  </div>
</section>


<section class="bg-[#FE6668] mt-20 md:mt-20 pb-16 relative z-10">
    <div class="max-w-7xl mx-auto px-3 md:px-4">

      {{-- TITLE --}}
      <h2 class="text-white text-3xl md:text-4xl font-semibold pt-10">
        {{ translate('Read other Articles') }} 
      </h2>

      {{-- DIVIDER LINE --}}
      <div class="mt-6 h-px bg-white/45 w-full"></div>

      {{-- CARDS --}}
      <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($relatedStories as $i => $rs)
            <article class="bg-white rounded-[10px] overflow-hidden shadow-[0_14px_35px_rgba(0,0,0,.16)]">

                {{-- IMAGE --}}
                <div class="h-[210px] bg-gray-200 overflow-hidden">
                @if(!empty($rs->image))
                    <img
                    src="{{ asset('storage/story_image/'.$rs->image) }}"
                    class="w-full h-full object-cover"
                    alt="{{ $rs->title }}" title="{{ $rs->title }}">
                @endif
                </div>

                {{-- PINK TITLE BAR --}}
                <div class="bg-[#ff6b6b] text-white text-center px-4 py-3">
                <p class="text-[13px] font-extrabold tracking-wide">
                     {{ \Illuminate\Support\Str::limit($rs->title ?? '', 100) }}
                </p>
                </div> 

                {{-- BODY (LIGHT GRAY) --}}
                <div class="bg-[#f2f2f2] px-5 py-5">
                <p class="text-[14px] leading-relaxed text-gray-500">
                    {{ \Illuminate\Support\Str::limit($rs->short_description ?? '', 100) }}
                </p>

                {{-- FOOTER --}}
               <div class="mt-5 flex items-center justify-between flex-wrap gap-3 text-[11px] text-gray-400">

                    {{-- Left part: Date, Posted By, User --}}
                    <div class="flex items-center gap-4 flex-wrap">
                        <span>{{ optional($rs->created_at)->format('j M Y') }}</span>

                        <span class="flex items-center gap-2">
                            <span> {{ translate('Posted By') }} </span>
                            <span class="w-3 h-3 rounded-full border border-gray-400 inline-block"></span>
                        </span>

                        <span class="font-bold text-gray-500 uppercase">
                            {{ $rs->user->name ?? '--' }}
                        </span>
                    </div>

                    {{-- Right part: Read More button --}}
                    <a href="{{ route('blogDetails', $rs->slug) }}"
                    class="inline-flex items-center justify-center
                            border border-[#ff6b6b] text-[#ff6b6b]
                            px-4 py-2 text-[12px] font-medium rounded-[2px]
                            hover:bg-[#ff6b6b] hover:text-white transition">
                         {{ translate('Read more') }} 
                    </a>
                </div>

                </div>

            </article>
        @endforeach


      </div>
    </div>
</section>


{{-- ✅ Amount UI toggle (optional) --}}

<script src="https://donorbox.org/widget.js" paypalExpress="true"></script>
<script>
  document.addEventListener('click', function(e){
    const item = e.target.closest('.amount-item');
    if(!item) return;

    // check the hidden radio
    const radio = item.querySelector('input[type="radio"]');
    if(radio) radio.checked = true;

    // reset all
    document.querySelectorAll('#amountList .amount-item').forEach(el=>{
      el.classList.remove('border-[#f04848]','bg-[#fff5f5]');
      el.classList.add('border-gray-300');
      const dot = el.querySelector('.dot');
      const fill = el.querySelector('.dotFill');
      if(dot){ dot.classList.remove('border-[#f04848]'); dot.classList.add('border-gray-400'); }
      if(fill){ fill.classList.add('hidden'); }
    });

    // active styles
    item.classList.add('border-[#f04848]','bg-[#fff5f5]');
    item.classList.remove('border-gray-300');
    const dot = item.querySelector('.dot');
    const fill = item.querySelector('.dotFill');
    if(dot){ dot.classList.add('border-[#f04848]'); dot.classList.remove('border-gray-400'); }
    if(fill){ fill.classList.remove('hidden'); fill.classList.add('bg-[#f04848]'); }
  });
</script>



@endsection
