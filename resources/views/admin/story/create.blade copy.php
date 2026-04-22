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
@endphp

<div class="container-fluid pt-3">

    <!-- Breadcrumb -->
    <div class="mb-3">
        <a href="{{ route('dashboard') }}">Dashboard</a> /
        <a href="{{ route('stories.index') }}">Blog posts</a> /
        <strong>Create</strong>
    </div>

    <div class="card shadow-sm" style="background-color: #F0F2F5;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="far fa-file-alt mr-1"></i> Add Blog Post
            </h3>

            <div class="card-tools d-flex align-items-center">
                @include('admin.layouts.locale')
                {{-- Page list button --}}
                <a href="{{ route('stories.index') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-list"></i> Report list
                </a>
            </div>
        </div>

        <form id="storyCreateForm" action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data">

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
                                    <h4 class="card-title mb-0 mr-2 label-color"><b class="label-color">Author, Project & Category</b></h4>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Project</label>
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
                                            <label>Report Content</label>
                                            <textarea name="description[{{ $langCode }}]" 
                                                    id="summernote_{{ $langCode }}" 
                                                    class="summernote form-control" 
                                                    placeholder="Report Content"
                                                    rows="5">{{ old('description.' . $langCode, $report->description[$langCode] ?? '') }}</textarea>
                                        </div>
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
                            @php
                                $defaultPaths = [
                                    'en' => 'report',   // বা story হলে 'report'
                                    'es' => 'informe',  // বা story হলে 'informe'
                                ];
                            @endphp
                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                @php
                                    $code = $language->language_code;
                                    $value = old('reportpath.' . $code) ?? ($defaultPaths[$code] ?? '');
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="req">URL path </label>
                                        <input type="text"
                                            name="reportpath[{{ $code }}]"
                                            value="{{ $value }}"
                                            class="form-control @error('reportpath.'.$code) is-invalid @enderror"
                                            placeholder="Report path "
                                            required>
                                        @error('reportpath.'.$code)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-green">Must be filled for {{ $language->title }}</small>
                                    </div>
                                </div>
                            @endforeach

                             @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                @php $code = $language->language_code; @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="req">URL </label>
                                        <input type="text" id="slug" name="slug[{{ $code }}]" value="{{ old('slug.' . $code) }}"
                                            class="form-control @error('slug.'.$code) is-invalid @enderror"
                                            placeholder="Project url " required>
                                        @error('slug.'.$code)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-green">
                                            Must be filled for {{ $language->title }}
                                        </small>
                                    </div>
                                </div>
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


                <div class="card">
                    <div class="card-header">
                        <h4>Media & status</h4>
                    </div> 
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <input type="file" name="image" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Featured Image SEO Url (Slug)</label>
                                    <input type="text" name="image_url" class="form-control" placeholder="e.g. sai-children" required>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Project Status</label>
                                    <select name="status" class="form-control">
                                        <option value="draft">draft</option>
                                        <option value="published">published</option>
                                    </select>
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
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position</label>
                                    <input type="number" name="position" class="form-control"  value="{{ old('position') }}"  placeholder="Enter position" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h4>Footer section</h4>
                    </div> 
                    <div class="card-body">
                        <div class="row">
                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                @if ($language->language_code === $locale)
                                    @php $code = $language->language_code; @endphp
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Footer title  </label>
                                            <input type="text" name="footer_title[{{ $code }}]" class="form-control" value="{{ old('footer_title.' . $code) }}">
                                        </div>
                                    </div>
                                @endif 
                            @endforeach

                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                @if ($language->language_code === $locale)
                                    @php $code = $language->language_code; @endphp
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Footer sub title  </label>
                                            <input type="text" name="footer_subtitle[{{ $code }}]" class="form-control" value="{{ old('footer_subtitle.' . $code) }}">
                                        </div>
                                    </div>
                                @endif 
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="button" id="previewBtn" class="btn btn-info">
                    <i class="fas fa-eye"></i> Preview
                </button>

                <button type="submit" id="realSubmitBtn" class="btn btn-primary d-none">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>

            @include('admin.story.story_preview_modal')
        </form>

    </div>
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
</script>
@endsection
