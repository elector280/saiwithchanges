@extends('frontend.layouts.master')

@php
    $locale = app()->getLocale();
    $alt = $image->alt_text[$locale] ?? $image->title;
    $caption = $image->caption[$locale] ?? '';
    $tags = is_array($image->tags) ? implode(',', $image->tags) : $image->tags;
@endphp

@section('title', $image->title ?? 'Gallery Image Details')
@section('meta_description', $image->description ?? '')
@section('meta_keyword', $tags ?? '')


@section('meta')


<meta name="description" content="{{ strip_tags($caption) }}">
<meta name="keywords" content="{{ $tags }}">
<meta name="author" content="{{ $image->credit_copyrights }}">

{{-- Open Graph --}}
<meta property="og:title" content="{{ $image->title }}">
<meta property="og:description" content="{{ strip_tags($caption) }}">
<meta property="og:image" content="{{ asset('storage/gallery_image/'.$image->image) }}"> 
<meta property="og:type" content="article">
<meta property="og:image:alt" content="{{ $alt }}">
@endsection


@section('frontend')

<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- Image Section --}}
    <div class="bg-white shadow-md rounded-md overflow-hidden">

     @php
            $title = $image->title;
            if (is_string($title)) {
                $d = json_decode($title, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                    $title = $d[app()->getLocale()] ?? ($d['en'] ?? reset($d));
                }
            } elseif (is_array($title)) {
                $title = $title[app()->getLocale()] ?? ($title['en'] ?? reset($title));
            }

            $seoSlug =
                $image->slug ?:
                \Illuminate\Support\Str::slug($title ?: 'gallery-' . $image->id);
            $ext = pathinfo($image->image, PATHINFO_EXTENSION) ?: 'jpg';
        @endphp


        @php
            $locale = session('locale', config('app.locale'));
    
            $path = $locale === 'es'
                ? ($image->campaign->getTranslation('path', 'es', false) ?: $image->campaign->getTranslation('path', 'en', false))
                : ($image->campaign->getTranslation('path', 'en', false) ?: $image->campaign->getTranslation('path', 'es', false));
    
            $slug = $locale === 'es'
                ? ($image->campaign->getTranslation('slug', 'es', false) ?: $image->campaign->getTranslation('slug', 'en', false))
                : ($image->campaign->getTranslation('slug', 'en', false) ?: $image->campaign->getTranslation('slug', 'es', false));
        @endphp
    
        <div class="relative">
    <img 
        src="{{ route('gallery.image', [
            'campaignSlug' => $image->campaign->slug['en'] ?? $image->campaign->slug,
            'imageSlug' => $image->slug,
            'ext' => $ext,
        ]) }}"
        alt="{{ $image->alt_text ?? $image->title ?? 'Gallery Image' }}"
        title="{{ $image->title ?? $image->alt_text ?? 'Gallery Image' }}"
        class="w-full h-[500px] object-cover shadow-lg"
    > 

    {{-- Caption --}}
    @if($image->caption)
        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent text-white px-4 py-3 text-sm md:text-base">
            {{ $image->caption ?? '' }}
        </div>
    @endif

    {{-- Credit / Copyright --}}
    @if($image->credit_copyrights)
        <div class="absolute bottom-0 right-0 bg-black/70 text-white text-xs px-3 py-1 rounded-tl-md">
            © {{ $image->credit_copyrights ?? ''  }}
        </div>
    @endif
</div>


        {{-- Content --}}
        <div class="p-6"> 
            <div style="margin-bottom:20px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">

@if($path && $slug)
    <a href="{{ $locale === 'es'
                        ? route('campaignsdetailsEsDyn', ['path' => $path, 'slug' => $slug])
                        : route('campaignsdetailsDyn', ['path' => $path, 'slug' => $slug]) }}" 
       style="display:flex; align-items:center; gap:12px; text-decoration:none;">
@endif
        {{-- Campaign Badge --}}
        <span style="
            display:inline-flex;
            align-items:center;
            gap:6px;
            background:#FFF0A1;
            color:#2261AA;
            font-size:12px;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:1px;
            padding:6px 12px;
            border-radius:20px;
            box-shadow:0 2px 6px rgba(0,0,0,0.08);
            white-space:nowrap;
            transition: transform 0.2s, box-shadow 0.2s;
        " 
        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';" 
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.08)';">
            <span style="
                width:8px;
                height:8px;
                background:#2261AA;
                border-radius:50%;
                display:inline-block;
            "></span>
            {{ translate('Campaign') }}
        </span>

        {{-- Campaign Title --}}
        <span style="
            font-size:24px;
            font-weight:800;
            color:#2261AA;
            position:relative;
            white-space:nowrap;
            transition: color 0.2s;
        " 
        onmouseover="this.style.color='#FFDD57';" 
        onmouseout="this.style.color='#2261AA';">
            {{ $image->campaign->title }}

            {{-- Optional small underline accent --}}
            <span style="
                position:absolute;
                left:0;
                bottom:-4px;
                width:60px;
                height:3px;
                background:#FFF0A1;
                border-radius:3px;
                transition: width 0.2s;
            "></span>
        </span>

    </a>

</div>



            <h1 class="text-3xl font-bold text-gray-800 mb-3">
                {{ $image->title }}
            </h1>

            @if($caption)
            <p class="text-gray-600 leading-relaxed mb-4">
                {{ $caption }}
            </p>
            @endif

            {{-- Tags --}}
            @if($image->tags)
            <div class="mt-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-2">
                    Related Tags:
                </h2>
                <div class="flex flex-wrap gap-2">
                    @foreach((array)$image->tags as $tag)
                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                            #{{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Description --}}
            @if($image->description)
            <div class="mt-6 border-t pt-4">
                <h2 class="text-xl font-semibold mb-2 text-gray-800">
                    Details
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    {!! nl2br(e($image->description)) !!}
                </p>
            </div>
            @endif

        </div>
    </div>

</div>

@endsection
