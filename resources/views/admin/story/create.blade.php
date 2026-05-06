@extends('admin.layouts.master')

@section('title', 'Report Create')

@section('css')

<style>
    .note-editor.note-frame {
        border-radius: 6px;
    }

    /* Select2 height fix */
    .select2-container--default .select2-selection--single {
        height: 38px !important; /* Bootstrap default */
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    /* Text vertically center */
    .select2-container--default .select2-selection--single 
    .select2-selection__rendered {
        line-height: 24px;
    }

    /* Arrow center */
    .select2-container--default .select2-selection--single 
    .select2-selection__arrow {
        height: 36px;
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
                Create Report
            </h3>

            <div class="small">
                <a href="{{ url('/dashboard') }}" class="text-primary">Dashboard</a>
                <span class="text-muted mx-1">/</span>
                <a href="{{ route('stories.index') }}" class="text-primary">Report</a>
                <span class="text-muted mx-1">/</span>
                <span class="text-muted">Create</span>
            </div>
        </div>

        <div class="d-flex flex-wrap">
            <a href="{{ route('stories.index') }}" class="btn btn-sm btn-default mr-2 mb-2 mb-md-0 w3-round-large">
                <i class="far fa-file-alt mr-1"></i> All Report
            </a>

            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-dark mb-2 mb-md-0 previewBtn w3-round-large">
                <i class="far fa-eye mr-1"></i> Preview
            </a> -->
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
    <form id="storyCreateForm" action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card  w3-round-large">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>
                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="label-color">Author, Project & Category</b></h4>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Linked Project</label>
                            <select name="campaign_id"
                                    class="form-control select2"
                                    required
                                    style="width:100%">
                                <option value="">None</option>
                                @foreach($campaigns as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('campaign_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="seo-subtitle mb-0 label-color">
                                The campaign this report belongs to
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Author</label>
                            <select name="user_id"
                                    class="form-control select2"
                                    required
                                    style="width:100%">
                                <option value="">-- None --</option>
                                @foreach($author as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                            <select name="category_id"
                                    class="form-control select2"
                                    required
                                    style="width:100%">
                                @foreach($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
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

        <div class="card  w3-round-large">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="label-color">CONTENT & NARRATIVE</b></h4>
                            <span class="seo-lang">EN</span>
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
                            @php  $langCode = $language->language_code;  @endphp
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Report Title </label>
                                    <input type="text" 
                                        name="title[{{ $langCode }}]" 
                                        class="form-control"  
                                        value="{{ old('title.' . $langCode, $report->title[$langCode] ?? '') }}"
                                        placeholder="Enter the main title for this report" 
                                        required>
                                        <small class="form-text text-muted">The main heading displayed on this report.</small>
                                    @error('title.' . $langCode)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    @endforeach
                
                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $langCode = $language->language_code;  @endphp
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Short description </label>
                                    <textarea name="short_description[{{ $langCode }}]" 
                                            rows="3" 
                                            class="form-control" 
                                            placeholder="Short description">{{ old('short_description.' . $langCode, $report->short_description[$langCode] ?? '') }}</textarea>
                                    @error('short_description.' . $langCode)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Displayed as a preview or teaser in report listings.</small>
                                </div>
                            </div>
                            @endif
                    @endforeach
                
                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php $langCode = $language->language_code;   @endphp
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Full Report Content</label>
                                    <textarea name="description[{{ $langCode }}]" 
                                            id="summernote_{{ $langCode }}" 
                                            class="summernote form-control" 
                                            placeholder="Report Content"
                                            rows="5">{{ old('description.' . $langCode, $report->description[$langCode] ?? '') }}</textarea>
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

        <div class="card  w3-round-large">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color"><b class="label-color">SEO &amp; SEARCH OPTIMIZATION</b></h4>
                            <span class="seo-lang">EN</span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            URL slugs, meta tags, and search visibility — English version
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
                                    <label class="req">Page URL </label>
                                    <div class="input-group page-url-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text page-url-prefix">sai.ngo/</span>
                                        </div>
                                        <input type="text" id="slug" name="slug[{{ $code }}]" value="{{ old('slug.' . $code) }}"
                                        class="form-control @error('slug') is-invalid @enderror"
                                        placeholder="Project url " required>
                                    </div>
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="callout callout-info- py-1 mt-3 mb-0 py-1" style="background-color: #DFF5F3;">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="fas fa-file-alt text-info"></i>
                                            </div>
                                            <div class="mb-0">
                                                www.sai.ngo/report/example-campaign-title
                                            </div>
                                        </div>
                                    </div>

                                    <small class="page-url-help">
                                        Enter the full path after the domain — e.g. usa/help-venezuela. Use lowercase, hyphens only. Never change a live URL without setting up a redirect.
                                    </small>
                                </div>
                            @endif 
                        @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php  $langCode = $language->language_code; @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SEO TITLE  </label>
                                    <input type="text" name="seo_title[{{ $langCode }}]" class="form-control" placeholder="SEO title ({{ $langCode }})"  value="{{ old('seo_title.' . $langCode) }}" required>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    
                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php  $langCode = $language->language_code; @endphp
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tags  ({{ $langCode }})</label>
                                <input type="text" name="tags[{{ $langCode }}]" class="form-control" placeholder="tags ({{ $langCode }})"  value="{{ old('tags.' . $langCode) }}">
                            </div>
                        </div>
                        @endif
                    @endforeach

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                            @php  $langCode = $language->language_code; @endphp
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description for google meta tags  </label>
                                    <textarea name="meta_description[{{ $langCode }}]" rows="3" 
                                        class="form-control" placeholder="Description for google meta tags ({{ $langCode }})">{{ old('meta_description.' . $langCode) }}</textarea>
                                    
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
                            <span class="seo-lang">EN</span>
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
                                    <label>Footer Heading  </label>
                                    <input type="text" name="footer_title[{{ $code }}]" class="form-control" value="{{ old('footer_title.' . $code) }}">
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
                                    <label>Footer sub Heading </label>
                                    <input type="text" name="footer_subtitle[{{ $code }}]" class="form-control" value="{{ old('footer_subtitle.' . $code) }}">
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

        <div class="card  w3-round-large">
            <div class="card-header seo-card-header">
                    <div class="d-flex align-items-start">
                        <div class="seo-icon-box mr-3">
                            <i class="far fa-file-alt w-4"></i>
                        </div>

                        <div class="seo-header-content">
                            <div class="d-flex align-items-center flex-wrap">
                                <h4 class="card-title mb-0 mr-2 label-color"><b class="header-title">Media & Publication</b></h4>
                                <span class="seo-lang">EN</span>
                            </div>
                            <small class="seo-subtitle mb-0 label-color">
                                Featured image, status, publish date, and display order — shared across all versions
                            </small>
                        </div>
                    </div>
                </div> 
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Featured Image</label>
                            <input type="file" name="image" class="form-control" >
                            <small class="seo-subtitle label-color d-block mb-2">
                                Cover image in report listings. Recommended: 1200×630 px.
                            </small>
                        </div>
                    </div>
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Project Status</label>
                            <select name="status" class="form-control">
                                <option value="draft">draft</option>
                                <option value="published">published</option>
                            </select>
                            <small class="seo-subtitle mb-0 label-color">
                                Only Published reports are publicly visible.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Published Date:</label>
                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                <input type="text" name="published_at" class="form-control datetimepicker-input" data-target="#reservationdatetime"  value="{{ old('published_at') }}"/>
                                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <small class="seo-subtitle mb-0 label-color">
                                    The date this report is publicly attributed to.
                                </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      

        <div class="card-footer  w3-round-large text-right">
            <a href="{{ route('stories.index') }}" id="discardBtn" class="btn btn-sm mr-2 w3-round-large" style="background-color: #afb3ba;">
                <i class="fas fa-times"></i> Discard Changes
            </a>

            <button type="button" id="previewBtn" class="btn btn-sm mr-2 w3-round-large"  style="background-color: #afb3ba;">
                <i class="fas fa-eye"></i> Preview
            </button>

            <button type="submit" id="realSubmitBtn" class="btn btn-sm mr-2 btn-primary w3-round-large">
                <i class="fas fa-save"></i> Save & publish
            </button>

            
        </div>

        @include('admin.story.story_preview_modal')
    </form>
</div>




@endsection
@section('js')

{{-- Tempus Dominus --}}
<script src="{{ asset('backend-asset/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend-asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>






<script>
$(function () {

    // =============== Summernote Init ===============


    // =============== Datepicker Init ===============
    if ($('#reservationdatetime').length) {
        $('#reservationdatetime').datetimepicker({
            format: 'YYYY-MM-DD',
            icons: { time: 'far fa-clock', date: 'far fa-calendar-alt' }
        });
    }

    // =============== Auto Slug (current locale only) ===============
    const locale = @json($locale);

    const $titleInput = $(`#title_${locale}`);
    const $slugInput  = $(`#slug_${locale}`);

    if ($titleInput.length && $slugInput.length) {
        $titleInput.on('keyup', function () {
            let title = $(this).val() || '';

            let slug = title
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            $slugInput.val(slug);
        });
    }

    // =============== Preview Button ===============
    $('#previewBtn').on('click', function (e) {
        e.preventDefault();

        // fields (current locale)
        const title = $(`input[name="title[${locale}]"]`).val() || '';
        const slug  = $(`input[name="slug[${locale}]"]`).val() || '';
        const short = $(`textarea[name="short_description[${locale}]"]`).val() || '';

        tinymce.triggerSave();
        const descTextarea = $(`textarea[name="description[${locale}]"]`);
        const desc = descTextarea.length ? descTextarea.val() : '';

        const seoTitle = $(`input[name="seo_title[${locale}]"]`).val() || '';
        const metaDesc = $(`input[name="meta_description[${locale}]"]`).val() || '';
        const tags     = $(`input[name="tags[${locale}]"]`).val() || '';

        const status   = $('select[name="status"]').val() || '';
        const published = $('input[name="published_at"]').val() || '';
        const position = $('input[name="position"]').val() || '';

        // Fill modal (these IDs must exist in admin.story.story_preview_modal)
        $('#pvTitle').text(title);
        $('#pvSlug').text(slug);
        $('#pvShort').text(short);
        $('#pvDesc').html(desc);

        $('#pvSeoTitle').text(seoTitle);
        $('#pvMetaDesc').text(metaDesc);
        $('#pvTags').text(tags);

        $('#pvStatus').text(status);
        $('#pvPublished').text(published);
        $('#pvPosition').text(position);

        // Featured image preview (selected file only)
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

        $('#previewModal').modal('show');
    });

    // =============== Confirm Save ===============
    $('#confirmUpdate').on('click', function (e) {
        e.preventDefault();

        tinymce.triggerSave();

        // disable to prevent double click
        $('#confirmUpdate').prop('disabled', true);

        // submit ONLY create form
        document.getElementById('storyCreateForm').submit();
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
        // Reset classes
        headerPhotoPreview.className = '';
        
        // Tailwind classes corresponding to the select value
        const classes = e.target.value.split(' ');
        
        // Map to CSS styles directly for the admin preview to ensure it works without Tailwind being compiled for admin
        let objectFit = 'cover';
        let objectPosition = 'center';
        
        if (e.target.value.includes('contain')) objectFit = 'contain';
        if (e.target.value.includes('fill')) objectFit = 'fill';
        
        if (e.target.value.includes('top')) objectPosition = 'top';
        if (e.target.value.includes('bottom')) objectPosition = 'bottom';
        
        headerPhotoPreview.style.objectFit = objectFit;
        headerPhotoPreview.style.objectPosition = objectPosition;
        
        // Add Tailwind classes just in case
        classes.forEach(c => headerPhotoPreview.classList.add(c));
    });
}
</script>
@endsection
