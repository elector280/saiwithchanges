@extends('admin.layouts.master')

@section('css')
<style>
    .page-title {
        font-size: 22px;
        font-weight: 600;
        color: #3b3b3b;
        margin: 0;
    }

    .setting-card {
        border: 1px solid #e9ecef;
        border-radius: 6px;
        background: #fff;
    }

    .setting-label {
        font-size: 16px;
        font-weight: 500;
        color: #444;
        padding-top: 10px;
    }

    .setting-textarea {
        min-height: 260px;
        resize: vertical;
        font-family: monospace;
        font-size: 14px;
        line-height: 1.6;
    }

    .btn-update {
        padding: 10px 28px;
        border-radius: 4px;
    }
</style>
@endsection

@section('admin')

{{-- Page Header --}}
<div class="pt-3 container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">Google Analytics</h1>
    </div>
</div>

<div class="mt-3 container-fluid">

    {{-- Success Alert --}}
    @if(session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mr-1 icon fas fa-check"></i>
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

    {{-- Card --}}
    <div class="setting-card">
        <div class="p-4 card-body">

            <form action="{{ route('setting.sitemap.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Left Label --}}
                    <div class="col-md-3">
                        <div class="setting-label">Google Analytics</div>
                    </div>

                    {{-- Right Textarea --}}
                    <div class="col-md-9">
                        <textarea
                            name="google_analytics"
                            id="google_analytics"
                            class="form-control setting-textarea"
                            placeholder="Paste your google analytics here..."
                        >{{ old('google_analytics') ?? $setting->google_analytics }}</textarea>

                        @error('google_analytics')
                            <small class="mt-2 text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                {{-- Button Bottom Left (like image) --}}
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
