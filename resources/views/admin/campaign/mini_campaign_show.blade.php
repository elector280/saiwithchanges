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
    .mc-content img {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection

@section('admin')

<div class="container-fluid pt-3">

    {{-- Breadcrumb --}}
    <div class="mb-3">
        <a href="">Dashboard</a> /
        <a href="{{ route('campaigns.miniCampaignIndex') }}">Mini Campaigns</a> /
        <strong>Details</strong>
    </div>

    <div class="row">

        {{-- LEFT CONTENT --}}
        <div class="col-lg-8">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-flag mr-1"></i> Mini Campaign Details
                    </h3>

                    <div class="card-tools">
                        @include('admin.layouts.locale')

                        <a href="{{ route('campaigns.miniCampaignEdit',  $minicampaign->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-edit"></i> Edit
                        </a> 

                        <a href="{{ route('campaigns.miniCampaignIndex') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-list"></i> List
                        </a>

                        <a href="{{ route('miniCampaign', $minicampaign->slug) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-eye"></i> View On page
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Title --}}
                    <h3 class="mb-3">{{ $minicampaign->title ?? '—' }}</h3>

                    {{-- Meta Info --}}
                    <div class="mb-3 text-muted small">
                        <span class="mr-3">
                            <i class="far fa-user"></i>
                            {{ $minicampaign->author->name ?? $minicampaign->user->name ?? 'Admin' }}
                        </span>

                        <span class="mr-3">
                            <i class="far fa-calendar"></i>
                            {{ !empty($minicampaign->start_date) ? \Carbon\Carbon::parse($minicampaign->start_date)->format('d M Y') : '' }}
                            @if(!empty($minicampaign->end_date))
                                - {{ \Carbon\Carbon::parse($minicampaign->end_date)->format('d M Y') }}
                            @endif
                        </span>

                    </div>

                    {{-- Featured Image --}}
                    @if(!empty($minicampaign->image))
                        <img src="{{ asset('storage/minicampaign_image/'.$minicampaign->image) }}"
                             class="img-fluid rounded mb-4"
                             style="max-height:300px;object-fit:cover;">
                    @endif

                    {{-- Short Description --}}
                    @if(!empty($minicampaign->short_description))
                    <h3>Description </h3>
                        <p class="lead">{{ $minicampaign->short_description }}</p>
                        <hr>
                    @endif

                    {{-- Content/Details --}}
                    <div class="mc-content">
                        <h3>Paragraph 1</h3>
                        {!! $minicampaign->paragraph_one ?? '<span class="text-muted">No description</span>' !!}
                    </div>
                    {{-- Content/Details --}}
                    <div class="mc-content">
                        <h3>Paragraph 2</h3>
                        {!! $minicampaign->paragraph_two ?? '<span class="text-muted">No description</span>' !!}
                    </div>
                    <div class="card-body">
    <div class="row">
        {{-- Cover Image --}}
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="border rounded p-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <span class="badge badge-info mr-2">
                        <i class="far fa-image mr-1"></i> Cover
                    </span>

                    @if(!empty($minicampaign->cover_image))
                        <a href="{{ asset('storage/cover_image/'.$minicampaign->cover_image) }}" target="_blank" class="d-inline-block">
                            <img
                                src="{{ asset('storage/cover_image/'.$minicampaign->cover_image) }}"
                                alt="Cover Image"
                                class="img-thumbnail"
                                style="height:300px;width:300px;object-fit:cover;border-radius:8px;">
                        </a>
                    @else
                        <span class="text-muted small">No cover image</span>
                    @endif
                </div>

                @if(!empty($minicampaign->cover_image))
                    <a href="{{ asset('storage/cover_image/'.$minicampaign->cover_image) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                @endif
            </div>
        </div>

        {{-- OG Image --}}
        <div class="col-md-6">
            <div class="border rounded p-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <span class="badge badge-success mr-2">
                        <i class="fas fa-share-alt mr-1"></i> OG
                    </span>

                    @if(!empty($minicampaign->og_image))
                        <a href="{{ asset('storage/og_image/'.$minicampaign->og_image) }}" target="_blank" class="d-inline-block">
                            <img
                                src="{{ asset('storage/og_image/'.$minicampaign->og_image) }}"
                                alt="OG Image"
                                class="img-thumbnail"
                                style="height:300px;width:300px;object-fit:cover;border-radius:8px;">
                        </a>
                    @else
                        <span class="text-muted small">No OG image</span>
                    @endif
                </div>

                @if(!empty($minicampaign->og_image))
                    <a href="{{ asset('storage/og_image/'.$minicampaign->og_image) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

                </div>
            </div>

        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="col-lg-4">

            {{-- Campaign Info --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Campaign Info
                    </h3>
                </div>

                <div class="card-body">

                    <div class="mb-2">
                        <span class="info-label">Status:</span>
                        @php
                            // status type adjust as needed: 'active/inactive' or 1/0
                            $status = $minicampaign->status ?? 0;
                            $isActive = ($status === 'active' || $status == 1);
                        @endphp
                        <span class="badge badge-{{ $isActive ? 'success' : 'secondary' }}">
                            {{ is_string($status) ? ucfirst($status) : ($isActive ? 'Active' : 'Inactive') }}
                        </span>
                    </div>


                    <div class="mb-2">
                        <span class="info-label">URL:</span><br>
                        <small class="info-value">{{ $minicampaign->slug ?? '-' }}</small>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">Call to action:</span><br>
                        <small class="info-value">{{ $minicampaign->view_project_url ?? '-' }}</small>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">Start Date:</span>
                        <span class="info-value">
                            {{ !empty($minicampaign->start_date) ? \Carbon\Carbon::parse($minicampaign->start_date)->format('d M Y') : '-' }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">End Date:</span>
                        <span class="info-value">
                            {{ !empty($minicampaign->end_date) ? \Carbon\Carbon::parse($minicampaign->end_date)->format('d M Y') : '-' }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">Created At:</span>
                        <span class="info-value">
                            {{ !empty($minicampaign->created_at) ? $minicampaign->created_at->format('d M Y') : '-' }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <span class="info-label">Updated At:</span>
                        <span class="info-value">
                            {{ !empty($minicampaign->updated_at) ? $minicampaign->updated_at->format('d M Y') : '-' }}
                        </span>
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
                        <div class="text-muted">{{ $minicampaign->seo_title ?? '-' }}</div>
                    </div>

                    <div class="mb-2">
                        <strong>Meta Description:</strong>
                        <div class="text-muted">{{ $minicampaign->meta_description ?? '-' }}</div>
                    </div>

                    <div>
                        <strong>Tags:</strong><br>
                        @if(!empty($minicampaign->tags))
                            @foreach(explode(',', $minicampaign->tags) as $tag)
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
