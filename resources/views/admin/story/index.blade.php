@extends('admin.layouts.master')


@section('css')
<style>

</style>
@endsection

@section('admin')

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Blog Posts</h1>
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
            <h3 class="card-title">Blog Posts</h3>
            <div class="card-tools">
                @include('admin.layouts.locale')
                <a href="{{ route('stories.create') }}" class="btn btn-md btn-success"> <i class="fas fa-plus"></i> Add new</a>
                <a href="javascript:void(0)" id="bulkDeleteBtn" class="btn btn-md btn-danger">
                    <i class="fas fa-trash"></i> Bulk Delete
                </a>
            </div>
        </div>
       <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable nowrap" style="width:100%">
                    <thead>
                            <th width="10px">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>#</th>
                            <th>Title</th>
                            <th>Featured Image</th>
                            <th>Project status</th>
                            <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($stories as $value)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox" value="{{ $value->id }}"></td>
                            <td style="width: 30px; text-align: center;">
                               {{ $loop->iteration }}
                            </td>
                            <!-- <td>
                                @if(!empty($value->campaign_id))
                                <a href="{{ route('campaigns.show', $value->campaign_id) }}" class="btn btn-sm btn-primary">
                                    {{ $value->campaign_id }}
                                </a>
                                @endif
                            </td> -->
                            <td title="{{ $value->title }}">
                                <a href="{{ session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $value->slug) : route('blogDetails', $value->slug) }}" target="_blank">
                                    {{ \Illuminate\Support\Str::limit($value->title, 50, '') }}
                                </a>
                            </td>
                            <td>
                                @if($value->image)
                                    <img src="{{ asset('storage/story_image/'.$value->image) }}" style="height:40px;border-radius:6px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $value->status }}</td>
                            <td>
                                <form action="{{ route('story.toggleStatus', $value) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="bg-transparent border-0 p-0 m-0 shadow-none focus:outline-none
                                                text-secondary hover:text-primary cursor-pointer"
                                            title="Toggle Status">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </form>
                                
                                <a href="{{ route('stories.show', $value->id) }}" class="bg-transparent border-0 p-0 focus:outline-none shadow-none" title="Show on backend">
                                    <i class="fas fa-eye text-success mr-3 ml-3"></i>
                                </a>
                                
                                <a href="{{ session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $value->slug) : route('blogDetails', $value->slug) }}" class="bg-transparent border-0 p-0 focus:outline-none shadow-none" title="View Live" target="_blank">
                                    <i class="fas fa-eye text-red mr-3"></i>
                                </a>

                                <a href="{{ route('stories.edit', $value->id) }}" class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                                    <i class="fas fa-edit text-success mr-3"></i>
                                </a>


                                <form method="POST"  action="{{ route('stories.destroy', $value->id) }}" class="d-inline delete-form">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection






@section('js')



<script>
$(document).ready(function () {

    // ✅ Select All
    $('#checkAll').on('click', function () {
        $('.row-checkbox').prop('checked', this.checked);
    });

    // ✅ Uncheck select all if any unchecked
    $(document).on('click', '.row-checkbox', function () {
        if (!$(this).prop('checked')) {
            $('#checkAll').prop('checked', false);
        }
    });

    // ✅ Bulk delete
    $('#bulkDeleteBtn').on('click', function () {

        let ids = [];

        $('.row-checkbox:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            alert('Please select at least one item.');
            return;
        }

        if (!confirm('Are you sure you want to delete selected items?')) {
            return;
        }

        $.ajax({
            url: "{{ route('stories.bulk-delete') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ids: ids
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });

});
</script>

@endsection 