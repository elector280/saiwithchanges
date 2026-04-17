@extends('admin.layouts.master')


@section('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/summernote/summernote-bs4.min.css">
    <style>

    </style>
@endsection

@section('admin')

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Create campaign</h1>
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
        setTimeout(function () {
            $('#success-alert').alert('close');
        }, 5000);
    </script>
@endif


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create campaign</h3> 
            <div class="card-tools">
                <a href="{{ route('campaigns.create') }}" class="btn btn-md btn-success"> <i class="fas fa-list"></i> Campaign list</a>
            </div>
        </div>

        <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                <div class="row">

                    {{-- Title --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Project Title *</label>
                            <input type="text" name="title"
                                value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Logo --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hero_image">URL</label>
                            <input type="file" name="hero_image" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hero_image">Hero Image</label>
                            <input type="file" name="hero_image" class="form-control">
                        </div>
                    </div>

                    {{-- Logo Alt --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="footer_image">Footer Image</label>
                            <input type="file" name="footer_image" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gallery_image[]">Gallery Image (Multiple)</label>
                            <input type="file" name="gallery_image[]" class="form-control" multiple>
                        </div>
                    </div>


                    {{-- Subtitle --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sub_title">Subtitle</label>
                            <textarea name="sub_title" rows="3"
                                class="form-control">{{ old('sub_title') }}</textarea>
                        </div>
                    </div>

                    {{-- short description --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea name="short_description" rows="3"
                                class="form-control">{{ old('short_description') }}</textarea>
                        </div>
                    </div>

                    {{-- Summery --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="summery">Summery</label>
                            <textarea name="summery" rows="3" class="form-control">{{ old('summery') }}</textarea>
                        </div>
                    </div>

                    {{-- description --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="summernote" rows="5" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create
            </div>
        </form>


    </div>
</div>



@endsection


@section('js')

<!-- Summernote -->
<script src="{{ asset('backend-asset') }}/plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote({ height: 200 })

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
@endsection 