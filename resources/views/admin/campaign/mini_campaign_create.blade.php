@extends('admin.layouts.master')

@section('title', 'Create Mini Campaign')

@section('css')
    <style>
        .req::after {
            content: " *";
            color: #dc3545;
            font-weight: 700;
        }

        .thumb {
            height: 70px;
            width: 110px;
            object-fit: cover;
            border-radius: 10px;
        }

        .editor-shell .tox-tinymce {
            border-radius: .35rem !important;
        }

        .editor-invalid .tox-tinymce {
            border: 1px solid #dc3545 !important;
        }

        .seo-note-wrap {
            gap: 10px;
        }

        .mini-form-card {
            overflow: hidden;
        }

        .lang-switch-form {
            display: inline-block;
        }

        .mini-help-box {
            background-color: #DFF5F3;
            border-radius: .35rem;
            padding: 10px 12px;
        }

        .mini-help-box i {
            margin-right: 8px;
        }

        .sticky-form-actions {
            position: sticky;
            bottom: 0;
            z-index: 10;
            background: #fff;
            border-top: 1px solid #e9ecef;
        }

        @media (max-width: 767.98px) {
            .sticky-form-actions {
                position: static;
            }
        }
    </style>
@endsection

@section('admin')
@php
    $locale = session('locale', config('app.locale'));
    $languages = \App\Models\Language::where('active', 1)->get();
    $langCode = $languages->firstWhere('language_code', $locale);
    $code = $locale;
@endphp

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div class="mb-3 mb-md-0">
            <h3 class="mb-2 font-weight-bold main-page-heading">
                Create Mini Campaign
            </h3>

            <div class="small">
                <a href="{{ url('/dashboard') }}" class="text-primary">Dashboard</a>
                <span class="text-muted mx-1">/</span>
                <a href="{{ route('campaigns.miniCampaignIndex') }}" class="text-primary">Mini Campaign</a>
                <span class="text-muted mx-1">/</span>
                <span class="text-muted">Create</span>
            </div>
        </div>

        <div class="d-flex flex-wrap">
            <a href="{{ route('campaigns.miniCampaignIndex') }}" class="btn btn-sm btn-default mr-2 mb-2 mb-md-0 w3-round-large">
                <i class="far fa-file-alt mr-1"></i> All Mini Campaigns
            </a>
        </div>
    </div>
</div>

<div class="container-fluid pt-2">
    <div class="card card-outline card-light w3-round-large">
        <div class="card-body py-2 px-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="nav nav-pills">
                    @foreach ($languages as $language)
                        <form action="{{ route('languageUpdateStatus', $language) }}" method="POST" class="mr-2 mb-2 lang-switch-form">
                            @csrf
                            <button
                                type="submit"
                                class="nav-link font-weight-bold border-0 {{ $locale === $language->language_code ? 'active' : 'bg-light text-muted' }}"
                                style="border-radius:10px !important;">
                                <span class="mr-2">
                                    <img src="{{ asset('storage/country_flag/' . $language->country_flag) }}"
                                         alt="{{ $language->title }}"
                                         style="height:14px;width:20px;border-radius:1px;">
                                </span>
                                {{ $language->title }}
                                <span class="font-weight-normal">
                                    ({{ strtoupper($language->language_code) }})
                                </span>
                            </button>
                        </form>
                    @endforeach
                </div>

                <div class="small text-muted mt-2 mt-md-0">
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
            setTimeout(function () {
                $('#success-alert').alert('close');
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form id="miniCampaignForm"
          action="{{ route('campaigns.miniCampaignStore') }}"
          method="POST"
          enctype="multipart/form-data"
          novalidate>
        @csrf

        <div class="form-group mb-4">
            <div class="alert mb-0 py-2 px-3 w3-round-large"
                id="campaignUrlBox"
                style="background-color: #DFF5F3;">
                <div class="d-flex align-items-center flex-wrap" style="gap:10px;">
                    <div id="urlViewMode" class="d-flex align-items-center flex-wrap" style="gap:10px;">
                        <i class="fas fa-link"></i>
                        <span id="campaignUrlText">
                            sai.ngo/{{ $code === 'es' ? 'es/' : '' }}mini-campaign/{{ old('slug.' . $code) }}
                        </span>
                        <button type="button" id="editUrlBtn" class="btn btn-xs text-black border" style="background-color:#D6EADC; color:#000;">
                            <i class="far fa-edit mr-1"></i> Edit
                        </button>
                    </div>

                    <div id="urlEditMode" class="w-100" style="display:none;">
                        <div class="d-flex align-items-center flex-wrap" style="gap:10px;">
                            <span class="font-weight-bold">sai.ngo/{{ $code === 'es' ? 'es/' : '' }}mini-campaign/</span>
                            <input type="text"
                                id="campaignUrlInput"
                                name="slug[{{ $code }}]"
                                class="form-control"
                                style="max-width:350px;"
                                value="{{ old('slug.' . $code) }}"
                                placeholder="usa/help-venezuela">
                            <button type="button" id="saveUrlBtn" class="btn btn-success btn-sm">
                                <i class="far fa-check-circle mr-1"></i> Done
                            </button>
                            <button type="button" id="cancelUrlBtn" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </button>
                        </div>
                        @error('slug.' . $code)
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card w3-round-large mini-form-card">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color">
                                <b class="label-color">Campaign Settings</b>
                            </h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ strtoupper($code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Status, scheduling, and images — shared across all languages
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Publication Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="seo-subtitle mb-0 label-color">
                            Only published mini campaigns are publicly visible.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Urgency Tag</label>
                        <input type="text"
                               name="tag_line"
                               value="{{ old('tag_line') }}"
                               class="form-control @error('tag_line') is-invalid @enderror"
                               placeholder="Urgent Tag">
                        @error('tag_line')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="seo-subtitle mb-0 label-color">
                            A short badge label shown on the campaign card to create urgency. Leave blank to hide.
                        </small>
                    </div>

                    {{--
                    <div class="col-md-12 mb-3">
                        <label class="req font-weight-bold">View Project URL — CTA Link</label>
                        <input type="url"
                               name="view_project_url"
                               value="{{ old('view_project_url') }}"
                               class="form-control @error('view_project_url') is-invalid @enderror"
                               placeholder="https://yourdomain.com/projects/slug">
                        @error('view_project_url')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="seo-subtitle mb-0 label-color">
                            The destination URL when a visitor clicks the "View Project" call-to-action button.
                        </small>
                    </div>
                    --}}
                </div>

                <div class="seo-divider">
                    <span>SCHEDULING</span>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="font-weight-bold">Start Date & Time</label>
                        <input type="datetime-local"
                               name="start_date"
                               class="form-control @error('start_date') is-invalid @enderror"
                               value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="seo-subtitle mb-0 label-color">
                            The date and time this campaign becomes visible.
                        </small>
                    </div>

                    {{--
                    <div class="col-12 col-md-6 mb-3">
                        <label class="font-weight-bold">End Date & Time</label>
                        <input type="datetime-local"
                               name="end_date"
                               class="form-control @error('end_date') is-invalid @enderror"
                               value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="seo-subtitle mb-0 label-color">
                            The campaign will automatically hide after this date and time.
                        </small>
                    </div>
                    --}}
                </div>

                <div class="seo-divider">
                    <span>Cover Image</span>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Cover Image</label>
                        <input type="file"
                               name="cover_image"
                               class="form-control @error('cover_image') is-invalid @enderror"
                               accept="image/*">
                        @error('cover_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="seo-subtitle mb-0 label-color">
                            Hero image displayed at the top of the mini campaign page. Recommended: 1200×630 px.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">OG / Social Share Image (Optional)</label>
                        <input type="file"
                               name="og_image"
                               class="form-control @error('og_image') is-invalid @enderror"
                               accept="image/*">
                        @error('og_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="seo-subtitle mb-0 label-color">
                            Overrides the image shown when this page is shared on Facebook, Twitter, and WhatsApp.
                            If blank, the cover image is used.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w3-round-large mini-form-card">
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
                                Dedicated banner image. If not provided, the cover image is used.
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

        <div class="card w3-round-large mini-form-card">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color">
                                <b class="label-color">Content & Copy</b>
                            </h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ strtoupper($code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Title, slug, donation widget, and campaign body copy
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 mb-3">
                        <label class="font-weight-bold">Campaign Title</label>
                        <input type="text"
                               name="title[{{ $code }}]"
                               value="{{ old('title.' . $code) }}"
                               placeholder="e.g. Donate to Help Venezuela"
                               class="form-control @error('title.' . $code) is-invalid @enderror">
                        @error('title.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">The main headline shown at the top of this mini campaign page.</small>
                    </div>
                </div>

                <div class="seo-divider">
                    <span>SEO Short Description (Above the fold)</span>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="req font-weight-bold">SEO Short Description</label>
                        <div class="editor-shell {{ $errors->has('short_description.' . $code) ? 'editor-invalid' : '' }}">
                            <textarea
                                name="short_description[{{ $code }}]"
                                rows="6"
                                class="form-control tinymce-editor @error('short_description.' . $code) is-invalid @enderror"
                                data-editor="short_description"
                            >{{ old('short_description.' . $code) }}</textarea>
                        </div>
                        @error('short_description.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="mini-help-box mt-3">
                            <i class="fas fa-file-alt text-info"></i>
                            This text appears at the very top of the page, before the visitor scrolls.
                            Keep it punchy and compelling — ideally 1–3 sentences that explain the cause and invite action.
                        </div>
                    </div>
                </div>

                <div class="seo-divider">
                    <span>Body Copy</span>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="req font-weight-bold">Paragraph One</label>
                        <div class="editor-shell {{ $errors->has('paragraph_one.' . $code) ? 'editor-invalid' : '' }}">
                            <textarea
                                name="paragraph_one[{{ $code }}]"
                                rows="10"
                                class="form-control tinymce-editor @error('paragraph_one.' . $code) is-invalid @enderror"
                                data-editor="paragraph_one"
                            >{{ old('paragraph_one.' . $code) }}</textarea>
                        </div>
                        @error('paragraph_one.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="req font-weight-bold">Paragraph Two</label>
                        <div class="editor-shell {{ $errors->has('paragraph_two.' . $code) ? 'editor-invalid' : '' }}">
                            <textarea
                                name="paragraph_two[{{ $code }}]"
                                rows="10"
                                class="form-control tinymce-editor @error('paragraph_two.' . $code) is-invalid @enderror"
                                data-editor="paragraph_two"
                            >{{ old('paragraph_two.' . $code) }}</textarea>
                        </div>
                        @error('paragraph_two.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="seo-divider">
                    <span>Donation Widget</span>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="font-weight-bold">Donation Box Embed</label>
                        <textarea
                            name="donation_box[{{ $code }}]"
                            rows="5"
                            class="form-control @error('donation_box.' . $code) is-invalid @enderror"
                            placeholder='<iframe src="..."></iframe>'
                        >{{ old('donation_box.' . $code) }}</textarea>
                        @error('donation_box.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-2">
                            Paste the mini campaign donation box iframe embed code. Example:
                            <code>&lt;iframe src="..."&gt;&lt;/iframe&gt;</code>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w3-round-large mini-form-card">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color">
                                <b class="label-color">SEO & Social Sharing</b>
                            </h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                {{ strtoupper($code) }}
                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Meta tags, Open Graph, keywords, and canonical URL
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>Meta Title</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #DCFCE7;">
                                meta name="title"
                            </span>
                        </label>
                        <input type="text"
                               name="meta_title[{{ $code }}]"
                               value="{{ old('meta_title.' . $code) }}"
                               class="form-control @error('meta_title.' . $code) is-invalid @enderror"
                               id="meta_title_{{ $code }}">
                        @error('meta_title.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="d-flex justify-content-between align-items-center mt-2 seo-note-wrap">
                            <small class="seo-help-text">
                                Recommended: 50–60 characters • Appears as the clickable headline in Google.
                            </small>
                            <small class="seo-count-text font-weight-bold mb-0">
                                <span id="meta_title_count_{{ $code }}">0</span> / 60
                            </small>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>Meta Keywords</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #FEF3C7;">
                                meta name="keywords"
                            </span>
                        </label>
                        <input type="text"
                               name="meta_keywords[{{ $code }}]"
                               value="{{ old('meta_keywords.' . $code) }}"
                               class="form-control @error('meta_keywords.' . $code) is-invalid @enderror"
                               placeholder="keyword1, keyword2">
                        @error('meta_keywords.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Comma-separated keywords. Not a major ranking factor but useful for internal tagging.</small>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>Meta Description</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #DBEAFE;">
                                meta name="description"
                            </span>
                        </label>
                        <textarea
                            name="meta_description[{{ $code }}]"
                            rows="4"
                            class="form-control @error('meta_description.' . $code) is-invalid @enderror"
                            id="meta_description_{{ $code }}"
                        >{{ old('meta_description.' . $code) }}</textarea>
                        @error('meta_description.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="mini-help-box mt-3">
                            <i class="fas fa-file-alt text-info"></i>
                            <strong>What it is:</strong>
                            The short paragraph shown beneath the SEO title in Google results.
                            It does not directly affect ranking but strongly influences click-through rate.
                            Aim for <strong>120–160 characters</strong>.
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted">
                                Recommended: 120–160 characters · Shown as the grey snippet text in Google.
                            </small>
                            <small class="font-weight-bold mb-0">
                                <span id="meta_description_count_{{ $code }}">0</span> / 160
                            </small>
                        </div>
                    </div>
                </div>

                <div class="seo-divider">
                    <span>Open Graph — Social Sharing</span>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>OG Title</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #DCFCE7;">
                                meta property="og:title"
                            </span>
                        </label>
                        <input type="text"
                               name="og_title[{{ $code }}]"
                               value="{{ old('og_title.' . $code) }}"
                               class="form-control @error('og_title.' . $code) is-invalid @enderror"
                               placeholder="Title shown when shared on social media...">
                        @error('og_title.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Overrides the page title when shared on Facebook, Twitter, WhatsApp. If blank, falls back to Meta Title.
                        </small>
                    </div>

                    {{--
                    <div class="col-12 col-md-6 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>Canonical URL</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #EDE9FE;">
                                rel="canonical"
                            </span>
                        </label>
                        <input type="url"
                               name="canonical_url[{{ $code }}]"
                               value="{{ old('canonical_url.' . $code) }}"
                               class="form-control @error('canonical_url.' . $code) is-invalid @enderror"
                               placeholder="https://sai.ngo/mini/campaign-slug">
                        @error('canonical_url.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Optional canonical URL override.
                        </small>
                    </div>
                    --}}

                    <div class="col-12 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>OG Description</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #DCFCE7;">
                                og:description
                            </span>
                        </label>
                        <textarea
                            name="og_description[{{ $code }}]"
                            rows="4"
                            class="form-control @error('og_description.' . $code) is-invalid @enderror"
                            placeholder="Description shown when this page is shared on social media..."
                        >{{ old('og_description.' . $code) }}</textarea>
                        @error('og_description.' . $code)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="mini-help-box mt-3">
                            <i class="fas fa-file-alt text-info"></i>
                            This text appears in social media share previews on Facebook, Twitter, LinkedIn, and WhatsApp.
                            Aim for 100–200 characters — something compelling that makes people want to click.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end flex-wrap sticky-form-actions">
                <a href="{{ route('campaigns.miniCampaignIndex') }}"
                   class="btn mr-2 mb-2"
                   style="background-color: #afb3ba;">
                    <i class="fas fa-times"></i> Discard Changes
                </a>

                <button type="button"
                        id="previewBtn"
                        class="btn mr-2 mb-2"
                        style="background-color: #afb3ba;">
                    <i class="fas fa-eye"></i> Preview
                </button>

                <button type="submit"
                        id="realSubmitBtn"
                        class="btn btn-primary mb-2">
                    <i class="fas fa-save"></i> Save & Publish
                </button>
            </div>
        </div>

        @include('admin.canpaign.minicampaign_preview')
    </form>
</div>


@endsection

@section('js')
   <script src="{{ asset('backend-asset/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(function () {
            const locale = @json($code);
            const oldCover = '';
            const oldOg = '';

            let originalUrl = $('#campaignUrlInput').val();

            $('#editUrlBtn').on('click', function () {
                originalUrl = $('#campaignUrlInput').val();
                $('#urlViewMode').hide();
                $('#urlEditMode').show();
            });

            $('#cancelUrlBtn').on('click', function () {
                $('#campaignUrlInput').val(originalUrl);
                $('#urlEditMode').hide();
                $('#urlViewMode').show();
            });

            $('#saveUrlBtn').on('click', function () {
                let fullUrl = $('#campaignUrlInput').val().trim();
                if (fullUrl === '') {
                    $('#campaignUrlInput').addClass('is-invalid');
                    return;
                }
                $('#campaignUrlInput').removeClass('is-invalid');
                
                const localePrefix = "{{ $code === 'es' ? 'es/' : '' }}";
                $('#campaignUrlText').text('sai.ngo/' + localePrefix + 'mini-campaign/' + fullUrl);
                $('#urlEditMode').hide();
                $('#urlViewMode').show();
            });

            function updateCharCount(inputSelector, counterSelector) {
                const value = $(inputSelector).val() || '';
                $(counterSelector).text(value.length);
            }

            function initCounters() {
                updateCharCount(`#meta_title_${locale}`, `#meta_title_count_${locale}`);
                updateCharCount(`#meta_description_${locale}`, `#meta_description_count_${locale}`);

                $(document).on('input', `#meta_title_${locale}`, function () {
                    updateCharCount(`#meta_title_${locale}`, `#meta_title_count_${locale}`);
                });

                $(document).on('input', `#meta_description_${locale}`, function () {
                    updateCharCount(`#meta_description_${locale}`, `#meta_description_count_${locale}`);
                });
            }

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

            function getInputValue(selector) {
                return $(selector).length ? ($(selector).val() || '') : '';
            }

            function bindPreview() {
                $(document).on('click', '#previewBtn, .previewBtn', function (e) {
                    e.preventDefault();

                    syncTinyMce();

                    const title = getInputValue(`input[name="title[${locale}]"]`);
                    const slug = getInputValue(`input[name="slug[${locale}]"]`);
                    const cta = getInputValue('input[name="view_project_url"]');

                    const short = getEditorContent(`short_description[${locale}]`);
                    const p1 = getEditorContent(`paragraph_one[${locale}]`);
                    const p2 = getEditorContent(`paragraph_two[${locale}]`);

                    const metaTitle = getInputValue(`input[name="meta_title[${locale}]"]`);
                    const metaDesc = getInputValue(`textarea[name="meta_description[${locale}]"]`);
                    const ogTitle = getInputValue(`input[name="og_title[${locale}]"]`);
                    const ogDesc = getInputValue(`textarea[name="og_description[${locale}]"]`);
                    const canonical = getInputValue(`input[name="canonical_url[${locale}]"]`);

                    const status = getInputValue('select[name="status"]');
                    const start = getInputValue('input[name="start_date"]');
                    const end = getInputValue('input[name="end_date"]');
                    const tagLine = getInputValue('input[name="tag_line"]');

                    $('#pvTitle').text(title || 'N/A');
                    $('#pvSlug').text(slug || 'N/A');
                    $('#pvTagLine').text(tagLine || 'N/A');

                    if (cta) {
                        const safeCta = /^https?:\/\//i.test(cta) ? cta : ('https://' + cta);
                        $('#pvCta').text(safeCta).attr('href', safeCta);
                    } else {
                        $('#pvCta').text('N/A').attr('href', '#');
                    }

                    $('#pvShort').html(short || '<em>No short description</em>');
                    $('#pvP1').html(p1 || '<em>No paragraph one</em>');
                    $('#pvP2').html(p2 || '<em>No paragraph two</em>');

                    $('#pvMetaTitle').text(metaTitle || 'N/A');
                    $('#pvMetaDesc').text(metaDesc || 'N/A');
                    $('#pvOgTitle').text(ogTitle || 'N/A');
                    $('#pvOgDesc').text(ogDesc || 'N/A');
                    $('#pvCanonical').text(canonical || 'N/A');

                    $('#pvStatus').text(status === '1' ? 'Published' : 'Draft');
                    $('#pvStart').text(start || 'N/A');
                    $('#pvEnd').text(end || 'N/A');

                    const coverInput = document.querySelector('input[name="cover_image"]');
                    if (coverInput && coverInput.files && coverInput.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (ev) {
                            $('#pvCoverImg').attr('src', ev.target.result).show();
                            $('#pvCoverEmpty').hide();
                        };
                        reader.readAsDataURL(coverInput.files[0]);
                    } else if (oldCover) {
                        $('#pvCoverImg').attr('src', oldCover).show();
                        $('#pvCoverEmpty').hide();
                    } else {
                        $('#pvCoverImg').hide();
                        $('#pvCoverEmpty').show();
                    }

                    const ogInput = document.querySelector('input[name="og_image"]');
                    if (ogInput && ogInput.files && ogInput.files[0]) {
                        const reader2 = new FileReader();
                        reader2.onload = function (ev) {
                            $('#pvOgImg').attr('src', ev.target.result).show();
                            $('#pvOgEmpty').hide();
                        };
                        reader2.readAsDataURL(ogInput.files[0]);
                    } else if (oldOg) {
                        $('#pvOgImg').attr('src', oldOg).show();
                        $('#pvOgEmpty').hide();
                    } else {
                        $('#pvOgImg').hide();
                        $('#pvOgEmpty').show();
                    }

                    $('#previewModal').modal('show');
                });
            }

            function bindFormSubmit() {
                $('#miniCampaignForm').on('submit', function () {
                    syncTinyMce();
                    $('#realSubmitBtn')
                        .prop('disabled', true)
                        .html('<i class="fas fa-spinner fa-spin"></i> Saving...');
                });

                $('#confirmSave').on('click', function (e) {
                    e.preventDefault();
                    syncTinyMce();
                    $(this).prop('disabled', true);
                    $('#miniCampaignForm').submit();
                });
            }

            function assignTextareaIds() {
                $('textarea.tinymce-editor').each(function (index) {
                    if (!this.id) {
                        this.id = 'tinymce_editor_' + index;
                    }
                });
            }

            assignTextareaIds();
            initTinyMce();
            initCounters();
            bindPreview();
            bindFormSubmit();
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