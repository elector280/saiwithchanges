@extends('admin.layouts.master')

@section('css')
<style>
</style> 
@endsection

@section('admin')

<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1 class="m-0">Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Category</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Category</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                            Add Category
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Parent Category</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Inactive Colors</th>
                                <th>Active Colors</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->parent ? $category->parent->name : '—' }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>

                                    <td>
                                        @php
                                            $inactiveTextColor = $category->text_color ?? '#111111';
                                            $inactivebgColor = $category->bg_color ?? '#ffffff';
                                        @endphp
                                        <div class="d-inline-flex align-items-center px-3 py-1 rounded"
                                             style="background-color:  {{ $inactivebgColor }}; color: {{ $inactiveTextColor }}; border: 1px solid {{ $inactiveTextColor }};">
                                            Inactive Preview
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $activeBgColor = $category->active_bg_color ?? '#000000';
                                            $activeTextColor = $category->active_text_color ?? '#ffffff';
                                        @endphp
                                        <div class="d-inline-flex align-items-center px-3 py-1 rounded"
                                             style="background-color: {{ $activeBgColor }}; color: {{ $activeTextColor }}; border: 1px solid {{ $activeTextColor }};">
                                            Active Preview
                                        </div>
                                    </td>

                                    <td>{{ $category->order }}</td>

                                    <td>
                                        <span class="badge {{ $category->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $category->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <form method="POST" action="{{ route('categoriesDestroy', $category->id) }}" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="bg-transparent border-0 p-0 shadow-none js-delete-btn"
                                                    data-name="{{ $category->name ?? 'this item' }}">
                                                <i class="fas fa-trash text-danger mr-3"></i>
                                            </button>
                                        </form>

                                        <button type="button"
                                                data-toggle="modal"
                                                data-target="#modal-lg-{{ $category->id }}"
                                                class="p-0 bg-transparent border-0 shadow-none focus:outline-none">
                                            <i class="mr-3 fas fa-edit text-success"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Edit Modal --}}
                                <div class="modal fade" id="modal-lg-{{ $category->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Update category</h3>
                                                    </div>

                                                    <form class="form-horizontal" method="POST" action="{{ route('updateCategory', $category->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="card-body">

                                                            {{-- Parent Category --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Parent</label>
                                                                <div class="col-sm-9">
                                                                    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
    <option value="">Select parent category</option>
    @foreach($parent_cats as $item)
        @if($item->id != $category->id)
            <option value="{{ $item->id }}"
                {{ (string) old('parent_id', $category->parent_id) === (string) $item->id ? 'selected' : '' }}>
                {{ $item->name }}
            </option>
        @endif
    @endforeach
</select>
                                                                    @error('parent_id')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Name --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Name</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                           name="name"
                                                                           placeholder="Enter name"
                                                                           value="{{ old('name', $category->name) }}"
                                                                           class="form-control @error('name') is-invalid @enderror"
                                                                           required>
                                                                    @error('name')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Background Color --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Background Color</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group my-colorpicker-bg">
                                                                        <input type="text"
                                                                               name="bg_color"
                                                                               value="{{ old('bg_color', $category->bg_color ?? '#ff5c5c') }}"
                                                                               class="form-control @error('bg_color') is-invalid @enderror"
                                                                               placeholder="#ff5c5c">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    @error('bg_color')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Text Color --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Text Color</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group my-colorpicker-text">
                                                                        <input type="text"
                                                                               name="text_color"
                                                                               value="{{ old('text_color', $category->text_color ?? '#ffffff') }}"
                                                                               class="form-control @error('text_color') is-invalid @enderror"
                                                                               placeholder="#ffffff">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    @error('text_color')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Active Background Color --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Active Background Color</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group my-colorpicker-active-bg">
                                                                        <input type="text"
                                                                               name="active_bg_color"
                                                                               value="{{ old('active_bg_color', $category->active_bg_color ?? $category->bg_color ?? '#000000') }}"
                                                                               class="form-control @error('active_bg_color') is-invalid @enderror"
                                                                               placeholder="#000000">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    @error('active_bg_color')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Active Text Color --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Active Text Color</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group my-colorpicker-active-text">
                                                                        <input type="text"
                                                                               name="active_text_color"
                                                                               value="{{ old('active_text_color', $category->active_text_color ?? '#ffffff') }}"
                                                                               class="form-control @error('active_text_color') is-invalid @enderror"
                                                                               placeholder="#ffffff">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    @error('active_text_color')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Slug --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Slug</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                           name="slug"
                                                                           placeholder="Enter slug"
                                                                           value="{{ old('slug', $category->slug) }}"
                                                                           class="form-control @error('slug') is-invalid @enderror">
                                                                    @error('slug')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Order --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Order</label>
                                                                <div class="col-sm-9">
                                                                    <input type="number"
                                                                           name="order"
                                                                           placeholder="Enter order"
                                                                           value="{{ old('order', $category->order) }}"
                                                                           class="form-control @error('order') is-invalid @enderror">
                                                                    @error('order')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Status --}}
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Status</label>
                                                                <div class="col-sm-9">
                                                                    <select name="status" class="form-control">
                                                                        <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>Active</option>
                                                                        <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="card-footer">
                                                            <button type="submit" class="btn btn-info">Save</button>
                                                            <button type="button" class="float-right btn btn-default" data-dismiss="modal">Close</button>
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
        </div>
    </div>
</div>


{{-- Create Modal --}}
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create category</h3>
                    </div>

                    <form class="form-horizontal" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            {{-- Parent --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Parent</label>
                                <div class="col-sm-9">
                                    <select name="parent_id" class="form-control">
                                        <option value="">Select parent category</option>
                                        @foreach($parent_cats as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" placeholder="Enter name" class="form-control" required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Slug</label>
                                <div class="col-sm-9">
                                    <input type="text" name="slug" placeholder="Enter slug" class="form-control" required>
                                </div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Background Color --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Background Color</label>
                                <div class="col-sm-9">
                                    <div class="input-group my-colorpicker-bg">
                                        <input type="text"
                                               name="bg_color"
                                               value="{{ old('bg_color', '#ff5c5c') }}"
                                               class="form-control @error('bg_color') is-invalid @enderror"
                                               placeholder="#ff5c5c">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                        </div>
                                    </div>
                                    @error('bg_color')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Text Color --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Text Color</label>
                                <div class="col-sm-9">
                                    <div class="input-group my-colorpicker-text">
                                        <input type="text"
                                               name="text_color"
                                               value="{{ old('text_color', '#ffffff') }}"
                                               class="form-control @error('text_color') is-invalid @enderror"
                                               placeholder="#ffffff">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                        </div>
                                    </div>
                                    @error('text_color')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Active Background Color --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Active Background Color</label>
                                <div class="col-sm-9">
                                    <div class="input-group my-colorpicker-active-bg">
                                        <input type="text"
                                               name="active_bg_color"
                                               value="{{ old('active_bg_color', '#000000') }}"
                                               class="form-control @error('active_bg_color') is-invalid @enderror"
                                               placeholder="#000000">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                        </div>
                                    </div>
                                    @error('active_bg_color')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Active Text Color --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Active Text Color</label>
                                <div class="col-sm-9">
                                    <div class="input-group my-colorpicker-active-text">
                                        <input type="text"
                                               name="active_text_color"
                                               value="{{ old('active_text_color', '#ffffff') }}"
                                               class="form-control @error('active_text_color') is-invalid @enderror"
                                               placeholder="#ffffff">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                        </div>
                                    </div>
                                    @error('active_text_color')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Order --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Order</label>
                                <div class="col-sm-9">
                                    <input type="number"
                                           name="order"
                                           placeholder="Enter order"
                                           value="{{ old('order') }}"
                                           class="form-control @error('order') is-invalid @enderror">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Save</button>
                            <button type="button" class="float-right btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
$(document).on('keyup', 'input[name="name"]', function () {
    let slug = $(this).val()
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');

    $(this).closest('form').find('input[name="slug"]').val(slug);
});
</script>

<script>
$(document).ready(function () {

    function initPicker($wrap) {
        if ($wrap.hasClass('cp-initialized')) return;

        $wrap.colorpicker({ format: 'hex' });

        const v = $wrap.find('input').val();
        if (v) $wrap.find('.fa-square').css('color', v);

        $wrap.on('colorpickerChange', function (event) {
            $wrap.find('.fa-square').css('color', event.color.toString());
        });

        $wrap.addClass('cp-initialized');
    }

    $('.my-colorpicker-bg, .my-colorpicker-text, .my-colorpicker-active-bg, .my-colorpicker-active-text').each(function () {
        initPicker($(this));
    });

    $(document).on('shown.bs.modal', '.modal', function () {
        const $modal = $(this);
        $modal.find('.my-colorpicker-bg, .my-colorpicker-text, .my-colorpicker-active-bg, .my-colorpicker-active-text').each(function () {
            initPicker($(this));
        });
    });

});
</script>

@endsection