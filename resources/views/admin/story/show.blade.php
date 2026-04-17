@extends('admin.layouts.master')

@section('css')
<style>
    .info-label {
        font-weight: 600;
        color: #555;
    }
    .info-value {
        color: #222;
    }
    .story-content img {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection

@section('admin')

<div class="container-fluid pt-3">

    {{-- Breadcrumb --}}
    <div class="mb-3">
        <a href="{{ route('dashboard') }}">Dashboard</a> /
        <a href="{{ route('stories.index') }}">Blog Posts</a> /
        <strong>Details</strong>
    </div>

    <div class="row">

        {{-- LEFT CONTENT --}}
        <div class="col-lg-8">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-file-alt mr-1"></i> Blog Details
                    </h3>

                    <div class="card-tools">
                        @include('admin.layouts.locale')
                        <a href="{{ route('stories.edit', $story->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <a href="{{ route('stories.index') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-list"></i> Blog List
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Title --}}
                    <h3 class="mb-3">{{ $story->title }}</h3>

                    {{-- Meta Info --}}
                    <div class="mb-3 text-muted small">
                        <span class="mr-3">
                            <i class="far fa-user"></i>
                            {{ $story->author->name ?? 'Admin' }}
                        </span>

                        <span class="mr-3">
                            <i class="far fa-calendar"></i>
                            {{ $story->published_at ? \Carbon\Carbon::parse($story->published_at)->format('d M Y') : '' }}
                        </span>

                        <span>
                            <i class="fas fa-folder"></i>
                            {{ $story->campaign->title ?? 'General' }}
                        </span>
                    </div>

                    {{-- Featured Image --}}
                    @if($story->image)
                        <img src="{{ asset('storage/story_image/'.$story->image) }}"
                             class="img-fluid rounded mb-4"
                             style="max-height:300px;object-fit:cover;">
                    @endif

                    {{-- Short Description --}}
                    @if($story->short_description)
                        <p class="lead">{{ $story->short_description }}</p>
                        <hr>
                    @endif

                    {{-- Content --}}
                    <div class="story-content">
                        {!! $story->description !!}
                    </div>

                </div>
            </div>

        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="col-lg-4">

            {{-- Post Info --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Post Info
                    </h3>
                </div>

                <div class="card-body">

                    <div class="mb-2">
                        <span class="info-label">Status:</span>
                        <span class="badge badge-{{ $story->status == 'published' ? 'success' : 'secondary' }}">
                            {{ ucfirst($story->status) }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">Category:</span>
                        <span class="info-value">{{ $story->category->name ?? '-' }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">URL:</span><br>
                        <small class="info-value">{{ $story->slug }}</small>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">Created At:</span>
                        <span class="info-value">{{ $story->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">Updated At:</span>
                        <span class="info-value">{{ $story->updated_at->format('d M Y') }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">Published At:</span>
                        <span class="info-value">{{ $story->published_at }}</span>
                    </div>

                </div>
            </div>

            {{-- SEO Info --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-search"></i> SEO Info
                    </h3>
                </div>

                <div class="card-body">
                    <div class="mb-2">
                        <strong>SEO Title:</strong>
                        <div class="text-muted">{{ $story->seo_title }}</div>
                    </div>

                    <div class="mb-2">
                        <strong>Meta Description:</strong>
                        <div class="text-muted">{{ $story->meta_description }}</div>
                    </div>

                    <div>
                        <strong>Tags:</strong><br>
                        @if($story->tags)
                            @foreach(explode(',', $story->tags) as $tag)
                                <span class="badge badge-info mr-1">{{ trim($tag) }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">No tags</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
