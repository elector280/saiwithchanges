@extends('admin.layouts.master')

@section('title', 'Report Edit')

@section('css')
<link rel="stylesheet" href="{{ asset('backend-asset/plugins/summernote/summernote-bs4.min.css') }}">
<style>
    .note-editor.note-frame {
        border-radius: 6px;
    }
</style>
@endsection

@section('admin')

@php
    $locale = Session::get('locale', config('app.locale'));
    $langCode = \App\Models\Language::where('language_code', $locale)->first();
    $currentPath = old('reportpath.' . $locale, $story->getDirectValue('reportpath', $locale));
    $currentSlug = old('slug.' . $locale, $story->getDirectValue('slug', $locale));
    $currentFullUrl = trim(($currentPath ? $currentPath . '/' : '') . $currentSlug, '/');
@endphp

    <div class="container-fluid pt-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
            <div class="mb-3 mb-md-0">
                <h3 class="mb-2 font-weight-bold main-page-heading">
                    Edit Report —
                    <a href="javascript:void(0)" class="text-primary">{{ $story->title }}</a>
                </h3>

                <div class="small">
                    <a href="{{ url('/dashboard') }}" class="text-primary">Dashboard</a>
                    <span class="text-muted mx-1">/</span>
                    <a href="{{ route('stories.index') }}" class="text-primary">Report</a>
                    <span class="text-muted mx-1">/</span>
                    <span class="text-muted">Edit — {{ $story->title }}</span>
                </div>
            </div>

            <div class="d-flex flex-wrap">
                <a href="{{ route('stories.index') }}" class="btn btn-sm btn-default mr-2 mb-2 mb-md-0 w3-round-large">
                    <i class="far fa-file-alt mr-1"></i> All Report
                </a>

                <a href="{{ session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $story->slug) : route('blogDetails', $story->slug) }}" class="btn btn-sm btn-dark mb-2 mb-md-0 w3-round-large" target="_blank">
                    <i class="far fa-eye mr-1"></i> Live Preview
                </a>
            </div>
        </div>

      

        <div class="form-group">
            {{-- hidden input: final combined value --}}
            <input type="hidden"
                id="slugHiddenInput"
                name="slug[{{ $locale }}]"
                value="{{ $currentFullUrl }}">

            <div class="alert mb-0 py-2 px-3 w3-round-large"
                id="campaignUrlBox"
                style="background-color: #DFF5F3;">

                <div class="d-flex align-items-center flex-wrap" style="gap:10px;">

                    {{-- VIEW MODE --}}
                    <div id="urlViewMode" class="d-flex align-items-center flex-wrap" style="gap:10px;">
                        <i class="fas fa-link"></i>

                        <span id="campaignUrlText">
                            sai.ngo/{{ $currentFullUrl }}
                        </span>

                        <button type="button"
                                id="editUrlBtn"
                                class="btn btn-xs text-black border"
                                style="background-color:#D6EADC; color:#000;">
                            <i class="far fa-edit mr-1"></i> Edit
                        </button>
                    </div>

                    {{-- EDIT MODE --}}
                    <div id="urlEditMode" class="w-100" style="display:none;">
                        <div class="d-flex align-items-center flex-wrap" style="gap:10px;">
                            <span class="font-weight-bold">sai.ngo/</span>

                            <input type="text"
                                id="campaignUrlInput"
                                class="form-control"
                                style="max-width:350px;"
                                value="{{ $currentFullUrl }}"
                                placeholder="usa/help-venezuela">

                            <button type="button"
                                    id="saveUrlBtn"
                                    class="btn btn-success btn-sm">
                                <i class="far fa-save mr-1"></i> Save
                            </button>

                            <button type="button"
                                    id="cancelUrlBtn"
                                    class="btn btn-secondary btn-sm">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </button>
                        </div>

                        <small class="text-danger d-block mt-2" id="urlError" style="display:none;"></small>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-3">
        <div class="card card-outline card-light w3-round-large">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-between align-items-center mt-2- flex-wrap">
                    
                    @php
                        $currentLocale = session('locale', config('app.locale'));
                        $languages = App\Models\Language::where('active', 1)->get();
                    @endphp

                    <div class="nav nav-pills">
                        @foreach ($languages as $language)
                            <form action="{{ route('languageUpdateStatus', $language) }}" method="POST" class="mr-2">
                                @csrf

                                <button
                                    type="submit"
                                    class="nav-link font-weight-bold border-0 {{ $currentLocale === $language->language_code ? 'active' : 'bg-light text-muted border-lg' }}" style="border-radius:10px !important;">
                                    <span class="mr-2">
                                        <img src="{{ asset('storage/country_flag/'.$language->country_flag) }}" alt="" style="height:14px;width:20px;border-radius:1px;">
                                    </span>
                                    {{ $language->title }}
                                    <span class="font-weight-normal">
                                        ({{ strtoupper($language->language_code) }})
                                    </span>
                                </button>
                            </form>
                        @endforeach
                    </div>

                    <div class="small text-muted mt-3 mt-md-0">
                        <i class="far fa-file-alt mr-1"></i>
                        All content fields below are specific to the selected language.
                        Required fields marked <span class="text-danger">*</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-3">
        <form id="storyUpdateForm" action="{{ route('stories.update', $story->id) }}"  method="POST"  enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="card w3-round-large">
                <div class="card-header seo-card-header">
                    <div class="d-flex align-items-start">
                        <div class="seo-icon-box mr-3">
                            <i class="far fa-file-alt w-4"></i>
                        </div>

                        <div class="seo-header-content">
                            <div class="d-flex align-items-center flex-wrap">
                                <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">Author, Project & Category</b></h4>
                                <span class="badge badge-info px-2 py-1 seo-lang">
    {{ ucfirst($langCode->language_code) }}
</span>
                            </div>
                            <small class="seo-subtitle mb-0 label-color">
                            Attribution and classification — shared across both language versions
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Linked Project</label>
                                <select name="campaign_id" class="form-control select2" data-dropdown-css-class="select2-danger" required>
                                    <option value="">None</option>
                                    @foreach($campaigns as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $story->campaign_id ? 'selected' : '' }}>
                                            {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="seo-subtitle mb-0 label-color">
                                    The campaign this report belongs to.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Author</label>
                                <select name="user_id" class="form-control select2" data-dropdown-css-class="select2-danger" required>
                                    <option value="">-- None --</option>
                                    @foreach($author as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == $story->addedby_id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="seo-subtitle mb-0 label-color">
                                    Person credited as the report's author.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control select2" data-dropdown-css-class="select2-danger" required>
                                    @foreach($categories as $item)
                                    <option value="{{ $item->id}}" {{ $story->category_id == $item->id ? 'selected' : '' }}>{{ $item->name}}</option>
                                    @endforeach
                                </select>
                                <small class="seo-subtitle mb-0 label-color">
                                    Editorial category this report falls under.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card w3-round-large">
                 <div class="card-header seo-card-header">
                    <div class="d-flex align-items-start">
                        <div class="seo-icon-box mr-3">
                            <i class="far fa-file-alt w-4"></i>
                        </div>

                        <div class="seo-header-content">
                            <div class="d-flex align-items-center flex-wrap">
                                <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">CONTENT & NARRATIVE</b></h4>
                               <span class="badge badge-info px-2 py-1 seo-lang">
    {{ ucfirst($langCode->language_code) }}
</span>
                            </div>
                            <small class="seo-subtitle mb-0 label-color">
                                Report title, summary, and full body — English version
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Report Title</label>
                                        <input type="text"
                                            name="title[{{ $code }}]"
                                            class="form-control"
                                            value="{{ old('title.' . $code, $story->localeTitle($code)) }}"
                                            placeholder="Report Title">
                                        <small class="seo-subtitle mb-0 label-color">
                                            Repoer title change here
                                        </small>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Short description </label>
                                        <textarea
                                            name="short_description[{{ $code }}]"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Brief 1-2 sentence summary shown in report listings..."
                                        >{{ old('short_description.' . $code, $story->localeExcerpt($code)) }}</textarea>
                                        <small class="seo-subtitle mb-0 label-color">
                                            Displayed as a teaser in report cards and listing pages.
                                        </small>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    
                    </div>
                    <div class="seo-divider">
                        <span>Report Body</span>
                    </div>
                    <div class="row">

                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Full Report Content</label>
                                        <textarea  name="description[{{ $code }}]"  class="summernote form-control"
                                        rows="5">{{ old('description.' . $code, $story->localeDescription($code)) }}</textarea>
                                        <small class="seo-subtitle mb-0 label-color">
                                            Full editorial body rendered on the public report page.
                                        </small>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="card w3-round-large">
                 <div class="card-header seo-card-header">
                    <div class="d-flex align-items-start">
                        <div class="seo-icon-box mr-3">
                            <i class="far fa-file-alt w-4"></i>
                        </div>

                        <div class="seo-header-content">
                            <div class="d-flex align-items-center flex-wrap">
                                <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">SEO & SEARCH OPTIMIZATION</b></h4>
                                <span class="badge badge-info px-2 py-1 seo-lang">
    {{ ucfirst($langCode->language_code) }}
</span>
                            </div>
                            <small class="seo-subtitle mb-0 label-color">
                                Text shown in the bottom call-to-action strip — English version
                            </small>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="row">
                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                         @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-color req">
                                        Report URL <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group page-url-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text page-url-prefix">sai.ngo/</span>
                                        </div>

                                        <input type="text"
                                            id="slug"
                                            name="slug[{{ $code }}]"
                                            value="{{ old('reportpath.' . $code, $story->getDirectValue('reportpath', $code)) }}/{{ old('slug.' . $code, $story->getDirectValue('slug', $code)) }}"
                                            class="form-control page-url-input @error('slug') is-invalid @enderror"
                                            placeholder="usa/help-venezuela">
                                    </div> 

                                    @error('slug')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <div class="callout callout-info- mt-3 mb-0 py-1" style="background-color: #DFF5F3;">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="fas fa-file-alt text-info"></i>
                                            </div>
                                            <div class="mb-0">
                                                sai.ngo/{{ $story->reportpath }}/{{ $story->slug }}
                                            </div>
                                        </div>
                                    </div>

                                    <small class="page-url-help">
                                        Enter the full path after the domain — e.g. usa/help-venezuela. Use lowercase, hyphens only. Never change a live URL without setting up a redirect.
                                    </small>
                                </div>
                            </div>
                            @endif 
                        @endforeach

                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                                <div class="col md-12">
                                    <div class="form-group">
                                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                                            <span> SEO Title</span>
                                            <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                                meta name="title"
                                            </span>
                                        </label>
                                        <input type="text"
                                            name="seo_title[{{ $code }}]"
                                            class="form-control"
                                            value="{{ old('seo_title.' . $code, $story->localSeoTitle($code)) }}" placeholder="Meta title shown in search engine results...">
                                         

                                        <div class="d-flex justify-content-between align-items-center mt-2 mt-2 seo-note-wrap">
                                            <small class="seo-help-text">
                                                Recommended: 50–60 characters.
                                            </small>
                                            <small class="seo-count-text">
                                                <span id="seo_title_count_{{ $code }}">
                                                    {{ mb_strlen(old('seo_title.' . $code, $story->getDirectValue('seo_title', $code)) ?? '') }}
                                                </span> / 60
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                         <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                                            <span>Tags</span>
                                            <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                                meta name="title"
                                            </span>
                                        </label>
                                        <input type="text"
                                            name="tags[{{ $code }}]"
                                            class="form-control"
                                            value="{{ old('tags.' . $code, $story->localTag($code)) }}"
                                            placeholder="e.g. venezuela, humanitarian, news">
                                            <small class="seo-help-text">
                                                Comma-separated keywords for tagging and search.
                                            </small>
                                    </div>
                                </div>
                            @endif
                        @endforeach


                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                         <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                                            <span>Google Meta Description</span>
                                            <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                                meta name="description"
                                            </span>
                                        </label>
                                        <textarea name="meta_description[{{ $code }}]" rows="3" 
                                            class="form-control" placeholder="Description for google meta tags ({{ $code }})">{{ old('meta_description.' . $code, $story->localMetaDescription($code)) }}</textarea>
                                        <small class="seo-help-text">
                                            What it is: The short paragraph shown beneath the SEO Title in Google results. It doesn't directly affect ranking but strongly influences click-through rate. Aim for 120–160 characters.
                                        </small>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

             <div class="card  w3-round-large">
                <div class="card-header seo-card-header">
                    <div class="d-flex align-items-start">
                        <div class="seo-icon-box mr-3">
                            <i class="far fa-file-alt w-4"></i>
                        </div>

                        <div class="seo-header-content">
                            <div class="d-flex align-items-center flex-wrap">
                                <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">Footer Content</b></h4>
                                <span class="badge badge-info px-2 py-1 seo-lang">
    {{ ucfirst($langCode->language_code) }}
</span>
                            </div>
                            <small class="seo-subtitle mb-0 label-color">
                                Text shown in the bottom call-to-action strip — English version
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale) 
                                @php $code = $language->language_code; @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Footer Heading</label>
                                        <input type="text" name="footer_title[{{ $code }}]" class="form-control" value="{{ old('footer_title.' . $code, $story->getDirectValue('footer_title', $code)) }}" placeholder="e.g. Help People in Need">
                                        <small class="seo-subtitle mb-0 label-color">
                                            Large text at the top of the footer strip.
                                        </small>
                                    </div>
                                </div>
                            @endif 
                        @endforeach

                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Footer sub Heading  </label>
                                        <input type="text" name="footer_subtitle[{{ $code }}]" class="form-control" value="{{ old('footer_subtitle.' . $code, $story->getDirectValue('footer_subtitle', $code)) }}" placeholder="e.g. Start donating today, make the difference">
                                        <small class="seo-subtitle mb-0 label-color">
                                            Supporting text below the heading.
                                        </small>
                                    </div>
                                </div>
                            @endif 
                        @endforeach
                    </div>
                </div>
            </div>


        <div class="card  w3-round-large">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-image w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">Header Photo & Disposition</b></h4>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Upload a banner image and configure how it should be displayed.
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Header Photo</label>
                            <input type="file" name="header_photo" id="header_photo_input" class="form-control" accept="image/*">
                            <small class="seo-subtitle label-color d-block mb-2">
                                Dedicated banner image. If not provided, the featured image is used.
                            </small>
                        </div>
                        <div class="form-group mt-3">
                            <label>Photo Disposition (Layout)</label>
                            <select name="header_photo_layout" id="header_photo_layout" class="form-control">
                                <option value="object-cover object-center" {{ ($story->header_photo_layout ?? '') == 'object-cover object-center' ? 'selected' : '' }}>Cover Center (Default)</option>
                                <option value="object-cover object-top" {{ ($story->header_photo_layout ?? '') == 'object-cover object-top' ? 'selected' : '' }}>Cover Top</option>
                                <option value="object-cover object-bottom" {{ ($story->header_photo_layout ?? '') == 'object-cover object-bottom' ? 'selected' : '' }}>Cover Bottom</option>
                                <option value="object-contain object-center" {{ ($story->header_photo_layout ?? '') == 'object-contain object-center' ? 'selected' : '' }}>Contain</option>
                                <option value="object-fill" {{ ($story->header_photo_layout ?? '') == 'object-fill' ? 'selected' : '' }}>Fill (Stretch)</option>
                            </select>
                            <small class="seo-subtitle mb-0 label-color">
                                Controls how the image fits within the banner area.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Live Preview</label>
                        <div style="border: 1px dashed #ccc; padding: 5px; border-radius: 5px; background: #f9f9f9;">
                            <div class="relative w-full h-[190px] md:h-[250px] overflow-hidden bg-gray-200" style="height: 250px; width: 100%; position: relative; overflow: hidden; background-color: #e5e7eb;">
                                @if($story->header_photo)
                                    <img id="header_photo_preview" src="{{ asset('storage/story_image/'.$story->header_photo) }}" style="width: 100%; height: 100%;" class="{{ $story->header_photo_layout ?? 'object-cover object-center' }}">
                                    <div id="header_photo_placeholder" style="width: 100%; height: 100%; display: none; align-items: center; justify-content: center; color: #9ca3af;">
                                        No Image Selected
                                    </div>
                                @else
                                    <img id="header_photo_preview" src="" style="width: 100%; height: 100%; display: none;" class="{{ $story->header_photo_layout ?? 'object-cover object-center' }}">
                                    <div id="header_photo_placeholder" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                        No Image Selected
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


            <div class="card w3-round-large">
                 <div class="card-header seo-card-header">
                    <div class="d-flex align-items-start">
                        <div class="seo-icon-box mr-3">
                            <i class="far fa-file-alt w-4"></i>
                        </div>

                        <div class="seo-header-content">
                            <div class="d-flex align-items-center flex-wrap">
                                <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">Media & Publication</b></h4>
                                <span class="badge badge-info px-2 py-1 seo-lang">
    {{ ucfirst($langCode->language_code) }}
</span>
                            </div>
                            <small class="seo-subtitle mb-0 label-color">
                                Featured image, status, publish date, and display order — shared across all versions
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="mb-2">Featured Image</label>
                            <input type="file" name="image" class="form-control mb-2">
                            <small class="seo-subtitle label-color d-block mb-2">
                                Cover image in report listings. Recommended: 1200×630 px.
                            </small>
                            @if($story->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/story_image/'.$story->image) }}"
                                        alt="Featured Image"
                                        style="height:90px;border-radius:6px;border:1px solid #ddd;padding:3px;background:#fff;"
                                    >
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Publication Status</label>
                                <select name="status" class="form-control">
                                    <option value="draft" {{ $story->status == 'draft' ? 'selected' : '' }}>draft</option>
                                    <option value="published" {{ $story->status == 'published' ? 'selected' : '' }}>published</option>
                                </select>
                                <small class="seo-subtitle mb-0 label-color">
                                    Only Published reports are publicly visible.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Published Date:</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="text" name="published_at" class="form-control datetimepicker-input" data-target="#reservationdatetime" value="{{ old('published_at', optional($story->published_at)->format('Y-m-d')) }}"/>
                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <small class="seo-subtitle mb-0 label-color">
                                    The date this report is publicly attributed to.
                                </small>
                            </div>
                        </div>
                        <!-- 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position</label>
                                <input type="number"
                                    name="position"
                                    class="form-control"
                                    value="{{ old('position', $story->position) }}" placeholder="Enter position">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

           

            <div class="card-footer text-right  w3-round-large">
                <a href="{{ route('stories.index') }}" id="discardBtn" class="btn btn-sm mr-2 w3-round-large" style="background-color: #afb3ba;">
                    <i class="fas fa-times"></i> Discard Changes
                </a>

                <button type="button" id="previewBtn" class="btn btn-sm previewBtn w3-round-large"  style="background-color: #afb3ba;">
                    <i class="fas fa-eye"></i> Preview
                </button>

                <button type="submit" id="submitBtn" class="btn btn-sm btn-primary w3-round-large">
                    <i class="fas fa-save"></i> Save & Publishe
                </button>
            </div>
            @include('admin.story.story_preview_modal')
        </form>
    </div>





@endsection

@section('js')
@section('js')

{{-- Tempus Dominus (datepicker) --}}
<script src="{{ asset('backend-asset/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend-asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>


<script>
$(function () {

    // =========================
    // 1) Summernote Init
    // =========================
 

    // ❌ remove this if you had it আগে: $('#summernote').summernote(...)
    // কারণ তোমার DOM এ #summernote id নেই

    // =========================
    // 2) DateTime Picker Init
    // =========================
    if ($('#reservationdatetime').length) {
        $('#reservationdatetime').datetimepicker({
            format: 'YYYY-MM-DD',
            icons: { time: 'far fa-clock', date: 'far fa-calendar-alt' }
        });
    }

    // =========================
    // 3) Preview Button -> Fill Modal
    // =========================
    $('.previewBtn').on('click', function (e) {
        e.preventDefault();

        const locale = @json($locale);

        // current locale fields only
        const title = $(`input[name="title[${locale}]"]`).val() || '';
        const slug  = $(`input[name="slug[${locale}]"]`).val() || '';
        const short = $(`textarea[name="short_description[${locale}]"]`).val() || '';

        tinymce.triggerSave();
        let desc = '';
        const $descTextarea = $(`textarea[name="description[${locale}]"]`);
        if ($descTextarea.length) {
            desc = $descTextarea.val() || '';
        }

        const seoTitle = $(`input[name="seo_title[${locale}]"]`).val() || '';
        const metaDesc = $(`input[name="meta_description[${locale}]"]`).val() || '';
        const tags     = $(`input[name="tags[${locale}]"]`).val() || '';

        const status   = $('select[name="status"]').val() || '';
        const published = $('input[name="published_at"]').val() || '';

        // Fill preview modal elements (these ids must exist in modal)
        $('#pvTitle').text(title);
        $('#pvSlug').text(slug);
        $('#pvShort').text(short);
        $('#pvDesc').html(desc);

        $('#pvSeoTitle').text(seoTitle);
        $('#pvMetaDesc').text(metaDesc);
        $('#pvTags').text(tags);
        $('#pvStatus').text(status);
        $('#pvPublished').text(published);

        // Image preview (new selected file only)
        const fileInput = $('input[name="image"]')[0];
        if (fileInput && fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                $('#pvImage').attr('src', ev.target.result).show();
                $('#pvImageEmpty').hide();
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            $('#pvImage').hide();
            $('#pvImageEmpty').show();
        }

        // show modal
        $('#previewModal').modal('show');
    });

    // =========================
    // 4) Confirm Update -> Submit ONLY Update Form
    // =========================
    $('#confirmUpdate').on('click', function (e) {
        e.preventDefault();

        tinymce.triggerSave();

        // disable confirm to avoid double click
        $('#confirmUpdate').prop('disabled', true);

        // submit ONLY this form (prevents logout/locale form submission)
        const form = document.getElementById('storyUpdateForm');
        if (form) {
            form.submit();
        } else {
            // fallback: show alert if form id missing
            alert('Update form not found! Please add id="storyUpdateForm" to your form tag.');
            $('#confirmUpdate').prop('disabled', false);
        }
    });

});
</script>

<script>
    $(document).ready(function () {
        let originalUrl = $('#campaignUrlInput').val();

        $('#editUrlBtn').on('click', function () {
            originalUrl = $('#campaignUrlInput').val();
            $('#urlViewMode').hide();
            $('#urlEditMode').show();
            $('#urlError').hide().text('');
        });

        $('#cancelUrlBtn').on('click', function () {
            $('#campaignUrlInput').val(originalUrl);
            $('#urlEditMode').hide();
            $('#urlViewMode').show();
            $('#urlError').hide().text('');
        });

        $('#saveUrlBtn').on('click', function () {
            let fullUrl = $('#campaignUrlInput').val().trim();
            let saveBtn = $(this);

            $('#urlError').hide().text('');

            if (fullUrl === '') {
                $('#urlError').show().text('Page URL is required.');
                return;
            }

            saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: "{{ route('story.update.inline.url', $story->id) }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    locale: "{{ $locale }}",
                    full_url: fullUrl
                },
                success: function (response) {
                    if (response.status) {
                        $('#campaignUrlText').text(response.display_url);
                        $('#campaignUrlInput').val(response.full_url);
                        $('#slugHiddenInput').val(response.full_url);

                        originalUrl = response.full_url;

                        $('#urlEditMode').hide();
                        $('#urlViewMode').show();
                    }
                },
                error: function (xhr) {
                    let msg = 'Something went wrong.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    $('#urlError').show().text(msg);
                },
                complete: function () {
                    saveBtn.prop('disabled', false).html('<i class="far fa-save mr-1"></i> Save');
                }
            });
        });
    });

// =============== Header Photo Live Preview ===============
const headerPhotoInput = document.getElementById('header_photo_input');
const headerPhotoPreview = document.getElementById('header_photo_preview');
const headerPhotoPlaceholder = document.getElementById('header_photo_placeholder');
const headerPhotoLayout = document.getElementById('header_photo_layout');

function applyLayoutClasses() {
    if (!headerPhotoLayout || !headerPhotoPreview) return;
    
    // Reset classes
    headerPhotoPreview.className = '';
    
    // Tailwind classes corresponding to the select value
    const classes = headerPhotoLayout.value.split(' ');
    
    // Map to CSS styles directly for the admin preview to ensure it works without Tailwind being compiled for admin
    let objectFit = 'cover';
    let objectPosition = 'center';
    
    if (headerPhotoLayout.value.includes('contain')) objectFit = 'contain';
    if (headerPhotoLayout.value.includes('fill')) objectFit = 'fill';
    
    if (headerPhotoLayout.value.includes('top')) objectPosition = 'top';
    if (headerPhotoLayout.value.includes('bottom')) objectPosition = 'bottom';
    
    headerPhotoPreview.style.objectFit = objectFit;
    headerPhotoPreview.style.objectPosition = objectPosition;
    
    // Add Tailwind classes just in case
    classes.forEach(c => headerPhotoPreview.classList.add(c));
}

if (headerPhotoLayout) {
    applyLayoutClasses(); // Apply initially
}

if (headerPhotoInput && headerPhotoPreview && headerPhotoLayout) {
    headerPhotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                headerPhotoPreview.src = e.target.result;
                headerPhotoPreview.style.display = 'block';
                headerPhotoPlaceholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            @if($story->header_photo)
                headerPhotoPreview.src = "{{ asset('storage/story_image/'.$story->header_photo) }}";
            @else
                headerPhotoPreview.style.display = 'none';
                headerPhotoPlaceholder.style.display = 'flex';
            @endif
        }
    });

    headerPhotoLayout.addEventListener('change', applyLayoutClasses);
}
</script>
@endsection

