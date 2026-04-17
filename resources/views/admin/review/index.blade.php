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
        <h1 class="m-0">Review information</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Review information</li>
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
                <h3 class="card-title">Review information</h3>
                <div class="card-tools">
                    @include('admin.layouts.locale')
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                        Add review information
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered nowrap dataTable">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Profile</th>
                    <th>Name</th>
                    <th> Description </th>
                    <th> Image </th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if($value->profile_image)
                            <img src="{{ asset('storage/review_image/'.$value->profile_image) }}" style="height:40px;border-radius:6px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>{{ $value->name }}</td>
                    <td>{{ Str::limit($value->description, 100) }}</td>
                    <td>
                        @if($value->image)
                            <img src="{{ asset('storage/review_image/'.$value->image) }}" style="height:40px;border-radius:6px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>

                        <form method="POST"  action="{{ route('reviews.destroy', $value->id) }}" class="d-inline delete-form">
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

                    </td>
                </tr>

                
                <div class="modal fade" id="modal-lg-{{ $value->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Update review information</h3>
                                    </div>
                                    
                                    <form class="form-horizontal" method="POST" action="{{ route('reviews.update', $value->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="card-body">                
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="name" placeholder="Enter name" id="name" class="form-control" value="{{ $value->name }}" required>
                                                </div>
                                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="form-group row">
                                                <label for="profile_image" class="col-sm-3 col-form-label">Profile </label>

                                                <div class="col-sm-6">
                                                    <input type="file"  name="profile_image"  id="profile_image"
                                                        class="form-control @error('profile_image') is-invalid @enderror"  >
                                                    @error('profile_image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-sm-3">
                                                    @if(!empty($value?->profile_image))
                                                        <img src="{{ asset('storage/review_image/'.$value->profile_image) }}"  alt="{{ $value->name }}"
                                                            style="height:40px; border-radius:6px;">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="image" class="col-sm-3 col-form-label">Image  </label>

                                                <div class="col-sm-6">
                                                    <input type="file"  name="image"  id="image"
                                                        class="form-control @error('image') is-invalid @enderror"  >
                                                    @error('image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-sm-3">
                                                    @if(!empty($value?->image))
                                                        <img src="{{ asset('storage/review_image/'.$value->image) }}"  alt="Image"
                                                            style="height:40px; border-radius:6px;">
                                                    @endif
                                                </div>
                                            </div>

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
                                                <label for="campaign_id" class="col-sm-3 col-form-label">Campaign</label>
                                                <div class="col-sm-9">
                                                    <select name="campaign_id" id="campaign_id" class="form-control" required>
                                                        <option value="" disabled>Select Campaign for donate</option>
                                                        @foreach($campaigns as $item)
                                                            <option value="{{ $item->id }}" {{ $item->id == $value->campaign_id ? 'selected' : ''}}>{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
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
                        <h3 class="card-title">Create review information</h3>
                    </div>
                    
                    <form class="form-horizontal" method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
                        @csrf 
                        <div class="card-body">                
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" placeholder="Enter name" id="name" class="form-control" required>
                                </div>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group row">
                                <label for="profile_image" class="col-sm-3 col-form-label">Profile</label>
                                <div class="col-sm-9">
                                    <input type="file" name="profile_image"  id="profile_image" class="form-control" required>
                                </div>
                                @error('profile_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>


                            <div class="form-group row">
                                <label for="image" class="col-sm-3 col-form-label">Image</label>
                                <div class="col-sm-9">
                                    <input type="file" name="image" id="image" class="form-control" required>
                                </div>
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            
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
                                <label for="image" class="col-sm-3 col-form-label">Campaign</label>
                                <div class="col-sm-9">
                                    <select name="campaign_id" id="campaign_id" class="form-control" required>
                                        <option value="" disabled>Select Campaign for donate</option>
                                        @foreach($campaigns as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
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