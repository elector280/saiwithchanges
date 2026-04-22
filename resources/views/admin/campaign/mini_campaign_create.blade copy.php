@extends('admin.layouts.master')

@section('title', 'Mini Campaign Template Create')

@section('css')
    <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/summernote/summernote-bs4.min.css">

    <style>
        .note-editor.note-frame { border-radius: .25rem; }
        .note-editor .note-editing-area { min-height: 180px; }
        .req::after{ content:" *"; color:#dc3545; font-weight:700; }
        .lang-box{ border:1px solid #e9ecef; border-radius:.5rem; padding:14px; margin-bottom:14px; }
    </style>
    
@endsection

@section('admin')
@php
    $locale = Session::get('locale', config('app.locale'));
    $languages = App\Models\Language::where('active', 1)->get();
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

            <a href="javascript:void(0)" class="btn btn-sm btn-dark mb-2 mb-md-0 previewBtn w3-round-large">
                <i class="far fa-eye mr-1"></i> Preview
            </a>
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

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Fix the errors below.</strong>
        </div>
    @endif

        <form id="miniCampaignForm" action="{{ route('campaigns.miniCampaignStore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                <div class="card">
                     <div class="card-header seo-card-header">
                        <div class="d-flex align-items-start">
                            <div class="seo-icon-box mr-3">
                                <i class="far fa-file-alt w-4"></i>
                            </div>

                            <div class="seo-header-content">
                                <div class="d-flex align-items-center flex-wrap">
                                    <h4 class="card-title mb-0 mr-2 label-color"><b class="label-color">Campaign Settings</b></h4>
                                    <span class="seo-lang">EN</span>
                                </div>
                                <small class="seo-subtitle mb-0 label-color">
                                    Status, CTA link, scheduling, and cover image — shared across all languages
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Publication Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status','1')=='1' ? 'selected' : '' }}>Published</option>
                                        <option value="0" {{ old('status')=='0' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                    <small class="seo-subtitle mb-0 label-color">
                                        Only Published mini campaigns are publicly visible.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Urgency Tag</label>
                                    <input type="text" name="tag_line" value="{{ old('tag_line') }}" class="form-control" placeholder="facebook">
                                    <small class="seo-subtitle mb-0 label-color">
                                        A short badge label shown on the campaign card to create urgency. Leave blank to hide.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="req">View Project URL — CTA Link</label>
                                    <input type="url"
                                        name="view_project_url"
                                        value="{{ old('view_project_url') }}"
                                        class="form-control @error('view_project_url') is-invalid @enderror"
                                        placeholder="https://yourdomain.com/projects/slug"
                                        required>
                                    @error('view_project_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <small class="seo-subtitle mb-0 label-color">
                                    The destination URL when a visitor clicks the "View Project" call-to-action button on this mini campaign.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="seo-divider">
                            <span>SCHEDULING</span>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date & Time</label>
                                    <input type="datetime-local"
                                        name="start_date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}">
                                    @error('start_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <small class="seo-subtitle mb-0 label-color">
                                    The date and time this campaign becomes visible.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date & Time</label>
                                    <input type="datetime-local"
                                        name="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}">
                                    @error('end_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    <small class="seo-subtitle mb-0 label-color">
                                    The campaign will automatically hide after this date and time.
                                    </small>
                                </div>
                            </div>

                        </div>
                        <div class="seo-divider">
                            <span>Cover Image</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cover Image</label>
                                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                                    @error('cover_image') <div class="text-danger small">{{ $message }}</div> @enderror
                                    <small class="seo-subtitle mb-0 label-color">
                                    Hero image displayed at the top of the mini campaign page. Recommended: 1200×630 px.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>OG Image (Optional)</label>
                                    <input type="file" name="og_image" class="form-control" accept="image/*">
                                    @error('og_image') <div class="text-danger small">{{ $message }}</div> @enderror
                                    <small class="seo-subtitle mb-0 label-color">
                                    Overrides the image shown when this page is shared on Facebook, Twitter, and WhatsApp. If
                                    blank, the cover image is used.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                     <div class="card-header seo-card-header">
                        <div class="d-flex align-items-start">
                            <div class="seo-icon-box mr-3">
                                <i class="far fa-file-alt w-4"></i>
                            </div>

                            <div class="seo-header-content">
                                <div class="d-flex align-items-center flex-wrap">
                                    <h4 class="card-title mb-0 mr-2 label-color"><b class="label-color">Content & Copy</b></h4>
                                    <span class="seo-lang">EN</span>
                                </div>
                                <small class="seo-subtitle mb-0 label-color">
                                    Title, slug, donation widget, and campaign body copy - English version
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row  mb-3">
                             @foreach($languages as $language)
                                @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                            <div class="col-12 col-md-6">
                                <label class="req">Campaign Title</label>
                                <input type="text"
                                    name="title[{{ $code }}]"
                                    value="{{ old('title.'.$code) }}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="e.g. Donate to Help Venezuela"
                                    required>
                                <small class="text-muted">The main headline shown at the top of this mini campaign page.</small>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="req">URL Slug</label>
                                <input type="text"
                                    name="slug[{{ $code }}]"
                                    value="{{ old('slug.'.$code) }}"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    placeholder="e.g. sai-donate-help-venezuela-en"
                                    required>
                                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Used to build the page URL. Lowercase, hyphenated, no spaces.</small>
                            </div>
                        </div>

                        <div class="seo-divider">
                            <span>SEO Short Description (Above the fold)</span>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12 mb-3">
                                <label class="req">SEO Short Description</label>
                                <textarea name="short_description[{{ $code }}]"
                                        rows="3"
                                        class="form-control summernote @error('short_description.'.$code) is-invalid @enderror"
                                        placeholder="Short SEO description ({{ $language->title }})"
                                        >{{ old('short_description.'.$code) }}</textarea>
                                @error('short_description.'.$code) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="callout callout-info mt-3 mb-0">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-file-alt text-info"></i>
                                        </div>
                                        <div class="mb-0">
                                            This text appears at the very top of the page, before the visitor scrolls. Keep it punchy and compelling - ideally 1-3 sentences that explain the cause and invite action.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="seo-divider">
                            <span>Body Copy</span>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-3">
                                <label class="req">Paragraph One  ({{ $language->title }})</label>
                                <textarea name="paragraph_one[{{ $code }}]"
                                        class="form-control summernote @error('paragraph_one.'.$code) is-invalid @enderror"
                                        >{{ old('paragraph_one.'.$code) }}</textarea>
                                @error('paragraph_one.'.$code) <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="req">Paragraph Two  ({{ $language->title }})</label>
                                <textarea name="paragraph_two[{{ $code }}]"
                                        class="form-control summernote @error('paragraph_two.'.$code) is-invalid @enderror"
                                        >{{ old('paragraph_two.'.$code) }}</textarea>
                                @error('paragraph_two.'.$code) <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                         @endif
                        @endforeach
                        </div>

                        <div class="seo-divider">
                            <span>Donation Widget</span>
                        </div>

                        <div class="row">
                            @foreach($languages as $language)
                                @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp
                                <div class="col-12 col-md-12 mb-3">
                                    <label class="req">Donation Box Embed</label>
                                    <textarea name="donation_box[{{ $code }}]"
                                            class="form-control summernote @error('donation_box.'.$code) is-invalid @enderror"
                                            >{{ old('donation_box.'.$code) }}</textarea>
                                    @error('donation_box.'.$code) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <small class="text-muted d-block">
                                        Paste the mini campaign donation box iframe embed code. Example:
                                        <code>&lt;iframe src="..."&gt;&lt;/iframe&gt;</code>
                                    </small>
                                </div>
                                @endif
                        @endforeach
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header seo-card-header">
                        <div class="d-flex align-items-start">
                            <div class="seo-icon-box mr-3">
                                <i class="far fa-file-alt w-4"></i>
                            </div>

                            <div class="seo-header-content">
                                <div class="d-flex align-items-center flex-wrap">
                                    <h4 class="card-title mb-0 mr-2 label-color"><b class="label-color">SEO & Social Sharing</b></h4>
                                    <span class="seo-lang">EN</span>
                                </div>
                                <small class="seo-subtitle mb-0 label-color">
                                    Meta tags, Open Graph, keywords, and canonical URL — English version
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                             @foreach($languages as $language)
                                @if ($language->language_code === $locale)
                                    @php $code = $language->language_code; @endphp
                            <div class="col-12 col-md-6">
                                <label>Meta Title</label>
                                <textarea
                                    name="meta_title[{{ $code }}]"
                                    id="meta_title_{{ $code }}"
                                    class="form-control"
                                    rows="1"
                                    placeholder="Meta title shown in search results..."
                                >{{ old('meta_title.'.$code) }}</textarea>

                                <div class="d-flex justify-content-between align-items-center mt-2 seo-note-wrap">
                                    <small class="seo-help-text">
                                        Recommended: 50–60 characters • Appears as the clickable headline in Google.
                                    </small>
                                    <small class="seo-count-text font-weight-bold mb-0">
                                        <span id="meta_title_count_{{ $code }}">0</span> / 60
                                    </small>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Meta Keywords</label>
                                <input type="text" name="meta_keywords[{{ $code }}]" value="{{ old('meta_keywords.'.$code) }}" class="form-control" placeholder="keyword1, keyword2">
                                <small class="text-muted">Comma-separated keywords. Not a major ranking factor but used for internal tagging.</small>
                            </div>

                            <div class="col-12 col-md-12 mt-3">
                                <label>Meta Description</label>
                                <textarea
                                    name="meta_description[{{ $code }}]"
                                    id="meta_description_{{ $code }}"
                                    rows="2"
                                    class="form-control"
                                    placeholder="Enter meta description"
                                >{{ old('meta_description.'.$code) }}</textarea>

                                <div class="callout callout-info mt-3 mb-0">
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
                                    <small class="font-weight-bold mb-0">
                                        <span id="meta_description_count_{{ $code }}">0</span> / 160
                                    </small>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>

                        <div class="seo-divider">
                            <span>Open Graph — Social Sharing</span>
                        </div>

                        <div class="row">
                            @foreach($languages as $language)
                                @if ($language->language_code === $locale)
                                    @php $code = $language->language_code; @endphp
                                <div class="col-12 col-md-6">
                                    <label>OG Title</label>
                                    <input type="text" name="og_title[{{ $code }}]" value="{{ old('og_title.'.$code) }}" class="form-control" placeholder="Title shown when shared on social media...">
                                    <small class="text-muted">
                                        Overrides the page title when shared on Facebook, Twitter, WhatsApp. If blank, falls back to Meta Title.
                                    </small>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Canonical URL</label>
                                    <input type="url" name="canonical_url[{{ $code }}]" value="{{ old('canonical_url.'.$code) }}" class="form-control" placeholder="https://sai.ngo/mini/campaign-slug">
                                    <small class="text-muted">
                                        Overrides the page title when shared on Facebook, Twitter, WhatsApp. If blank, falls back to Meta Title.
                                    </small>
                                </div>

                                <div class="col-12 col-md-12 mt-3">
                                    <label>OG Description</label>
                                    <textarea name="og_description[{{ $code }}]" rows="3" class="form-control" placeholder="Description shown when this page is shared on social media...">{{ old('og_description.'.$code) }}</textarea>
                                    <div class="callout callout-info mt-3 mb-0">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="fas fa-file-alt text-info"></i>
                                            </div>
                                            <div class="mb-0">
                                                This text appears in social media share previews on Facebook, Twitter, LinkedIn, and WhatsApp. Aim for 100–200 characters — something compelling that makes people want to click.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer text-right">
                <a href="{{ route('campaigns.miniCampaignIndex') }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> Discard Changes
                </a>

                <button type="button" id="previewBtn" class="btn btn-info previewBtn">
                    <i class="fas fa-eye"></i> Preview
                </button>

                <button type="submit" id="realSubmitBtn" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save & Publish
                </button>
            </div>

             @include('admin.canpaign.minicampaign_preview')
        </form>

    </div>
</div>






@endsection

@section('js')
<script src="{{ asset('backend-asset') }}/plugins/summernote/summernote-bs4.min.js"></script>
<script src="{{ asset('backend-asset') }}/summernote-custom-input.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("textarea[id^='meta_title_']").forEach(function (textarea) {
            let code = textarea.id.replace('meta_title_', '');
            let counter = document.getElementById('meta_title_count_' + code);

            function updateCount() {
                let length = textarea.value.length;
                counter.textContent = length;

                counter.classList.remove('text-success', 'text-warning', 'text-danger');

                if (length >= 50 && length <= 60) {
                    counter.classList.add('text-success');
                } else if ((length >= 40 && length < 50) || (length > 60 && length <= 70)) {
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
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("textarea[id^='meta_description_']").forEach(function (textarea) {
            let code = textarea.id.replace('meta_description_', '');
            let counter = document.getElementById('meta_description_count_' + code);

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
    const locale = @json($locale);

    // ✅ Preview
    $('.previewBtn').on('click', function(e){
        e.preventDefault();

        const title = $(`input[name="title[${locale}]"]`).val() || '';
        const slug  = $(`input[name="slug[${locale}]"]`).val() || '';
        const cta   = $('input[name="view_project_url"]').val() || '';

        const short = $(`textarea[name="short_description[${locale}]"]`).summernote('code') || '';
        const p1    = $(`textarea[name="paragraph_one[${locale}]"]`).summernote('code') || '';
        const p2    = $(`textarea[name="paragraph_two[${locale}]"]`).summernote('code') || '';

        const metaTitle = $(`input[name="meta_title[${locale}]"]`).val() || '';
        const metaDesc  = $(`textarea[name="meta_description[${locale}]"]`).val() || '';
        const ogTitle   = $(`input[name="og_title[${locale}]"]`).val() || '';
        const ogDesc    = $(`textarea[name="og_description[${locale}]"]`).val() || '';
        const canonical = $(`input[name="canonical_url[${locale}]"]`).val() || '';

        const status = $('select[name="status"]').val() || '';
        const start  = $('input[name="start_date"]').val() || '';
        const end    = $('input[name="end_date"]').val() || '';

        // Fill modal
        $('#pvTitle').text(title);
        $('#pvSlug').text(slug);

        if (cta) {
            const safeCta = /^https?:\/\//i.test(cta) ? cta : ('https://' + cta);
            $('#pvCta').text(safeCta).attr('href', safeCta).show();
        } else {
            $('#pvCta').text('N/A').attr('href', '#');
        }

        $('#pvShort').html(short);
        $('#pvP1').html(p1);
        $('#pvP2').html(p2);

        $('#pvMetaTitle').text(metaTitle);
        $('#pvMetaDesc').text(metaDesc);
        $('#pvOgTitle').text(ogTitle);
        $('#pvOgDesc').text(ogDesc);
        $('#pvCanonical').text(canonical);

        $('#pvStatus').text(status == '1' ? 'Published' : 'Draft');
        $('#pvStart').text(start);
        $('#pvEnd').text(end);

        // Cover preview
        const coverInput = $('input[name="cover_image"]')[0];
        if (coverInput && coverInput.files && coverInput.files[0]) {
            const r = new FileReader();
            r.onload = (ev) => {
                $('#pvCoverImg').attr('src', ev.target.result).show();
                $('#pvCoverEmpty').hide();
            };
            r.readAsDataURL(coverInput.files[0]);
        } else {
            $('#pvCoverImg').hide();
            $('#pvCoverEmpty').show();
        }

        // OG preview
        const ogInput = $('input[name="og_image"]')[0];
        if (ogInput && ogInput.files && ogInput.files[0]) {
            const r2 = new FileReader();
            r2.onload = (ev) => {
                $('#pvOgImg').attr('src', ev.target.result).show();
                $('#pvOgEmpty').hide();
            };
            r2.readAsDataURL(ogInput.files[0]);
        } else {
            $('#pvOgImg').hide();
            $('#pvOgEmpty').show();
        }

        $('#previewModal').modal('show');
    });

    // ✅ Confirm Save
    $('#confirmSave').on('click', function(e){
        e.preventDefault();

        // sync summernote -> textarea
        $('.summernote').each(function () {
            $(this).val($(this).summernote('code'));
        });

        // prevent double click
        $('#confirmSave').prop('disabled', true);

        // submit ONLY this form
        document.getElementById('miniCampaignForm').submit();
    });

});
</script>
@endsection
