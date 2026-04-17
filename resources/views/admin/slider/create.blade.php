@extends('admin.layouts.master')


@section('css')
<style>

</style>
@endsection

@section('admin')
@php 
$locale = Session::get('locale', config('app.locale'));
@endphp

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Sliders</h1>
        <a href="{{ route('sliders.index') }}" class="btn btn-primary">
        <i class="fas fa-list"></i> Slider list
        </a>
    </div>
</div>

<div class="container-fluid mt-3">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Slider</h3>
            <div class="card-tools">
                @include('admin.layouts.locale')
            </div>
        </div>

       <div class="card-body">
            <form action="{{ route('sliders.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body"> 
                    <div class="row">
                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                        @php $langCode = $language->language_code;  @endphp
                        <div class="col-md-12">
                        <div class="form-group">
                                <label>Title ({{ $language->title }})</label>
                                <input type="text" name="title[{{ $langCode }}]" value="{{ old('title.' . $langCode) }}"
                                    class="form-control @error('title[{{ $langCode }}]') is-invalid @enderror" placeholder="Slider title ({{ $language->title }})">
                                @error('title[{{ $langCode }}]') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        @endif
                        @endforeach

                        <div class="col-md-12">
                        <div class="form-group">
                            <label>Background Image</label>
                            <input type="file" name="bg_image" class="form-control @error('bg_image') is-invalid @enderror" required>
                            @error('bg_image') <div class="text-danger small">{{ $message }}</div> @enderror

                            @if(!empty($slider?->bg_image))
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$slider->bg_image) }}" style="height:60px;border-radius:8px;">
                            </div>
                            @endif
                        </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        @if ($language->language_code === $locale)
                        @php $langCode = $language->language_code;  @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Button Text  ({{ $language->title }})</label>
                                <input type="text" name="btn_text[{{ $langCode }}]" value="{{ old('btn_text.' . $langCode) }}"
                                    class="form-control @error('btn_text[{{ $langCode }}]') is-invalid @enderror" placeholder="Enter button text here  ({{ $language->title }})">
                                @error('btn_text[{{ $langCode }}]') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        @endif
                        @endforeach

                        <div class="col-md-12">
                        <div class="form-group">
                            <label>Button Link</label>
                            <input type="text" name="btn_link" value="{{ old('btn_link', $slider->btn_link ?? '') }}"
                                class="form-control @error('btn_link') is-invalid @enderror" placeholder="https://... or /donate">
                            @error('btn_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        </div>

                        <div class="col-md-12">
                        <div class="form-group">
                            <label>Tax Line</label>
                            <input type="text" name="tax_line" value="{{ old('tax_line', $slider->tax_line ?? '') }}"
                                class="form-control @error('tax_line') is-invalid @enderror">
                            @error('tax_line') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        </div>
                    </div>

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                    @if ($language->language_code === $locale)
                        @php $langCode = $language->language_code;  @endphp
                    <div class="form-group">
                        <label>Subtitle  ({{ $language->title }})</label>
                        <textarea name="subtitle[{{ $langCode }}]" rows="3"
                        class="form-control @error('subtitle') is-invalid @enderror"
                        placeholder="Optional subtitle ({{ $language->title }})">{{ old('subtitle.' . $langCode) }}</textarea>
                        @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @endif
                    @endforeach

                    <div class="row">
                        <div class="col-md-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="statusCheck"
                            {{ old('status', $slider->status ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusCheck">Active</label>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
       </div>

    </div>
</div>

@endsection