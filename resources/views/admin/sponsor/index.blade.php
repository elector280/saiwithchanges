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
        <h1 class="m-0">Images </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Images </li>
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
                <h3 class="card-title">Images </h3>
                <div class="card-tools">
                    @include('admin.layouts.locale')
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                        Add new
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
                    <th>Sub Title</th>
                    <th>Company logo</th>
                    <th>Campaign icon</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sponsors as $key => $sponsor)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $sponsor->company_name }}</td>
                    <td>{{ $sponsor->sub_title }}</td>
                    <td>
                        @if($sponsor->company_logo)
                            <img src="{{ asset('storage/company_logo/'.$sponsor->company_logo) }}" style="height:40px;border-radius:6px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>
                        @if($sponsor->campaign_icon)
                            <img src="{{ asset('storage/campaign_icon/'.$sponsor->campaign_icon) }}" style="height:40px;border-radius:6px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST"  action="{{ route('sponsors.destroy', $sponsor->id) }}" class="d-inline delete-form">
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
                                data-target="#modal-lg-{{ $sponsor->id }}"
                                class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                            <i class="fas fa-edit text-success mr-3"></i>
                        </button>

                    </td>
                </tr>

                
                <div class="modal fade" id="modal-lg-{{ $sponsor->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Update information</h3>
                                    </div>
                                    
                                    <form class="form-horizontal" method="POST" action="{{ route('sponsors.update', $sponsor->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="card-body">
                                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                            @if ($language->language_code === $locale)
                                                @php $code = $language->language_code; @endphp                    
                                            <div class="form-group row">
                                                <label for="company_name" class="col-sm-3 col-form-label">Title ({{ $language->title }})</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="company_name[{{ $code }}]" placeholder="Enter company name or title" id="company_name" class="form-control" value="{{ old('company_name.' . $code, $sponsor->getDirectValue('company_name', $code)) }}" required>
                                                </div>
                                                @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            @endif 
                                            @endforeach

                                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                            @if ($language->language_code === $locale)
                                                @php $code = $language->language_code; @endphp    
                                            <div class="form-group row">
                                                <label for="sub_title" class="col-sm-3 col-form-label">Sub title ({{ $language->title }})</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="sub_title[{{ $code }}]" placeholder="Enter subtitle" id="sub_title" class="form-control" value="{{ old('sub_title.' . $code, $sponsor->getDirectValue('sub_title', $code)) }}" >
                                                </div>
                                                @error('sub_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            @endif 
                                            @endforeach

                                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                                            @if ($language->language_code === $locale)
                                                @php $code = $language->language_code; @endphp    
                                            <div class="form-group row">
                                                <label for="content" class="col-sm-3 col-form-label">Content ({{ $language->title }})</label>
                                                <div class="col-sm-9">
                                                    <textarea name="content[{{ $code }}]" id="" class="form-control" placeholder="Enter content">{{ old('content.' . $code, $sponsor->getDirectValue('content', $code)) }}</textarea>
                                                </div>
                                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            @endif 
                                            @endforeach

                                            <div class="form-group row">
                                                <label for="website_link" class="col-sm-3 col-form-label">Website link</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="website_link" placeholder="https:\\www.example.com" id="website_link" class="form-control" value="{{ $sponsor->website_link }}">
                                                </div>
                                                @error('website_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="form-group row">
                                                <label for="type" class="col-sm-3 col-form-label">Image Type</label>
                                                <div class="col-sm-9">
                                                    <select name="type" id="" class="form-control">
                                                        <option value="" disabled></option>
                                                        <option value="sponsors" {{ $sponsor->type == 'sponsors' ? 'selected' : ''}}>Sponsors</option>
                                                        <option value="certifications" {{ $sponsor->type == 'certifications' ? 'selected' : ''}}>Certifications</option>
                                                    </select>
                                                </div>
                                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="form-group row">
                                                <label for="company_logo" class="col-sm-3 col-form-label"> Company Logo  </label>

                                                <div class="col-sm-6">
                                                    <input type="file"  name="company_logo"  id="company_logo"
                                                        class="form-control @error('company_logo') is-invalid @enderror">
                                                    @error('company_logo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-sm-3">
                                                    @if(!empty($sponsor?->company_logo))
                                                        <img src="{{ asset('storage/company_logo/'.$sponsor->company_logo) }}"  alt="Company Logo"
                                                            style="height:40px; border-radius:6px;">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="campaign_icon" class="col-sm-3 col-form-label"> Company Logo  </label>

                                                <div class="col-sm-6">
                                                    <input type="file"  name="campaign_icon"  id="campaign_icon"
                                                        class="form-control @error('campaign_icon') is-invalid @enderror">
                                                    @error('campaign_icon')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-sm-3">
                                                    @if(!empty($sponsor?->campaign_icon))
                                                        <img src="{{ asset('storage/campaign_icon/'.$sponsor->campaign_icon) }}"  alt="Company Logo"
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
                        <h3 class="card-title">Create information</h3>
                    </div> 
                    
                    <form class="form-horizontal" method="POST" action="{{ route('sponsors.store') }}" enctype="multipart/form-data">
                        @csrf 
                        <div class="card-body">    
                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                    @php $code = $language->language_code; @endphp            
                                <div class="form-group row">
                                    <label for="company_name" class="col-sm-3 col-form-label">Title ({{ $language->title }})</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="company_name[{{ $code }}]" value="{{ old('company_name.' . $code) }}" placeholder="Enter company name or title" id="company_name" class="form-control" required>
                                    </div>
                                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                @endif 
                            @endforeach

                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                    @php $code = $language->language_code; @endphp    
                            <div class="form-group row">
                                <label for="sub_title" class="col-sm-3 col-form-label">Sub title ({{ $language->title }})</label>
                                <div class="col-sm-9">
                                    <input type="text" name="sub_title[{{ $code }}]" value="{{ old('sub_title.' . $code) }}" placeholder="Enter subtitle" id="sub_title" class="form-control">
                                </div>
                                @error('sub_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            @endif 
                            @endforeach

                            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            @if ($language->language_code === $locale)
                                    @php $code = $language->language_code; @endphp    
                            <div class="form-group row">
                                <label for="content" class="col-sm-3 col-form-label">Content ({{ $language->title }})</label>
                                <div class="col-sm-9">
                                    <textarea name="content[{{ $code }}]" id="" class="form-control" placeholder="Enter content">{{ old('content.' . $code) }}</textarea>
                                </div>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            @endif 
                            @endforeach

                            <div class="form-group row">
                                <label for="website_link" class="col-sm-3 col-form-label">Website link</label>
                                <div class="col-sm-9">
                                    <input type="text" name="website_link" placeholder="https:\\www.example.com" id="website_link" class="form-control" value="" required>
                                </div>
                                @error('website_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div> 

                            <div class="form-group row">
                                <label for="type" class="col-sm-3 col-form-label">Image Type</label>
                                <div class="col-sm-9">
                                    <select name="type" id="" class="form-control" required>
                                        <option value="" disabled>Secetd type</option>
                                        <option value="sponsors">Sponsors</option>
                                        <option value="certifications">Certifications</option>
                                    </select>
                                </div>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group row">
                                <label for="company_logo" class="col-sm-3 col-form-label">Company Logo</label>
                                <div class="col-sm-9">
                                    <input type="file" name="company_logo" id="company_logo" class="form-control" required>
                                </div>
                                @error('company_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group row">
                                <label for="campaign_icon" class="col-sm-3 col-form-label">Campaign Icon (Optional)</label>
                                <div class="col-sm-9">
                                    <input type="file" name="campaign_icon" id="campaign_icon" class="form-control">
                                </div>
                                @error('campaign_icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
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