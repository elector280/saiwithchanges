@extends('admin.layouts.master')


@section('css')
<style>

</style>
@endsection

@section('admin')
@php 
$locale = Session::get('locale', config('app.locale'));
@endphp


<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Our value information</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Our value information</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="container-fluid">
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


    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Our value information</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                        Add value information
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered dataTable">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Title</th>
                    <th> Description </th>
                    <th> Image </th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($values as $key => $value)
                <tr>
                    <td>{{ $key + 1}}</td>
                    <td>{{ $value->title }}</td>
                    <td>{{ $value->description }}</td>
                    <td>
                        @if($value->image)
                            <img src="{{ asset('storage/value_image/'.$value->image) }}" style="height:40px;border-radius:6px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <form method="POST"  action="{{ route('values.destroy', $value->id) }}" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="bg-transparent border-0 p-0 shadow-none js-delete-btn"
                                        data-name="{{ $value->title ?? 'this item' }}">
                                    <i class="fas fa-trash text-danger mr-3"></i>
                                </button>
                            </form>

                            <button type="button"
                                    data-toggle="modal"
                                    data-target="#modal-lg-{{ $value->id }}"
                                    class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                                <i class="fas fa-edit text-success mr-3"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                
                <div class="modal fade" id="modal-lg-{{ $value->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body"> 
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Update value information</h3>
                                    </div>
                                    
                                    <form class="form-horizontal" method="POST" action="{{ route('values.update', $value->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="card-body">
                                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                            @if ($language->language_code === $locale)
                                                @php $code = $language->language_code; @endphp               
                                                <div class="form-group row">
                                                    <label for="title_{{ $code }}" class="col-sm-3 col-form-label">
                                                        Title ({{ $language->title }})
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" 
                                                            name="title[{{ $code }}]" 
                                                            placeholder="Enter Title  ({{ $language->title }})" 
                                                            id="title_{{ $code }}" 
                                                            class="form-control" 
                                                            value="{{ old('title.'.$code, $value->getDirectValue('title', $code)) }}" 
                                                            required>
                                                    </div>
                                                    @error('title.'.$code) 
                                                        <div class="invalid-feedback">{{ $message }}</div> 
                                                    @enderror
                                                </div>
                                                 @endif
                                            @endforeach

                                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                            @if ($language->language_code === $locale)
                                                @php $code = $language->language_code; @endphp
                                                <div class="form-group row">
                                                    <label for="description_{{ $code }}" class="col-sm-3 col-form-label">
                                                        Description ({{ $language->title }})
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <textarea name="description[{{ $code }}]" 
                                                                id="description_{{ $code }}" 
                                                                class="form-control" 
                                                                required 
                                                                placeholder="Enter Description  ({{ $language->title }})">{{ old('description.'.$code, $value->getDirectValue('description', $code)) }}</textarea>

                                                        @error('description.'.$code)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                 @endif
                                            @endforeach


                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 col-form-label">Image  </label>

                                                <div class="col-sm-6">
                                                    <input type="file"  name="image"  id="image"
                                                        class="form-control @error('image') is-invalid @enderror" >
                                                    @error('image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-sm-3">
                                                    @if(!empty($value?->image))
                                                        <img src="{{ asset('storage/value_image/'.$value->image) }}"  alt="Image"
                                                            style="height:40px; border-radius:6px;">
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-info">Save</button>
                                            <button type="button" class="btn btn-default float-right"  data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.card -->
        </div>
    </div>
</div>



<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create value information</h3>
                    </div>
                    
                    <form class="form-horizontal" method="POST" action="{{ route('values.store') }}" enctype="multipart/form-data">
                        @csrf 
                        <div class="card-body">
                             @foreach (App\Models\Language::where('active', 1)->get() as $language)
                             @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp                     
                            <div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label">Title  ({{ $language->title }})</label>
                                <div class="col-sm-9">
                                    <input type="text" name="title[{{ $code }}]" placeholder="Enter title  ({{ $language->title }})" id="title" class="form-control" required value="{{ old('title.' . $code) }}">
                                </div>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                             @endif
                            @endforeach

                             @foreach (App\Models\Language::where('active', 1)->get() as $language)
                             @if ($language->language_code === $locale)
                                @php $code = $language->language_code; @endphp       
                            <div class="form-group row">
                                <label for="description[{{ $code }}]" class="col-sm-3 col-form-label">Description  ({{ $language->title }})</label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" class="form-control" required placeholder="Enter value description  ({{ $language->title }})">{{ old('description.' . $code) }}</textarea>
                                </div>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                             @endif
                            @endforeach

                            <div class="form-group row">
                                <label for="image" class="col-sm-3 col-form-label">Company Logo</label>
                                <div class="col-sm-9">
                                    <input type="file" name="image" id="image" class="form-control" required>
                                </div>
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Save</button>
                            <button type="button" class="btn btn-default float-right"  data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection