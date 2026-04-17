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
    .btn-action{
        padding: 10px 28px;
        border-radius: 4px;
        margin-right: 10px;
    }
</style>
@endsection

@section('admin')

<div class="pt-3 container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">Sitemap Management</h1>
    </div>
</div>

<div class="mt-3 container-fluid">

    {{-- Success Message --}}
    @if(session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>

        <script>
            setTimeout(function () {
                $('#success-alert').alert('close');
            }, 4000);
        </script>
    @endif

    <div class="setting-card">
        <div class="p-4 card-body">

            {{-- View --}}
            <div class="mb-3">
                <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn btn-primary btn-action">
                    View Sitemap
                </a>
            </div>

            {{-- Generate --}}
            <form action="{{ route('admin.sitemap.generate') }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-success btn-action">
                    Generate Sitemap
                </button>
            </form>

            {{-- Upload --}}
            <form action="{{ route('setting.sitemap.update', $setting->id ?? 1) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                @csrf

                <div class="form-group">
                    <label><strong>Upload Sitemap (XML)</strong></label>
                    <input type="file" name="sitemap_file" class="form-control" accept=".xml" required>
                </div>

                <button type="submit" class="btn btn-warning btn-action">
                    Upload Sitemap
                </button>
            </form>

            {{-- Current Status --}}
            @php
                $setting = \App\Models\WebsiteSetting::first();
            @endphp

            @if(!empty($setting?->sitemap_file))
                <div class="mt-3">
                    <strong>Current Active Sitemap:</strong>
                    <span class="text-success">{{ $setting->sitemap_file }}</span>
                </div>
            @else
                <div class="mt-3 text-muted">
                    No uploaded sitemap found. System is using generated sitemap.
                </div>
            @endif

        </div>
    </div>
</div>

@endsection