
@extends('frontend.layouts.master')


@section('title', translate('News page meta title'))
@section('meta_description', translate('News page meta description'))
@section('meta_keyword', translate('News page meta keyword'))

@section('meta')
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- Open Graph --}}
  <meta property="og:title" content="{{ translate('News page title') }}">
  <meta property="og:description" content="{{ translate('News page description') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ asset('storage/logo/'.$setting->logo) }}">

  {{-- Twitter --}}
  <meta name="twitter:card" content="{{ asset('storage/logo/'.$setting->logo) }}">
  <meta name="twitter:title" content="{{ translate('News page title') }}">
  <meta name="twitter:description" content="{{ translate('News page description') }}"> 
  <meta name="twitter:image" content="{{ asset('storage/logo/'.$setting->logo) }}">
@endsection


@section('frontend')

@php
  $isSearching = request()->filled('q');
@endphp


{{-- TOP HERO / TITLE BAR --}}
<section class="bg-[#FEC7C8] text-white pt-10 pb-14 -mt-36 h-[700px]" id="heroSection">
    <div class="max-w-6xl px-4- mx-auto">

        <div class="bg-[#D94647] py-3 px-5 w-full mt-36 shadow-lg round-md inline-block relative overflow-hidden">
            <h1 class="text-2xl md:text-5xl font-bold  uppercase">
                {!! translate('News Stories from the Continent') !!}
            </h1>

            <div class="absolute top-0 right-0 hidden w-16 h-full md:block">
                <div class="absolute inset-y-0 right-4 w-8 bg-[#2261aa]
                    skew-x-[42deg]">
                </div>

                <div class="absolute inset-y-0 right-0 w-6 bg-[#fff0a1]
                    skew-x-[42deg]">
                </div>
            </div>
        </div>

        <div class="py-6 mt-8 md:my-16">

            {{-- ✅ Search (optional) --}}
            <form method="GET" action="{{ route('news') }}" class="flex justify-center">
                <div class="relative md:w-full max-w-2xl">
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Search or articles, words, Campaigns or anything"
                           class="w-full h-8 pl-4 pr-10 text-sm bg-white text-gray-800
                            placeholder-gray-400 rounded-sm shadow
                            outline-none focus:ring-2 focus:ring-[#FE6668]">

                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <button type="submit" class="absolute text-gray-500 -translate-y-1/2 right-3 top-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- ✅ Category buttons (click => reload with ?category=slug) --}}
<div class="mt-5 flex flex-nowrap sm:flex-wrap items-center gap-3 sm:gap-6
            overflow-x-auto sm:overflow-visible justify-start sm:justify-center whitespace-nowrap
            px-2 scroll-smooth" style="-webkit-overflow-scrolling: touch;">

    {{-- All --}}
    @if(!$isSearching && request('category'))
        <a href="{{ route('news', array_filter(['q' => request('q')])) }}"
           class="shrink-0 px-6 py-1 font-semibold rounded-tr-lg rounded-bl-lg transition-all duration-200"
           style="
                background-color: #ffffff;
                color: #FE6668;
                border: 1px solid #FE6668;
           ">
            {{ translate('All') }}
        </a>
    @endif

    @foreach($categories as $cat)
        @php
            $isActive = (string) $categoryId === (string) $cat->id;

            $inactiveBg = $cat->bg_color ?: '#ffffff';
            $inactiveText = $cat->text_color ?: '#111111';

            $activeBg = $cat->active_bg_color ?: $cat->bg_color ?: '#D94647';
            $activeText = $cat->active_text_color ?: '#ffffff';
        @endphp

        <a href="{{ route('news', array_filter(['category' => $cat->id, 'q' => request('q')])) }}"
           class="shrink-0 px-6 py-1 font-semibold rounded-tr-lg rounded-bl-lg transition-all duration-200"
           style="
                background-color: {{ $isActive ? $activeBg : $inactiveBg }};
                color: {{ $isActive ? $activeText : $inactiveText }};
                border: 1px solid {{ $isActive ? $activeBg : $inactiveBg }};
           ">
            {{ $cat->name }}
        </a>
    @endforeach

</div>


        </div>
    </div>
</section>

{{-- MAIN CONTENT AREA --}}
<section class="pt-10 pb-20 -mt-[300px] md:-mt-52">
    <div class="max-w-6xl px-4- mx-auto">

        {{-- MOST READ SECTION --}}
        
       @if(!$isSearching && !request()->filled('category'))
        <div class="mb-8 mt-5 mx-2">
            <h2 class="mb-8 text-base font-semibold text-gray-800 md:text-4xl">
                {{ translate(' Most read reports or Articles') }} 
            </h2>
            <hr class="w-full mb-8 text-grey-600">
 
            @include('frontend.includes.articles_news')

        </div>
        @endif


        @if(!$isSearching && !request()->filled('category'))
        <div class="mt-10 space-y-12 mx-3 md:mx-auto">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base md:text-2xl font-semibold text-gray-800">
                          {{ translate('Recent Articles') }}
                    </h2>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    @foreach($recent_articles as $item)
                        <article class="overflow-hidden bg-white rounded-md shadow-xl text-slate-900">
                            <div class="relative">
                                <img src="{{ asset('storage/story_image/'.$item->image) }}"
                                        alt="{{ $item->title }}" title="{{ $item->title }}"
                                        class="object-cover w-full h-52"
                                        onerror="this.onerror=null; this.src='https://via.placeholder.com/600x300?text=Image+Not+Found';" />

                                <div class="absolute left-0 right-16 -bottom-0">
                                    <div class="rounded-tr-xl px-3 py-2 text-left"  style="background-color: {{ $item->category->active_bg_color ?? '' }}; color: {{ $item->category->active_text_color ?? 'black' }};">
                                        <p class="text-[13px] font-bold leading-snug ">
                                            {{ \Illuminate\Support\Str::limit($item->title ?? '', 50) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!--<a href="{{ route('news', array_filter(['category' => $item->category->id, 'q' => request('q')])) }}"
                                class="inline-flex items-center gap-1 px-4 py-1.5 text-sm font-semibold transition duration-200 hover:scale-105">
                                    <i class="fa-solid fa-tag text-xs"></i>
                                    {{ $item->category->name ?? '---' }}
                            </a>-->

                            <div class="px-4 pt-8 pb-4 space-y-3 text-md">
                                <p class="leading-snug text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($item->localeTitleShow() ?? '', 100) }}
                                </p>

                                <div class="flex items-center justify-between gap-4 text-[11px] text-slate-500">
                                    <span class="whitespace-nowrap">{{ $item->created_at->format('j M Y') }}</span>

                                    <div class="flex items-center gap-2 whitespace-nowrap">
                                        <span>By</span>
                                        <span class="w-4 h-4 border border-slate-400 rounded-full"></span>
                                        <span class="font-semibold tracking-[0.06em] uppercase text-slate-700">
                                            {{ $item->user->name ?? '' }}
                                        </span>
                                    </div>

                                    <a href="{{ session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $item->slug) : route('blogDetails', $item->slug) }}"
                                        class="inline-flex items-center justify-center h-7 px-6 border border-[#ffb2b2]
                                                text-[#ff8a8a] bg-white text-[12px] font-medium rounded-sm whitespace-nowrap"  style="border: 1px solid {{ $item->category->text_color ?? '#ffb2b2' }} !important;  color: {{ $item->category->text_color ?? '#ff8a8a' }} !important;">
                                         {{ translate('Read more') }} &gt;
                                    </a>
                                </div>
                            </div>
                        </article> 
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- ✅ CATEGORY-WISE STORIES (Recent removed) --}}
        <div class="mt-10 space-y-12  mx-3 md:mx-auto">

            @foreach($categoryWise as $cat)
                @if($cat->stories->count() == 0)
                    @continue
                @endif

                <div>
                    
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base md:text-2xl font-semibold text-gray-800">
                            {{ $cat->name }}
                        </h2>

                        {{--
                        <a href="{{ route('news', ['category' => $cat->id]) }}"
                           class="text-[12px] text-[#FE6668] font-semibold hover:underline">
                              {{ translate('View all') }}  &gt;
                        </a>
                         --}}
                    </div>
                    
                   

                    <div class="grid gap-6 md:grid-cols-2">
                        @foreach($cat->stories as $item)
                            <article class="overflow-hidden bg-white rounded-md shadow-xl text-slate-900">
                                <div class="relative">
                                    <img src="{{ asset('storage/story_image/'.$item->image) }}"
                                         alt="{{ $item->title }}" title="{{ $item->title }}"
                                         class="object-cover w-full h-52"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/600x300?text=Image+Not+Found';" />

                                    <div class="absolute left-0 right-16 -bottom-0">
                                        <div class="rounded-tr-xl px-3 py-2 text-left"   style="background-color: {{ $item->category->active_bg_color ?? '' }}; color: {{ $item->category->active_text_color ?? 'black' }};">
                                            <p class="text-[13px] font-bold leading-snug">
                                                {{ \Illuminate\Support\Str::limit($item->title ?? '', 50) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!--<a href="{{ route('news', array_filter(['category' => $item->category->id, 'q' => request('q')])) }}"
                                    class="inline-flex items-center gap-1 px-4 py-1.5 text-sm font-semibold transition duration-200 hover:scale-105">
                                        <i class="fa-solid fa-tag text-xs"></i>
                                        {{ $item->category->name ?? '---' }}
                                </a>-->

                                <div class="px-4 pt-8 pb-4 space-y-3 text-md">
                                    <p class="leading-snug text-slate-600">
                                        {{ \Illuminate\Support\Str::limit($item->localeTitleShow() ?? '', 100) }}
                                    </p>

                                    <div class="flex items-center justify-between gap-4 text-[11px] text-slate-500">
                                        <span class="whitespace-nowrap">{{ $item->created_at->format('j M Y') }}</span>

                                        <div class="flex items-center gap-2 whitespace-nowrap">
                                            <span>{{ translate('By') }}</span>
                                            <span class="w-4 h-4 border border-slate-400 rounded-full"></span>
                                            <span class="font-semibold tracking-[0.06em] uppercase text-slate-700">
                                                {{ $item->user->name ?? '' }}
                                            </span>
                                        </div>

                                        <a href="{{ session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $item->slug) : route('blogDetails', $item->slug) }}"
                                           class="inline-flex items-center justify-center h-7 px-6 border border-{{ $item->category->text_color ?? '#ffb2b2' }}
                                                  text-{{ $item->category->text_color ?? '#ffb2b2' }} bg-white text-[12px] font-medium rounded-sm whitespace-nowrap"  style="border: 1px solid {{ $item->category->text_color ?? '#ffb2b2' }} !important;  color: {{ $item->category->text_color ?? '#ff8a8a' }} !important;">
                                             {{ translate('Read more') }} &gt;
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
        




        @if(!$isSearching && !request()->filled('category'))
        <div class="mt-10 space-y-12 mx-3 md:mx-auto">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base md:text-2xl font-semibold text-gray-800">
                          {{ translate('Related articles') }}
                    </h2>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    @foreach($related_stories as $item)
                        <article class="overflow-hidden bg-white rounded-md shadow-xl text-slate-900">
                            <div class="relative">
                                <img src="{{ asset('storage/story_image/'.$item->image) }}"
                                        alt="{{ $item->title }}" title="{{ $item->title }}"
                                        class="object-cover w-full h-52"
                                        onerror="this.onerror=null; this.src='https://via.placeholder.com/600x300?text=Image+Not+Found';" />

                                <div class="absolute left-0 right-16 -bottom-0">
                                    <div class="rounded-tr-xl px-3 py-2 text-left"  style="background-color: {{ $item->category->bg_color ?? '' }}; color: {{ $item->category->text_color ?? 'black' }};">
                                        <p class="text-[13px] font-bold leading-snug uppercase">
                                            {{ \Illuminate\Support\Str::limit($item->title ?? '', 50) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!--<a href="{{ route('news', array_filter(['category' => $item->category->id, 'q' => request('q')])) }}"
                                class="inline-flex items-center gap-1 px-4 py-1.5 text-sm font-semibold transition duration-200 hover:scale-105">
                                    <i class="fa-solid fa-tag text-xs"></i>
                                    {{ $item->category->name ?? '---' }}
                            </a>-->

                            <div class="px-4 pt-8 pb-4 space-y-3 text-md">
                                <p class="leading-snug text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($item->localeTitleShow() ?? '', 100) }}
                                </p>

                                <div class="flex items-center justify-between gap-4 text-[11px] text-slate-500">
                                    <span class="whitespace-nowrap">{{ $item->created_at->format('j M Y') }}</span>

                                    <div class="flex items-center gap-2 whitespace-nowrap">
                                        <span>By</span>
                                        <span class="w-4 h-4 border border-slate-400 rounded-full"></span>
                                        <span class="font-semibold tracking-[0.06em] uppercase text-slate-700">
                                            {{ $item->user->name ?? '' }}
                                        </span>
                                    </div>

                                    <a href="{{ session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $item->slug) : route('blogDetails', $item->slug) }}"
                                        class="inline-flex items-center justify-center h-7 px-6 border border-{{ $item->category->text_color ?? '#ffb2b2' }}
                                                text-{{ $item->category->text_color ?? '#ffb2b2' }} bg-white text-[12px] font-medium rounded-sm whitespace-nowrap"  style="border: 1px solid {{ $item->category->text_color ?? '#ffb2b2' }} !important;  color: {{ $item->category->text_color ?? '#ff8a8a' }} !important;">
                                         {{ translate('Read more') }} &gt;
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

 <div class="pb-5"> 
      @include('frontend.includes.scroll_element')
  </div>

@endsection