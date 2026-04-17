@extends('admin.layouts.master')

@section('admin')
<section class="content-header">
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h1 class="m-0">Gallery</h1>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Gallery Editor</li>
        </ol>
      </div>

      <form class="d-flex" method="GET" action="{{ route('campaign.gallery.index') }}">
        <div class="input-group input-group-sm" style="width: 260px;">
          <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search campaign...">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
    @endif

    <div class="row">
      @foreach($campaigns as $campaign)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="card card-outline card-danger">
            <div class="card-body p-2">
              <div style="height:160px; overflow:hidden; border-radius:4px;">
                <!-- <img src="{{ asset('storage/hero_image/'.$campaign->hero_image) }}" style="width:100%; height:160px; object-fit:cover;" alt=""> -->
                    <img src="{{ asset('storage/hero_image/'.$campaign->hero_image) }}"
                    style="width:100%; height:160px; object-fit:cover;"
                    alt="{{ $campaign->title }}" title="{{ $campaign->title }}"> 
              </div> 

              <div class="mt-2">
                <div class="font-weight-bold text-truncate" title="{{ $campaign->title }}">
                  {{ $campaign->title }}
                </div>
                <small class="text-muted">ID: {{ $campaign->id }}</small>
              </div>

              <a href="{{ route('campaign.gallery.edit', $campaign) }}"
                 class="btn btn-danger btn-block btn-sm mt-2">
                EDIT PROJECT GALLERY
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="d-flex justify-content-center">
    {{ $campaigns->links('pagination::bootstrap-4') }}
    </div>

  </div>
</section>
@endsection
