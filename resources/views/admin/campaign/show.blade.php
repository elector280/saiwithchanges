@extends('admin.layouts.master')

@section('css')
<style>
    .section-title{
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 10px;
        margin-bottom: 6px;
        font-size: 13px;
    }
    .info-label text-md font-weight-bold{
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 4px;
    }
    .content-box{
        border: 1px solid #e9ecef;
        border-radius: .25rem;
        padding: 12px;
        background: #fff;
        min-height: 60px;
    }
    .thumb{
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: .25rem;
        border: 1px solid #e9ecef;
    }
    .badge-status{
        font-size: 12px;
        padding: .35rem .55rem;
    }
</style>
@endsection

@section('admin')
<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">View Page</h4>
            <small class="text-muted">Dashboard / Pages / View</small>
        </div>
        <div>
             @include('admin.layouts.locale')
            <a href="{{ route('campaigns.index') }}" class="btn btn-sm btn-success">
                <i class="fas fa-list"></i> Page list
            </a>
            <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>

<div class="container-fluid mt-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="icon fas fa-check mr-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title mb-0 font-weight-bold">
                <i class="far fa-file-alt mr-1"></i> {{ $campaign->title ?? '—' }}
            </h3>

            @php
                $status = $campaign->status ?? 'draft';
                $badge = match($status){
                    'published' => 'badge-success',
                    'archived' => 'badge-dark',
                    default => 'badge-secondary',
                };
            @endphp

            <span class="badge badge-status {{ $badge }}">
                {{ strtoupper($status) }}
            </span>
        </div>

        <div class="card-body">

            {{-- Basic Info --}}
            <div class="row">
                <div class="col-md-8 mb-2">
                    <div class="info-label text-md font-weight-bold">Project Title</div>
                    <div class="content-box">{{ $campaign->title ?? '—' }}</div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="info-label text-md font-weight-bold">URL</div>
                    <div class="content-box">
                        @if(!empty($campaign->slug))
                            <a href="{{ $campaign->slug }}" target="_blank" rel="noopener">
                                {{ $campaign->slug }}
                            </a>
                        @else
                            —
                        @endif
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="info-label text-md font-weight-bold">Type</div>
                    <div class="content-box">{{ $campaign->type ?? '—' }}</div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="info-label text-md font-weight-bold">Project Status</div>

                    <div class="content-box">
                        @if($campaign->status === 'published')
                            <span class="badge badge-success">Published</span>

                        @elseif($campaign->status === 'draft')
                            <span class="badge badge-warning">Draft</span>

                        @elseif($campaign->status === 'archive')
                            <span class="badge badge-secondary">Archive</span>

                        @else
                            <span class="badge badge-light">—</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="info-label text-md font-weight-bold">Color</div>

                    <div class="content-box" style="background-color: {{ $campaign->bg_color }};">
                        {{ $campaign->bg_color ?? '—' }}
                    </div>
                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-12 mb-2">
                     {{-- Project Summary --}}
                    <div class="info-label text-md font-weight-bold">Sub TItle</div>
                    <div class="content-box">
                        {{ $campaign->sub_title ?? '—' }}
                    </div>
                </div>
                <div class="col-12 mb-2">
                
                    {{-- Project Summary --}}
                    <div class="info-label text-md font-weight-bold">Project Summary</div>
                    <div class="content-box">
                        {!! $campaign->summary ?? '—' !!}
                    </div>
                </div>
               
                
                <div class="col-12 mb-2">
                    {{-- STANDARD WEBPAGE CONTENT --}}
                    <div class="section-title mt-4">STANDARD WEBPAGE CONTENT</div>

                    <div class="info-label text-md font-weight-bold">Standard Webpage Content</div>
                    <div class="content-box">
                        {!! $campaign->standard_webpage_content ?? '—' !!}
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="info-label text-md font-weight-bold mt-3">What is the problem?</div>
                    <div class="content-box">
                        {!! $campaign->problem ?? '—' !!}
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="info-label text-md font-weight-bold mt-3">How will this project solve the problem?</div>
                    <div class="content-box">
                        {!! $campaign->solution ?? '—' !!}
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="info-label text-md font-weight-bold mt-3">Potential Long term impact</div>
                    <div class="content-box">
                        {!! $campaign->impact ?? '—' !!}
                    </div>
                </div>
            </div>
            

            {{-- GOOGLE --}}
            <div class="section-title mt-4">GOOGLE</div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="info-label text-md font-weight-bold">GOOGLE Description</div>
                    <div class="content-box">{{ $campaign->google_description ?? '—' }}</div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="info-label text-md font-weight-bold">Short description of project</div>
                    <div class="content-box">{{ $campaign->short_description ?? '—' }}</div>
                </div>
            </div>

            {{-- Media --}}
            <div class="section-title mt-4">MEDIA</div>

            <div class="row">
                <div class="col-md-4">
                    <div class="info-label text-md font-weight-bold">Project Photo</div>
                    <div class="content-box">
                        @if(!empty($campaign->hero_image))
                            <a href="{{ asset('storage/hero_image/'.$campaign->hero_image) }}" target="_blank">
                                <img class="thumb" src="{{ asset('storage/hero_image/'.$campaign->hero_image) }}" alt="Project Photo">
                            </a> 
                        @else
                            —
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-label text-md font-weight-bold mt-3">Gallery</div>
            <div class="content-box">
              

                @if($campaign->galleryImages?->count())
                    <div class="row">
                        @foreach($campaign->galleryImages as $img)
                            <div class="col-md-2 mb-3">
                                <a href="{{ asset('storage/gallery_image/'.$img->image) }}" target="_blank">
                                    <img class="thumb" src="{{ asset('storage/gallery_image/'.$img->image) }}" alt="Gallery Image">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    —
                @endif
            </div>

            {{-- Donorbox & Video --}}
            <div class="section-title mt-4">EMBED</div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="info-label text-md font-weight-bold">Donorbox code</div>
                    <div class="content-box">
                        @if(!empty($campaign->donorbox_code))
                            <code style="white-space: pre-wrap;">{!! $campaign->donorbox_code !!}</code>
                        @else
                            —
                        @endif
                    </div>
                </div>


                <div class="col-md-6 mb-2">
                    <div class="info-label text-md font-weight-bold">Video</div>
                    <div class="content-box">
                        @if(!empty($campaign->video))
                            {{-- যদি embed html হয়, render; আর যদি link হয়, link দেখাবে --}}
                            @if(str_contains($campaign->video, '<iframe') || str_contains($campaign->video, '<video'))
                                {!! $campaign->video !!}
                            @else
                                ---
                            @endif
                        @else
                            —
                        @endif
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="info-label text-md font-weight-bold">Seo title</div>
                    <div class="content-box">
                        @if(!empty($campaign->seo_title))
                            <code style="white-space: pre-wrap;">{!! $campaign->seo_title !!}</code>
                        @else
                            —
                        @endif
                    </div>
                </div>

                <div class="col-md-6 mb-2">
                    <div class="info-label text-md font-weight-bold">Seo description</div>
                    <div class="content-box">
                        @if(!empty($campaign->seo_description))
                            <code style="white-space: pre-wrap;">{!! $campaign->seo_description !!}</code>
                        @else
                            —
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <div>
                <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
