@extends('admin.layouts.master')

@section('title', 'Page Create')

@section('css')
    <style>
        .section-title{
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 10px;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .req::after{
            content:" *";
            color:#dc3545;
            font-weight:700;
        }

        .img-preview{
            width:50px;
            height:50px;
            object-fit:cover;
            border:1px solid #ddd;
            border-radius:6px;
            padding:3px;
            background:#fff;
        }

        .gallery-card{
            border-radius: 10px;
            overflow: hidden;
        }

        .gallery-thumb{
            width: 100%;
            height: 110px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .gallery-thumb-img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform .2s ease;
        }

        .gallery-card:hover .gallery-thumb-img{
            transform: scale(1.03);
        }

        .editor-shell .tox-tinymce {
            border-radius: .35rem !important;
        }

        .editor-invalid .tox-tinymce {
            border: 1px solid #dc3545 !important;
        }
    </style>
@endsection

@section('admin')
@php 
    $locale = Session::get('locale', config('app.locale'));
    $langCode = \App\Models\Language::where('language_code', $locale)->first();
@endphp

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div class="mb-3 mb-md-0">
            <h3 class="mb-2 font-weight-bold main-page-heading">
                Create Page
            </h3>

            <div class="small">
                <a href="{{ url('/dashboard') }}" class="text-primary">Dashboard</a>
                <span class="text-muted mx-1">/</span>
                <a href="{{ route('campaigns.index') }}" class="text-primary">Pages</a>
                <span class="text-muted mx-1">/</span>
                <span class="text-muted">Create</span>
            </div>
        </div>

        <div class="d-flex flex-wrap">
            <a href="{{ route('campaigns.index') }}" class="btn btn-sm btn-default mr-2 mb-2 mb-md-0 w3-round-large">
                <i class="far fa-file-alt mr-1"></i> All Pages
            </a>
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
                                class="nav-link font-weight-bold border-0 {{ $currentLocale === $language->language_code ? 'active' : 'bg-default text-muted border shadow-lg' }}"
                                style="border-radius:10px !important;">
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

<div class="container-fluid mt-3">

    @if(session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="icon fas fa-check mr-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function () { $('#success-alert').alert('close'); }, 5000);
        </script>
    @endif

    <form id="pageCreateForm" action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                            Core page text and editorial content - English version
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp

                            <div class="col-12 col-md-6">
                                <label class="label-color req">Page Title</label>
                                <input type="text"
                                    name="title[{{ $code }}]"
                                    placeholder="Enter the main title for this page"
                                    value="{{ old('title.' . $code) }}"
                                    class="form-control @error('title.' . $code) is-invalid @enderror"
                                    required>
                                <small class="form-text text-muted">The main heading displayed on this page.</small>
                                @error('title.' . $code)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="label-color">Subtitle</label>
                                <input type="text"
                                    name="sub_title[{{ $code }}]"
                                    class="form-control"
                                    placeholder="Enter a supporting subtitle"
                                    value="{{ old('sub_title.' . $code) }}">
                                <small class="form-text text-muted">Optional secondary heading shown below the main title.</small>
                                @error('sub_title.' . $code)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-12 mt-3">
                                <label class="label-color">Short description</label>
                                <textarea name="short_description[{{ $code }}]" class="form-control" placeholder="Enter a brief, 1-2 sentence summary of this page....">{{ old('short_description.' . $code) }}</textarea>
                                <small class="form-text text-muted">Displayed as a preview or teaser in campaign listings.</small>
                                @error('short_description.' . $code)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif 
                    @endforeach
                </div>

                <div class="seo-divider">
                    <span>Rich Content</span>
                </div>

                <div class="row">
                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp

                            <div class="col-12 col-md-12 mt-3">
                                <label class="label-color">Campaign Summary</label>
                                <div class="editor-shell">
                                    <textarea id="summary_{{ $code }}" name="summary[{{ $code }}]" class="form-control tinymce-editor" placeholder="Enter a campaign summary here...">{{ old('summary.' . $code) }}</textarea>
                                </div>
                                <small class="form-text text-muted">A concise overview shown in campaign cards and listing pages.</small>
                                @error('summary.' . $code)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-12 mt-3">
                                <label class="label-color">Main page Content</label>
                                <div class="editor-shell">
                                    <textarea id="standard_webpage_content_{{ $code }}" name="standard_webpage_content[{{ $code }}]" class="form-control tinymce-editor" placeholder="Enter the main page content here...">{{ old('standard_webpage_content.' . $code) }}</textarea>
                                </div>
                                <small class="form-text text-muted">The full body of the webpage rendered on the public page.</small>
                                @error('standard_webpage_content.' . $code)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-12 mt-3">
                                <label class="label-color">What is the problem?</label>
                                <div class="editor-shell">
                                    <textarea id="problem_{{ $code }}" name="problem[{{ $code }}]" class="form-control tinymce-editor" placeholder="Enter the problem description here...">{{ old('problem.' . $code) }}</textarea>
                                </div>
                                <small class="form-text text-muted">Describe the humanitarian issue this campaign addresses.</small>
                                @error('problem.' . $code)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="label-color">How will this project solve the problem?</label>
                                <div class="editor-shell">
                                    <textarea id="solution_{{ $code }}" name="solution[{{ $code }}]" class="form-control tinymce-editor" placeholder="Enter the solution description here...">{{ old('solution.' . $code) }}</textarea>
                                </div>
                                <small class="form-text text-muted">Explain your organization's approach and planned interventions.</small>
                                @error('solution.' . $code)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="label-color">Potential Long term impact</label>
                                <div class="editor-shell">
                                    <textarea id="impact_{{ $code }}" name="impact[{{ $code }}]" class="form-control tinymce-editor" placeholder="Enter the potential long-term effects here...">{{ old('impact.' . $code) }}</textarea>
                                </div>
                                <small class="form-text text-muted">Describe the expected outcomes and lasting change this campaign aims to create.</small>
                                @error('impact.' . $code)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
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
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">SEO &amp; SEARCH OPTIMIZATION</b></h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ ucfirst($langCode->language_code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            URL slugs, meta tags, and search visibility — English version
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="seo-divider">
                    <span>URL</span>
                </div>

                <div class="row">
                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                            <div class="col-md-12">
                                <label class="req">Page URL</label>
                                <div class="input-group page-url-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text page-url-prefix">sai.ngo/</span>
                                    </div>
                                    <input type="text"
                                        id="slug"
                                        name="slug[{{ $code }}]"
                                        value="{{ old('slug.' . $code) }}"
                                        class="form-control @error('slug.' . $code) is-invalid @enderror"
                                        placeholder="Project url"
                                        required>
                                </div>
                                @error('slug.' . $code)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="callout callout-info py-1 mt-3 mb-0" style="background-color: #DFF5F3;">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-file-alt text-info"></i>
                                        </div>
                                        <div class="mb-0">
                                            www.sai.ngo/campaign/example-campaign-title
                                        </div>
                                    </div>
                                </div>

                                <small class="page-url-help">
                                    Enter the full path after the domain — e.g. usa/help-venezuela. Use lowercase, hyphens only. Never change a live URL without setting up a redirect.
                                </small>
                            </div>
                        @endif 
                    @endforeach
                </div>

                <div class="seo-divider">
                    <span>META TAGS</span>
                </div>

                <div class="row">
                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                            <div class="col-md-12">
                                <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                                    <span>SEO Title</span>
                                    <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                        meta name="title"
                                    </span>
                                </label>
                                <textarea
                                    id="seo_title_{{ $code }}"
                                    name="seo_title[{{ $code }}]"
                                    class="form-control seo-title"
                                    data-code="{{ $code }}"
                                    placeholder="SEO title ">{{ old('seo_title.' . $code) }}</textarea>
                                @error('seo_title.' . $code)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                <div class="callout callout-info mt-3 mb-0 py-1" style="background-color: #F8FAFC;">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-file-alt text-info"></i>
                                        </div>
                                        <div class="mb-0">
                                            <strong>What it is:</strong>
                                            The clickable blue headline on Google search result pages. It is one of the most important on-page SEO factors. Include a key phrase and keep it between
                                            <strong>50–60 characters</strong>
                                            so it doesn't get cut off.
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2 seo-note-wrap">
                                    <small class="seo-help-text">
                                        Recommended: 50–60 characters • Appears as the clickable headline in Google.
                                    </small>
                                    <small class="seo-count-text text-green">
                                        <span id="seo_title_count_{{ $code }}"></span> / 60
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
                                        <span>Seo Description</span>
                                        <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                            meta name="Description"
                                        </span>
                                    </label>
                                    <textarea
                                        id="seo_description_{{ $code }}"
                                        name="seo_description[{{ $code }}]"
                                        class="form-control seo-description"
                                        data-code="{{ $code }}"
                                        placeholder="SEO description ">{{ old('seo_description.' . $code) }}</textarea>
                                    @error('seo_description.' . $code)
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror

                                    <div class="callout callout-info mt-3 mb-0 py-1" style="background-color: #F8FAFC;">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="fas fa-file-alt text-info"></i>
                                            </div>
                                            <div class="mb-0">
                                                <strong>What it is:</strong>
                                                The short paragraph shown beneath the SEO Title in Google results. It doesn't directly affect ranking but strongly influences click-through rate. Aim for
                                                <strong class="text-dark">120–160 characters</strong>.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Recommended: 120–160 characters · Shown as the grey snippet text in Google.
                                        </small>

                                        <small class="font-weight-bold text-warning mb-0">
                                            <span id="seo_description_count_{{ $code }}"></span> / 160
                                        </small>
                                    </div>
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
                                        <span>Seo Keyword</span>
                                        <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                            meta name="keywords"
                                        </span>
                                    </label>
                                    <textarea name="meta_keyword[{{ $code }}]" rows="2" class="form-control" placeholder="Enter seo keyword">{{ old('meta_keyword.' . $code) }}</textarea>

                                    <div class="callout callout-info mt-3 mb-0 py-1" style="background-color: #F8FAFC;">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="fas fa-file-alt text-info"></i>
                                            </div>
                                            <div class="mb-0">
                                                <strong>What it is:</strong>
                                                A comma-separated list of relevant keywords. Google no longer uses this as a ranking signal, but some internal search tools and SEO auditing platforms still read it.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Separate keywords with commas.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif 
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-color">Google Description</label>
                                    <textarea name="google_description[{{ $code }}]" class="form-control" placeholder="Google Description ">{{ old('google_description.' . $code) }}</textarea>

                                    <div class="callout callout-info mt-3 mb-0 py-1" style="background-color: #F8FAFC;">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="fas fa-file-alt text-info"></i>
                                            </div>
                                            <div class="mb-0">
                                                <strong>What it is:</strong>
                                                Specifically targeted at Google's crawler for rich results, Knowledge Graph entries, and featured snippets. Can use slightly different language than the standard SEO Description. Keep it between <strong class="text-dark">120–160 characters</strong>.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Used by Google's crawler for rich results. Can differ from the standard SEO Description.
                                        </small>
                                    </div>
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
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">PAGE SETTINGS & VISIBILITY</b></h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ ucfirst($langCode->language_code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Layout type, publication status, and navigation display options
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="label-color">Page Layout Type</label>
                        <select name="type" class="form-control" required>
                            <option value="">Select Page Layout Type</option>
                            <option value="awards" {{ old('type')=='awards' ? 'selected' : '' }}>awards</option>
                            <option value="campaign" {{ old('type')=='campaign' ? 'selected' : '' }}>campaign</option>
                            <option value="default" {{ old('type')=='default' ? 'selected' : '' }}>default</option>
                            <option value="donate" {{ old('type')=='donate' ? 'selected' : '' }}>donate</option>
                            <option value="homepage" {{ old('type')=='homepage' ? 'selected' : '' }}>homepage</option>
                            <option value="sidebar-right" {{ old('type')=='sidebar-right' ? 'selected' : '' }}>sidebar-right</option>
                        </select>
                        <small class="seo-subtitle mb-0 label-color">
                            Controls the overall layout template used to render this page.
                        </small>
                    </div>

                    <div class="col-md-4">
                        <label class="label-color">Publication Status</label>
                        <select name="status" class="form-control">
                            <option value="draft" {{ old('status','draft')=='draft' ? 'selected' : '' }}>DRAFT</option>
                            <option value="published" {{ old('status')=='published' ? 'selected' : '' }}>PUBLISHED</option>
                            <option value="archived" {{ old('status')=='archived' ? 'selected' : '' }}>ARCHIVED</option>
                        </select>
                        <small class="seo-subtitle mb-0 label-color">
                            Only Published pages are visible to the public.
                        </small>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="label-color">Display on Homepage</label>
                            <select name="show_home_page" class="form-control" required>
                                <option value="" disabled>Select show page status</option>
                                <option value="active" {{ old('show_home_page')=='active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('show_home_page')=='inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <small class="seo-subtitle mb-0 label-color">
                                Show this page's card on the public homepage.
                            </small>
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="label-color">Homepage Display Order</label>
                            <input type="number" name="home_order" class="form-control" value="{{ old('home_order') }}" placeholder="Enter position number">
                            <small class="seo-subtitle mb-0 label-color">
                                Lower numbers appear first.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="label-color">Display in Navigation Bar</label>
                            <select name="show_on_navbar" class="form-control">
                                <option value="">Select</option>
                                <option value="1" {{ old('show_on_navbar') === '1' ? 'selected' : '' }}>Show</option>
                                <option value="0" {{ old('show_on_navbar') === '0' ? 'selected' : '' }}>Not show</option>
                            </select>
                            <small class="seo-subtitle mb-0 label-color">
                                Whether this page appears as a link in the site's top
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="label-color">Navigation Bar Position</label>
                            <input type="number"
                                name="position"
                                class="form-control"
                                value="{{ old('position') }}"
                                placeholder="Enter position number">
                            <small class="seo-subtitle mb-0 label-color">
                                Left-to-right order in the nav bar. Lower = further left.
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
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">Embedded Media</b></h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ ucfirst($langCode->language_code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Video and donation widget embed codes - English version
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
                                    <label class="label-color">Video</label>
                                    <textarea name="video[{{ $code }}]" rows="4" class="form-control" placeholder="https://youtube.com/embed/...">{{ old('video.' . $code) }}</textarea>
                                    <small class="form-text text-muted">Paste a YouTube or Vimeo embed URL.</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-color">Donorbox code</label>
                                    <textarea name="donorbox_code[{{ $code }}]" rows="4" class="form-control" placeholder="donorbox code iframe code">{{ old('donorbox_code.' . $code) }}</textarea>
                                    <small class="form-text text-muted">Paste the Donorbox embed snippet. Leave blank to hide the widget.</small>
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
                                Dedicated banner image. If not provided, the featured/hero image is used.
                            </small>
                        </div>
                        <div class="form-group mt-3">
                            <label>Photo Disposition (Layout)</label>
                            <select name="header_photo_layout" id="header_photo_layout" class="form-control">
                                <option value="object-cover object-center">Cover Center (Default)</option>
                                <option value="object-cover object-top">Cover Top</option>
                                <option value="object-cover object-bottom">Cover Bottom</option>
                                <option value="object-contain object-center">Contain</option>
                                <option value="object-fill">Fill (Stretch)</option>
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
                                <img id="header_photo_preview" src="" style="width: 100%; height: 100%; display: none;" class="object-cover object-center">
                                <div id="header_photo_placeholder" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                    No Image Selected
                                </div>
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
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">Media and Assets</b></h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ ucfirst($langCode->language_code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Hero image and gallery - shared across all language versions
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-color">Hero Image</label>
                            <input type="file" name="hero_image" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Recommended: 1440×600px. Displayed as the full-width banner at the top of the page.</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-color">Gallery Images (800x600px) images recommended</label>
                            <input type="file" name="gallery_image[]" class="form-control" multiple accept="image/*">
                            <small class="form-text text-muted">Select multiple images at once. Supports JPG, PNG, and WebP.</small>
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
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">Footer Content</b></h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ ucfirst($langCode->language_code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Layout type, publication status, and navigation display options
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
                                    <label class="label-color">Footer Heading</label>
                                    <input type="text" name="footer_title[{{ $code }}]" class="form-control" value="{{ old('footer_title.' . $code) }}">
                                    <small class="seo-subtitle mb-0 label-color">
                                        Large text at the top of the footer strip.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-color">Footer sub Heading</label>
                                    <input type="text" name="footer_subtitle[{{ $code }}]" class="form-control" value="{{ old('footer_subtitle.' . $code) }}">
                                    <small class="seo-subtitle mb-0 label-color">
                                        Supporting text below the footer heading. Use ‹ br› for line breaks.
                                    </small>
                                </div>
                            </div>
                        @endif 
                    @endforeach

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-color">Footer button link</label>
                            <input type="text" name="footer_button_link" class="form-control" value="{{ old('footer_button_link') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-color">Card footer color</label>
                            <div class="input-group my-colorpicker2">
                                <input type="text"
                                    name="bg_color"
                                    class="form-control"
                                    value="{{ old('bg_color') }}"
                                    placeholder="#000000">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                </div>
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
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">ANNOUNCEMENT SLOGANS</b></h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ ucfirst($langCode->language_code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Scrolling banner messages shown across the top of the page
                        </small>
                    </div>
                </div>
            </div> 

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:30%">Slogan Text</th>
                            <th style="width:30%">Text Color</th>
                            <th style="width:30%">Background Color</th>
                            <th style="width:10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="dynamicTableBody">
                        <tr class="dynamic-tr">
                            <td>
                                <input type="hidden" name="slogan_id[]" value="">
                                <input type="text" name="slogan_title[]" class="form-control" placeholder="Enter title">
                            </td>
                            <td>
                                <div class="input-group slogan-text-colorpicker">
                                    <input type="text" name="slogan_text_color[]" class="form-control" placeholder="#000000">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-square" style="color:#000000"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="input-group slogan-bg-colorpicker">
                                    <input type="text" name="slogan_bg_color[]" class="form-control" placeholder="#ffffff">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-square" style="color:#ffffff"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm addRow">+</button>
                                <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <small class="seo-subtitle mb-0 label-color">
                    Add multiple slogans. They rotate in the announcement banner at the top of the page.
                </small>
            </div>
        </div>

        <div class="card-footer text-right w3-round-large">
            <a href="{{ route('campaigns.index') }}" id="discardBtn" class="btn btn-sm mr-2 w3-round-large" style="background-color: #afb3ba;">
                <i class="fas fa-times"></i> Discard Changes
            </a>
            <button type="button" id="previewBtn" class="btn btn-sm previewBtn mr-2 w3-round-large" style="background-color: #afb3ba;">
                <i class="fas fa-eye"></i> Preview
            </button>
            <button type="submit" id="realSubmitBtn" class="btn btn-sm btn-primary w3-round-large">
                <i class="fas fa-save"></i> Save & Publish
            </button>
        </div>

        @include('admin.canpaign.preview')
    </form>
</div>

@endsection

@section('js')
<script src="{{ asset('backend-asset/plugins/tinymce/tinymce.min.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".seo-title").forEach(function (textarea) {
        let code = textarea.getAttribute("data-code");
        let counter = document.getElementById("seo_title_count_" + code);

        function updateCount() {
            let length = textarea.value.length;
            counter.innerText = length;

            counter.classList.remove('text-success','text-warning','text-danger');

            if(length > 60){
                counter.classList.add('text-danger');
            }else if(length >= 50){
                counter.classList.add('text-success');
            }else{
                counter.classList.add('text-warning');
            }
        }

        textarea.addEventListener("input", updateCount);
        updateCount();
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".seo-description").forEach(function (textarea) {
        let code = textarea.getAttribute("data-code");
        let counter = document.getElementById("seo_description_count_" + code);

        function updateCount() {
            let length = textarea.value.length;
            counter.innerText = length;

            counter.classList.remove('text-success','text-warning','text-danger');

            if (length >= 120 && length <= 160) {
                counter.classList.add('text-success');
            } else if ((length >= 100 && length < 120) || (length > 160 && length <= 180)) {
                counter.classList.add('text-warning');
            } else {
                counter.classList.add('text-danger');
            }
        }

        textarea.addEventListener("input", updateCount);
        updateCount();
    });
});
</script>

<script>
$(function () {

    function initTinyMce() {
        if (typeof tinymce === 'undefined') {
            console.error('TinyMCE not loaded.');
            return;
        }

        tinymce.init({
            selector: '.tinymce-editor',
            license_key: 'gpl',
            height: 320,
            menubar: true,
            branding: false,
            promotion: false,
            convert_urls: false,
            relative_urls: false,
            remove_script_host: false,
            plugins: 'preview searchreplace autolink autosave directionality visualblocks visualchars fullscreen image link media table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help code emoticons',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | blockquote code preview fullscreen | removeformat',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            setup: function (editor) {
                editor.on('change keyup setcontent', function () {
                    editor.save();
                });
            }
        });
    }

    function syncTinyMce() {
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
    }

    function getEditorContent(name) {
        const textarea = document.querySelector(`textarea[name="${name}"]`);
        if (!textarea) return '';

        if (typeof tinymce !== 'undefined') {
            const editor = tinymce.get(textarea.id);
            if (editor) {
                return editor.getContent() || '';
            }
        }

        return $(textarea).val() || '';
    }

    initTinyMce();

    const locale = @json($locale);

    $('.previewBtn').on('click', function (e) {
        e.preventDefault();
        syncTinyMce();

        const title     = $(`input[name="title[${locale}]"]`).val() || '';
        const subTitle  = $(`input[name="sub_title[${locale}]"]`).val() || '';
        const slug      = $(`input[name="slug[${locale}]"]`).val() || '';

        const summary   = getEditorContent(`summary[${locale}]`);
        const standard  = getEditorContent(`standard_webpage_content[${locale}]`);
        const problem   = getEditorContent(`problem[${locale}]`);
        const solution  = getEditorContent(`solution[${locale}]`);
        const impact    = getEditorContent(`impact[${locale}]`);

        const googleDesc = $(`textarea[name="google_description[${locale}]"]`).val() || '';
        const shortDesc  = $(`textarea[name="short_description[${locale}]"]`).val() || '';

        const seoTitle = $(`textarea[name="seo_title[${locale}]"]`).val() || '';
        const seoDesc  = $(`textarea[name="seo_description[${locale}]"]`).val() || '';

        const type = $('select[name="type"]').val() || '';
        const showHome = $('select[name="show_home_page"]').val() || '';
        const status = $('select[name="status"]').val() || '';
        const position = $('input[name="position"]').val() || '';
        const showNavbar = $('select[name="show_on_navbar"]').val() || '';
        const bgColor = $('input[name="bg_color"]').val() || '';

        $('#pvTitle').text(title);
        $('#pvSubTitle').text(subTitle);
        $('#pvSlug').text(slug);

        $('#pvSummary').html(summary);
        $('#pvStandard').html(standard);
        $('#pvProblem').html(problem);
        $('#pvSolution').html(solution);
        $('#pvImpact').html(impact);

        $('#pvGoogleDesc').text(googleDesc);
        $('#pvShortDesc').text(shortDesc);

        $('#pvSeoTitle').text(seoTitle);
        $('#pvSeoDesc').text(seoDesc);

        $('#pvType').text(type);
        $('#pvShowHome').text(showHome);
        $('#pvStatus').text(status);
        $('#pvPosition').text(position);
        $('#pvNavbar').text(showNavbar);
        $('#pvBgColor').text(bgColor);

        const heroInput = $('input[name="hero_image"]')[0];
        if (heroInput && heroInput.files && heroInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function (ev) {
                $('#pvHeroImg').attr('src', ev.target.result).show();
                $('#pvHeroImgEmpty').hide();
            };
            reader.readAsDataURL(heroInput.files[0]);
        } else {
            $('#pvHeroImg').hide();
            $('#pvHeroImgEmpty').show();
        }

        $('#previewModal').modal('show');
    });

    $('#confirmSave').on('click', function (e) {
        e.preventDefault();
        syncTinyMce();
        $('#confirmSave').prop('disabled', true);
        document.getElementById('pageCreateForm').submit();
    });

    $('#pageCreateForm').on('submit', function () {
        syncTinyMce();
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.getElementById('dynamicTableBody');

    function initPickers(scope = document) {
        $(scope).find('.slogan-text-colorpicker').colorpicker();
        $(scope).find('.slogan-bg-colorpicker').colorpicker();

        $(scope).find('.slogan-text-colorpicker').off('colorpickerChange').on('colorpickerChange', function (event) {
            $(this).find('.fa-square').css('color', event.color.toString());
        });

        $(scope).find('.slogan-bg-colorpicker').off('colorpickerChange').on('colorpickerChange', function (event) {
            $(this).find('.fa-square').css('color', event.color.toString());
        });
    }

    $(function () {
        initPickers(document);
    });

    const makeRow = () => {
        const tr = document.createElement('tr');
        tr.className = 'dynamic-tr';
        tr.innerHTML = `
          <td>
            <input type="hidden" name="slogan_id[]" value="">
            <input type="text" name="slogan_title[]" class="form-control" placeholder="Enter title">
          </td>

          <td>
            <div class="input-group slogan-text-colorpicker">
              <input type="text" name="slogan_text_color[]" class="form-control" placeholder="#000000">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fas fa-square" style="color:#000000"></i>
                </span>
              </div>
            </div>
          </td>

          <td>
            <div class="input-group slogan-bg-colorpicker">
              <input type="text" name="slogan_bg_color[]" class="form-control" placeholder="#ffffff">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fas fa-square" style="color:#ffffff"></i>
                </span>
              </div>
            </div>
          </td>

          <td class="text-center">
            <button type="button" class="btn btn-success btn-sm addRow">+</button>
            <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
          </td>
        `;
        return tr;
    };

    tbody.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;

        if (btn.classList.contains('addRow')) {
            const row = makeRow();
            tbody.appendChild(row);
            initPickers(row);
        }

        if (btn.classList.contains('removeRow')) {
            const rows = tbody.querySelectorAll('.dynamic-tr');
            if (rows.length > 1) {
                btn.closest('.dynamic-tr').remove();
            } else {
                const r = btn.closest('.dynamic-tr');
                r.querySelector('input[name="slogan_id[]"]').value = '';
                r.querySelector('input[name="slogan_title[]"]').value = '';
                r.querySelector('input[name="slogan_text_color[]"]').value = '';
                r.querySelector('input[name="slogan_bg_color[]"]').value = '';
                r.querySelector('.slogan-text-colorpicker .fa-square').style.color = '#000000';
                r.querySelector('.slogan-bg-colorpicker .fa-square').style.color = '#ffffff';
            }
        }
    });
});
</script>

<script>
$(function () {
    $('.my-colorpicker2').colorpicker();

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $(this).find('.fa-square').css('color', event.color.toString());
    });
});

// =============== Header Photo Live Preview ===============
const headerPhotoInput = document.getElementById('header_photo_input');
const headerPhotoPreview = document.getElementById('header_photo_preview');
const headerPhotoPlaceholder = document.getElementById('header_photo_placeholder');
const headerPhotoLayout = document.getElementById('header_photo_layout');

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
            headerPhotoPreview.style.display = 'none';
            headerPhotoPlaceholder.style.display = 'flex';
        }
    });

    headerPhotoLayout.addEventListener('change', function(e) {
        headerPhotoPreview.className = '';
        const classes = e.target.value.split(' ');
        
        let objectFit = 'cover';
        let objectPosition = 'center';
        
        if (e.target.value.includes('contain')) objectFit = 'contain';
        if (e.target.value.includes('fill')) objectFit = 'fill';
        
        if (e.target.value.includes('top')) objectPosition = 'top';
        if (e.target.value.includes('bottom')) objectPosition = 'bottom';
        
        headerPhotoPreview.style.objectFit = objectFit;
        headerPhotoPreview.style.objectPosition = objectPosition;
        
        classes.forEach(c => headerPhotoPreview.classList.add(c));
    });
}
</script>
@endsection