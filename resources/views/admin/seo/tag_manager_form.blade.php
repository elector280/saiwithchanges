@extends('admin.layouts.master')

@section('css')
<style>
    .page-title{
        font-size: 22px;
        font-weight: 600;
        color:#3b3b3b;
        margin:0;
    }
    .setting-card{
        border:1px solid #e9ecef;
        border-radius:6px;
        background:#fff;
    }
    .setting-label{
        font-size:16px;
        font-weight:500;
        color:#444;
        padding-top:10px;
        white-space: nowrap;
    }
    .setting-textarea{
        min-height: 260px;
        resize: vertical;
        font-family: monospace;
        font-size: 14px;
        line-height: 1.6;
    }
    .btn-update{
        padding: 10px 28px;
        border-radius: 4px;
    }
</style>
@endsection

@section('admin')

{{-- Header --}}
<div class="pt-3 container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">Tag Manager</h1>
    </div>
</div>

<div class="mt-3 container-fluid">

    @if(session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mr-1 icon fas fa-check"></i> {{ session('success') }}
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

    {{-- Card --}}
    <div class="setting-card">
        <div class="p-4 card-body">

            <form action="{{ route('setting.sitemap.update', $setting->id) }}" method="POST">
                @csrf

                <div class="row">
                    {{-- Left label --}}
                    <div class="col-md-3">
                        <div class="setting-label">Tag Manager Code for Home</div>
                    </div>

                    {{-- Right textarea --}}
                    <div class="col-md-9">
                        <textarea
                            name="tag_manager"
                            id="tag_manager"
                            class="form-control setting-textarea"
                            placeholder="Paste Google Tag Manager code here..."
                        >
                        {{ old('tag_manager') ?? $setting->tag_manager }}
                    </textarea>

                        @error('tag_manager')
                            <small class="mt-2 text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    {{-- Left label --}}
                    <div class="col-md-3">
                        <div class="setting-label">Tag Manager Code For Body</div>
                    </div>

                    {{-- Right textarea --}}
                    <div class="col-md-9">
                        <textarea
                            name="google_tag_manager_body"
                            id="google_tag_manager_body"
                            class="form-control setting-textarea"
                            placeholder="Paste Google Tag Manager code here..."
                        >
                        {{ old('google_tag_manager_body') ?? $setting->google_tag_manager_body }}
                    </textarea>

                        @error('google_tag_manager_body')
                            <small class="mt-2 text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                {{-- Button bottom left --}}
                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary btn-update">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
