@extends('admin.layouts.master')

@section('title', 'Page Edit')

@section('css')
    <style>
        .section-title{
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 10px;
            margin-bottom: 6px;
            font-size: 13px;
        }
        .req::after{ content:" *"; color:#dc3545; font-weight:700; }
        .img-preview{
            width:50px;height:50px;
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
    $currentPath = old('path.' . $locale, $campaign->getDirectValue('path', $locale));
    $currentSlug = old('slug.' . $locale, $campaign->getDirectValue('slug', $locale));
    $currentFullUrl = trim(($currentPath ? $currentPath . '/' : '') . $currentSlug, '/');

    $path = $locale === 'es'
            ? ($campaign->getTranslation('path', 'es', false) ?: $campaign->getTranslation('path', 'en', false))
            : ($campaign->getTranslation('path', 'en', false) ?: $campaign->getTranslation('path', 'es', false));

    $slug = $locale === 'es'
            ? ($campaign->getTranslation('slug', 'es', false) ?: $campaign->getTranslation('slug', 'en', false))
            : ($campaign->getTranslation('slug', 'en', false) ?: $campaign->getTranslation('slug', 'es', false));
@endphp

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div class="mb-3 mb-md-0">
            <h3 class="mb-2 font-weight-bold main-page-heading">
                Edit Page —
                <a href="javascript:void(0)" class="text-primary">{{ $campaign->title }}</a>
            </h3>

            <div class="small">
                <a href="{{ url('/dashboard') }}" class="text-primary">Dashboard</a>
                <span class="text-muted mx-1">/</span>
                <a href="{{ route('campaigns.index') }}" class="text-primary">Pages</a>
                <span class="text-muted mx-1">/</span>
                <span class="text-muted">Edit — {{ $campaign->title }}</span>
            </div>
        </div>

        <div class="d-flex flex-wrap">
            <a href="{{ route('campaigns.index') }}" class="btn btn-sm btn-default mr-2 mb-2 mb-md-0 w3-round-large">
                <i class="far fa-file-alt mr-1"></i> All Pages
            </a>

            @if($path && $slug)
            <a href="{{ $locale === 'es'
                        ? route('campaignsdetailsEsDyn', ['path' => $path, 'slug' => $slug])
                        : route('campaignsdetailsDyn', ['path' => $path, 'slug' => $slug]) }}" class="btn btn-sm btn-dark mb-2 mb-md-0 w3-round-large" target="_blank">
                <i class="far fa-eye mr-1"></i> Live Preview
            </a>
            @endif
        </div>
    </div>

    <div class="form-group">
        <input type="hidden"
            id="slugHiddenInput"
            name="slug[{{ $locale }}]"
            value="{{ $currentFullUrl }}">

        <div class="alert mb-0 py-2 px-3 w3-round-large"
            id="campaignUrlBox"
            style="background-color: #DFF5F3;">

            <div class="d-flex align-items-center flex-wrap" style="gap:10px;">

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

<div class="container-fluid mt-3">

    @if(session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show">
            <i class="icon fas fa-check mr-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        <script>
            setTimeout(() => $('#success-alert').alert('close'), 5000);
        </script>
    @endif

    <form id="pageCreateForm"  action="{{ route('campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
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
                        <div class="col-sm-12 col-md-6 mb-3 c">
                            <label class="label-color">Page Title  </label>
                            <input type="text" id="title" name="title[{{ $code }}]"
                                value="{{ old('title.' . $code, $campaign->getDirectValue('title', $code)) }}"
                                class="form-control @error('title') is-invalid @enderror" placeholder="Enter the main title for this page" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted">The main heading displayed on this page.</small>
                        </div>
                        @endif
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                        <div class="col-sm-12 col-md-6 mb-3 c">
                            <label class="label-color">Subtitle  </label>
                            <input type="text" name="sub_title[{{ $code }}]" class="form-control" placeholder="Enter a supporting subtitle" value="{{ old('sub_title.' . $code, $campaign->getDirectValue('sub_title', $code)) }}">
                            @error('sub_title') <div class="text-danger small">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">Optional secondary heading shown below the main title.</small>
                        </div>
                        @endif 
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                        <div class="col-sm-12 col-md-12 mb-3 c">
                            <label class="label-color">Short description  </label>
                            <textarea name="short_description[{{ $code }}]" class="form-control" placeholder="Enter a brief, 1-2 sentence summary of this page....">{{ old('short_description.' . $code, $campaign->getDirectValue('short_description', $code)) }}</textarea>
                            <small class="form-text text-muted">Displayed as a preview or teaser in campaign listings.</small>
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
                        <div class="col-sm-12 col-md-12 mb-3 c">
                            <label class="label-color">Campaign Summary  </label>
                            <div class="editor-shell">
                                <textarea id="summary_{{ $code }}" name="summary[{{ $code }}]" class="form-control tinymce-editor" placeholder="Enter a campaign summary here...">{{ old('summary.' . $code, $campaign->getDirectValue('summary', $code)) }}</textarea>
                            </div>
                            <small class="form-text text-muted">A concise overview shown in campaign cards and listing pages.</small>
                        </div>
                        @endif 
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                        <div class="col-sm-12 col-md-12 mb-3 c">
                            <label class="label-color">Main Page Content  </label>
                            <div class="editor-shell">
                                <textarea id="standard_webpage_content_{{ $code }}" name="standard_webpage_content[{{ $code }}]"
                                        class="form-control tinymce-editor" placeholder="Enter the main page content here...">{{ old('standard_webpage_content.' . $code, $campaign->getDirectValue('standard_webpage_content', $code)) }}</textarea>
                            </div>
                            <small class="form-text text-muted">The full body of the webpage rendered on the public page.</small>
                        </div>
                        @endif 
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                        @php $code = $language->language_code; @endphp
                        <div class="col-sm-12 col-md-12 mb-3 c">
                            <label class="label-color">What is the problem?  </label>
                            <div class="editor-shell">
                                <textarea id="problem_{{ $code }}" name="problem[{{ $code }}]"
                                        class="form-control tinymce-editor" placeholder="Enter the problem description here...">{{ old('problem.' . $code, $campaign->getDirectValue('problem', $code)) }}</textarea>
                            </div>
                            <small class="form-text text-muted">Describe the humanitarian issue this campaign addresses.</small>
                        </div>
                        @endif 
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                        <div class="col-sm-12 col-md-12 mb-3 c">
                            <label class="label-color">How will this project solve the problem?  </label>
                            <div class="editor-shell">
                                <textarea id="solution_{{ $code }}" name="solution[{{ $code }}]"
                                        class="form-control tinymce-editor" placeholder="Enter the solution description here...">{{ old('solution.' . $code, $campaign->getDirectValue('solution', $code)) }}</textarea>
                            </div>
                            <small class="form-text text-muted">Explain your organization's approach and planned interventions.</small>
                        </div>
                        @endif 
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                        <div class="col-sm-12 col-md-12 mb-3 c">
                            <label class="label-color">Potential Long term impact  </label>
                            <div class="editor-shell">
                                <textarea id="impact_{{ $code }}" name="impact[{{ $code }}]"
                                        class="form-control tinymce-editor" placeholder="Enter the potential long-term effects here...">{{ old('impact.' . $code, $campaign->getDirectValue('impact', $code)) }}</textarea>
                            </div>
                            <small class="form-text text-muted">Describe the expected outcomes and lasting change this campaign aims to create.</small>
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
                                <div class="form-group">
                                    <label class="label-color req">
                                        Page URL <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group page-url-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text page-url-prefix">sai.ngo/</span>
                                        </div>

                                        <input type="text"
                                            id="slug"
                                            name="slug[{{ $code }}]"
                                            value="{{ old('path.' . $code, $campaign->getDirectValue('path', $code)) }}/{{ old('slug.' . $code, $campaign->getDirectValue('slug', $code)) }}"
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
                                                sai.ngo/{{ $campaign->path }}/{{ $campaign->slug }}
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
                </div>

                <div class="seo-divider">
                    <span>META TAGS</span>
                </div>
                <div class="row">
                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                            <div class="col-md-12">
                                <div class="form-group seo-title-group">
                                    <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                                        <span> SEO Title</span>
                                        <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                            meta name="title"
                                        </span>
                                    </label>

                                    <textarea
                                        name="seo_title[{{ $code }}]"
                                        id="seo_title_{{ $code }}"
                                        class="form-control seo-title-input @error('seo_title') is-invalid @enderror"
                                        placeholder="SEO Title "
                                        rows="4"
                                    >{{ old('seo_title.' . $code, $campaign->getDirectValue('seo_title', $code)) }}</textarea>

                                    @error('seo_title')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror

                                    <div class="callout callout-info- mt-3 mb-0 py-1" style="background-color: #F8FAFC;">
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

                                    <div class="d-flex justify-content-between align-items-center mt-2 mt-2 seo-note-wrap">
                                        <small class="seo-help-text">
                                            Recommended: 50–60 characters • Appears as the clickable headline in Google.
                                        </small>
                                        <small class="seo-count-text">
                                            <span id="seo_title_count_{{ $code }}">
                                                {{ mb_strlen(old('seo_title.' . $code, $campaign->getDirectValue('seo_title', $code)) ?? '') }}
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
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                                        <span>SEO Description</span>
                                        <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                            meta name="description"
                                        </span>
                                    </label>

                                    <textarea id="seo_description_{{ $code }}"
                                            name="seo_description[{{ $code }}]"
                                            class="form-control rounded-sm @error('seo_description') is-invalid @enderror"
                                            placeholder="SEO Description "
                                            rows="4"
                                        >{{ old('seo_description.' . $code, $campaign->getDirectValue('seo_description', $code)) }}</textarea>

                                    @error('seo_description')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror

                                    <div class="callout callout-info- mt-3 mb-0 py-1" style="background-color: #F8FAFC;">
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

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted">
                                            Recommended: 120–160 characters · Shown as the grey snippet text in Google.
                                        </small>

                                        <small class="font-weight-bold text-warning mb-0">
                                            <span id="seo_description_count_{{ $code }}">
                                                {{ mb_strlen(old('seo_description.' . $code, $campaign->getDirectValue('seo_description', $code)) ?? '') }}
                                            </span> / 160
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
                                <span>Seo Keyword </span>
                                <span class="badge badge-light border text-danger- ml-2 px-2 py-1">
                                    meta name="keywords"
                                </span>
                            </label>
                            <textarea name="meta_keyword[{{ $code }}]" rows="2" class="form-control" placeholder="Enter seo keyword">{{ old('meta_keyword.' . $code, $campaign->getDirectValue('meta_keyword', $code)) }}</textarea>
                                <div class="callout callout-info- mt-3 mb-0 py-1" style="background-color: #F8FAFC;">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-file-alt text-info"></i>
                                        </div>
                                        <div class="mb-0">
                                            <strong>What it is:</strong>
                                            What it is: A comma-separated list of relevant keywords. Google no longer uses this as a ranking signal, but some internal search tools and SEO auditing
                                            platforms still read it.
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
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
                                <label class="label-color">Google Meta Description  </label>
                                <textarea name="google_description[{{ $code }}]"
                                        class="form-control">{{ old('google_description.' . $code, $campaign->getDirectValue('google_description', $code)) }}</textarea>
                                <div class="callout callout-info- mt-3 mb-0 py-1" style="background-color: #F8FAFC;">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-file-alt text-info"></i>
                                        </div>
                                        <div class="mb-0">
                                            <strong>What it is:</strong>
                                            What it is: Specifically targeted at Google's crawler for rich results, Knowledge Graph entries, and featured snippets. Can use slightly different language than the
                                            standard SEO Description. Keep it between <strong class="text-dark">120–160 characters</strong>.
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
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
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title"> Embedded Media</b></h4>
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
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="label-color">Video  </label>
                                <textarea name="video[{{ $code }}]" rows="4" class="form-control" placeholder="https://youtube.com/embed/…">{{ old('video.' . $code, $campaign->getDirectValue('video', $code)) }}</textarea>
                                    <small class="form-text text-muted">Paste a YouTube or Vimeo embed URL.</small>
                            </div>
                        </div>
                        @endif 
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $code = $language->language_code; @endphp
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="label-color">Donorbox Code </label>
                                <textarea name="donorbox_code[{{ $code }}]" rows="4"  class="form-control" placeholder="‹dbox-widget campaign='...'></dbox-widget ›">{{ old('donorbox_code.' . $code, $campaign->getDirectValue('donorbox_code', $code)) }}</textarea>
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
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="label-color">Hero Image  </label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="file" name="hero_image" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <img src="{{ asset('storage/hero_image/'.$campaign->hero_image) }}"
                                    class="img-preview">
                        <small class="form-text text-muted">Recommended: 1440×600px. Displayed as the full-width banner at the top of the page.</small> 
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-11">
                                    <label class="label-color">Gallery Images <small class="text-muted">(800×600px recommended)</small></label>
                                </div>
                                <div class="col-1 p-0 text-end">
                                    <a href="{{ route('campaign.gallery.edit', $campaign->id) }}" class="btn btn-outline-secondary btn-sm mr-5" id="view-gallery-btn" style="width: 100%">Edit Gallery</a>
                                </div>
                            </div>
                            <input type="file" name="gallery_image[]" class="form-control" multiple accept="image/*">
                            <small class="form-text text-muted">Select multiple images at once. Supports JPG, PNG, and WebP.</small>
                            @if($campaign->galleryImages?->count())
                                <div class="row mt-3 g-2">
                                    @foreach($campaign->galleryImages as $img)
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4" id="image-{{ $img->id }}">
                                            <div class="card card-outline card-secondary gallery-card h-100 position-relative">  
                                                <div class="gallery-thumb">
                                                    <img src="{{ asset('storage/gallery_image/'.$img->image) }}" class="gallery-thumb-img" alt="Gallery Image">
                                                </div>

                                                <div class="card-footer text-center py-1">
                                                    <small class="text-muted">{{ $img->title }}</small>
                                                </div>

                                                <button type="button"
                                                    class="btn btn-danger btn-xs delete-image position-absolute"
                                                    style="top: 8px; right: 8px;"
                                                    data-id="{{ $img->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
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
                        <div class="form-group">
                            <label class="label-color">Page Layout Type  </label>
                            <select name="type" class="form-control" required>
                                @foreach(['awards','campaign','default','donate','homepage','sidebar-right'] as $type)
                                    <option value="{{ $type }}" {{ old('type',$campaign->type)==$type?'selected':'' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="seo-subtitle mb-0 label-color">
                                Controls the overall layout template used to render this page.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="label-color">Publication Status </label>
                            <select name="status" class="form-control">
                                @foreach(['draft','published','archived'] as $status)
                                    <option value="{{ $status }}" {{ old('status',$campaign->status)==$status?'selected':'' }}>
                                        {{ strtoupper($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="seo-subtitle mb-0 label-color">
                                Only Published pages are visible to the public.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="label-color">Display on Homepage  </label>
                            <select name="show_home_page" class="form-control" required>
                                <option value="" disabled>Selece show home page</option>
                                <option value="active" {{ old('show_home_page',$campaign->show_home_page)== 'active' ?' selected':'' }}>Active - Hidden from Homepage</option>
                                <option value="inactive" {{ old('show_home_page',$campaign->show_home_page)== 'inactive' ? 'selected':'' }}>Inactive - Hidden from Homepage</option>
                            </select>
                            <small class="seo-subtitle mb-0 label-color">
                                Show this page's card on the public homepage.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="label-color">Homepage Display Order</label> 
                            <input type="number" name="home_order" class="form-control" value="{{ old('home_order', $campaign->home_order ?? '') }}"  placeholder="e.g. 1, 2, 3...">
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
                                <option value="1" {{ old('show_on_navbar', (string)($campaign->show_on_navbar ?? '')) === '1' ? 'selected' : '' }}>Visiable</option>
                                <option value="0" {{ old('show_on_navbar', (string)($campaign->show_on_navbar ?? '')) === '0' ? 'selected' : '' }}>Hidden</option>
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
                                value="{{ old('position', $campaign->position ?? '') }}"
                                placeholder="e.g. 1, 2, 3...">
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
                                <label class="label-color">Footer Heading  </label>
                                <input type="text" name="footer_title[{{ $code }}]" class="form-control" value="{{ old('footer_title.' . $code, $campaign->getDirectValue('footer_title', $code)) }}">
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
                                <label class="label-color">Footer sub Heading  </label>
                                <input type="text" name="footer_subtitle[{{ $code }}]" class="form-control" value="{{ old('footer_subtitle.' . $code, $campaign->getDirectValue('footer_subtitle', $code)) }}">
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
                        <input type="text" name="footer_button_link" class="form-control" value="{{ old('footer_button_link', $campaign->footer_button_link ?? '') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label-color">Card footer color</label>
                        <div class="input-group footer-colorpicker">
                            <input type="text"
                                name="bg_color"
                                class="form-control"
                                value="{{ old('bg_color', $campaign->bg_color ?? '') }}"
                                placeholder="#000000">

                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-square"
                                    style="color: {{ old('bg_color', $campaign->bg_color ?? '#000000') }}"></i>
                                </span>
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
                            <h4 class="card-title mb-0 mr-2"><b class="header-title">ANNOUNCEMENT SLOGANS</b></h4>
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
                            <th style="width:30%" class="table-label">Slogan Text</th>
                            <th style="width:30%" class="table-label">Text Color</th>
                            <th style="width:30%" class="table-label">Background Color</th>
                            <th style="width:10%" class="table-label">Action</th>
                        </tr>
                    </thead>

                    <tbody id="dynamicTableBody">
                        @php
                            $oldIds = old('slogan_id', []);
                            $oldTitles = old('slogan_title', []);
                            $oldTextColors = old('slogan_text_color', []);
                            $oldBgColors = old('slogan_bg_color', []);
                        @endphp

                        @if(count($oldTitles))
                            @foreach($oldTitles as $i => $t)
                                <tr class="dynamic-tr">
                                    <td>
                                        <input type="hidden" name="slogan_id[]" value="{{ $oldIds[$i] ?? '' }}">
                                        <input type="text" name="slogan_title[]" class="form-control"
                                            value="{{ $t }}" placeholder="Enter title">
                                    </td>
                                    <td>
                                        <div class="input-group slogan-text-colorpicker">
                                            <input type="text"
                                                name="slogan_text_color[]"
                                                class="form-control"
                                                value="{{ $oldTextColors[$i] ?? '' }}"
                                                placeholder="#000000">
                                            <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-square"
                                                style="color: {{ $oldTextColors[$i] ?? '#000000' }}"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group slogan-bg-colorpicker">
                                            <input type="text"
                                                name="slogan_bg_color[]"
                                                class="form-control"
                                                value="{{ $oldBgColors[$i] ?? '' }}"
                                                placeholder="#ffffff">
                                            <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-square"
                                                style="color: {{ $oldBgColors[$i] ?? '#ffffff' }}"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-success btn-sm addRow">+</button>
                                        <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
                                    </td>
                                </tr>
                            @endforeach

                        @elseif(isset($campaign) && $campaign->slogans && $campaign->slogans->count())
                            @foreach($campaign->slogans as $slogan)
                            <tr class="dynamic-tr">
                                <td>
                                    <input type="hidden" name="slogan_id[]" value="{{ $slogan->id }}">
                                    <input type="text" name="slogan_title[]" class="form-control"
                                        value="{{ $slogan->slogan_title }}" placeholder="Enter title">
                                </td>

                                <td>
                                    <div class="input-group slogan-text-colorpicker">
                                        <input type="text" name="slogan_text_color[]" class="form-control"
                                            value="{{ $slogan->slogan_text_color }}" placeholder="#000000">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                            <i class="fas fa-square" style="color: {{ $slogan->slogan_text_color ?? '#000000' }}"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-group slogan-bg-colorpicker">
                                        <input type="text" name="slogan_bg_color[]" class="form-control"
                                            value="{{ $slogan->slogan_bg_color }}" placeholder="#ffffff">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                            <i class="fas fa-square" style="color: {{ $slogan->slogan_bg_color ?? '#ffffff' }}"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm addRow">+</button>
                                    <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
                                    <a href="{{ route('sloganDelete', $slogan->id) }}" class="btn btn-primary btn-sm">X</a>
                                </td>
                            </tr>
                            @endforeach

                        @else
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
                        @endif
                    </tbody>
                </table>
                <small class="seo-subtitle mb-0 label-color">
                    Add multiple slogans. They rotate in the announcement banner at the top of the page.
                </small>
            </div>
        </div>

        <div class="card-footer w3-round-large" style="position: relative; z-index: 999;">
            <div class="d-flex justify-content-between align-items-center mt-2 w-100">
                <div>
                    Last saved: {{ $campaign->updated_at->format('M d, Y g:i A') }}
                </div>

                <div class="ml-auto d-flex align-items-center">
                    <a href="{{ route('campaigns.index') }}" id="discardBtn" class="btn btn-sm mr-2 w3-round-large" style="background-color: #afb3ba;">
                        <i class="fas fa-times"></i> Discard Changes
                    </a>

                    <button type="button" id="previewBtn" class="btn btn-sm mr-2 previewBtn w3-round-large" style="background-color: #afb3ba;">
                        <i class="fas fa-eye"></i> Preview
                    </button>

                    <button type="submit" id="realSubmitBtn" class="btn btn-sm btn-primary w3-round-large">
                        <i class="fas fa-save"></i> Save & Publish
                    </button>
                </div>
            </div>
        </div>

        @include('admin.canpaign.preview')
    </form>
</div>

@endsection

@section('js')
<script src="{{ asset('backend-asset/plugins/tinymce/tinymce.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.delete-image').click(function() {
            var imageId = $(this).data('id');
            var imageElement = $(this).closest('.col-6');
            
            if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: '/admin/delete-image/' + imageId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            imageElement.remove();
                        } else {
                            alert('Error deleting image');
                        }
                    },
                    error: function() {
                        alert('Something went wrong, please try again.');
                    }
                });
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seoInput = document.getElementById('seo_title_{{ $code }}');
        const seoCount = document.getElementById('seo_title_count_{{ $code }}');

        if (seoInput && seoCount) {
            const updateCount = () => {
                const length = seoInput.value.length;
                seoCount.textContent = length;

                seoCount.classList.remove('text-success', 'text-warning', 'text-danger');

                if (length >= 50 && length <= 60) {
                    seoCount.classList.add('text-success');
                } else if ((length >= 40 && length < 50) || (length > 60 && length <= 70)) {
                    seoCount.classList.add('text-warning');
                } else {
                    seoCount.classList.add('text-danger');
                }
            };

            updateCount();
            seoInput.addEventListener('input', updateCount);
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("textarea[id^='seo_description_']").forEach(function (textarea) {
            let code = textarea.id.replace('seo_description_', '');
            let counter = document.getElementById('seo_description_count_' + code);

            function updateCount() {
                let length = textarea.value.length;
                counter.textContent = length;

                counter.classList.remove('text-success', 'text-warning', 'text-danger');

                if (length >= 120 && length <= 160) {
                    counter.classList.add('text-success');
                } else if ((length >= 100 && length < 120) || (length > 160 && length <= 180)) {
                    counter.classList.add('text-warning');
                } else {
                    counter.classList.add('text-danger');
                }
            }

            updateCount();
            textarea.addEventListener("input", updateCount);
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

        const slug      = $(`input[name="slug[${locale}]"]`).val()
                       || $(`input[name="slug[${locale}]"]`).val()
                       || '';

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
  function initSloganColorPickers(scope = document) {
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
    initSloganColorPickers(document);
  });

  document.addEventListener('click', function(e){
    if(e.target.classList.contains('addRow')){
      let tbody = document.getElementById('dynamicTableBody');

      let tr = document.createElement('tr');
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
              <span class="input-group-text"><i class="fas fa-square" style="color:#000000"></i></span>
            </div>
          </div>
        </td>

        <td>
          <div class="input-group slogan-bg-colorpicker">
            <input type="text" name="slogan_bg_color[]" class="form-control" placeholder="#ffffff">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fas fa-square" style="color:#ffffff"></i></span>
            </div>
          </div>
        </td>

        <td class="text-center">
          <button type="button" class="btn btn-success btn-sm addRow">+</button>
          <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
        </td>
      `;

      tbody.appendChild(tr);
      initSloganColorPickers(tr);
    }

    if(e.target.classList.contains('removeRow')){
      let row = e.target.closest('tr');
      let tbody = document.getElementById('dynamicTableBody');

      if(tbody.querySelectorAll('tr').length > 1){
        row.remove();
      }else{
        row.querySelector('input[name="slogan_id[]"]').value = '';
        row.querySelector('input[name="slogan_title[]"]').value = '';
        row.querySelector('input[name="slogan_text_color[]"]').value = '';
        row.querySelector('input[name="slogan_bg_color[]"]').value = '';

        const textIcon = row.querySelector('.slogan-text-colorpicker .fa-square');
        const bgIcon   = row.querySelector('.slogan-bg-colorpicker .fa-square');
        if (textIcon) textIcon.style.color = '#000000';
        if (bgIcon) bgIcon.style.color = '#ffffff';
      }
    }
  });
</script>

<script>
  $(function () {
    $('.footer-colorpicker').colorpicker();

    $('.footer-colorpicker').on('colorpickerChange', function (event) {
      $(this).find('.fa-square').css('color', event.color.toString());
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
                url: "{{ route('campaign.update.inline.url', $campaign->id) }}",
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
</script>

@endsection