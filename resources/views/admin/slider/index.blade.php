@extends('admin.layouts.master')


@section('css')
<style>

</style>
@endsection

@section('admin')

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Sliders</h1>
        <a href="{{ route('sliders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Slider
        </a>
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
    <h3 class="card-title">Slider List</h3>
    <div class="card-tools">
        @include('admin.layouts.locale')
    </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered nowrap dataTable">
            <thead>
                <th>#</th>
                <th>Preview</th>
                <th>Title</th>
                <th>Status</th>
                <th class="text-right">Action</th>
            </thead>
            <tbody>
            @forelse($sliders as $key => $slider)
            <tr>
                <td>{{ $sliders->firstItem() + $key }}</td>
                <td>
                    @if($slider->bg_image)
                    <img src="{{ asset('storage/sliders/'.$slider->bg_image) }}" style="height:40px;border-radius:6px;">
                    @else
                    <span class="text-muted">No image</span>
                    @endif
                </td>
                <td>{{ $slider->localeTitle('en') }}</td>
                <td>
                    @if($slider->status)
                    <span class="badge badge-success">Active</span>
                    @else
                    <span class="badge badge-secondary">Inactive</span>
                    @endif
                </td>
                <td class="text-right">
                    <form action="{{ route('sliders.toggleStatus',$slider) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="mr-2 bg-transparent border-0 p-0 m-0 shadow-none focus:outline-none
                                    text-secondary hover:text-primary cursor-pointer"
                                title="Toggle Status">
                            <i class="fas fa-sync"></i>
                        </button>
                    </form>

                    <a href="{{ route('sliders.edit',$slider) }}" class="mr-2">
                    <i class="fas fa-edit"></i>
                    </a>

                    <form method="POST"  action="{{ route('sliders.destroy',$slider) }}" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="bg-transparent border-0 p-0 shadow-none js-delete-btn"
                                data-name="{{ $value->title ?? 'this item' }}">
                            <i class="fas fa-trash text-danger mr-3"></i>
                        </button>
                    </form>

                </td>
            </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No sliders found</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
    {{ $sliders->links() }}
    </div>
</div>
</div>

@endsection