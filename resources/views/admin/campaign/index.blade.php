@extends('admin.layouts.master')


@section('css')
<style>

</style>
@endsection

@section('admin')

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pages</h1>
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
            <h3 class="card-title">Pages</h3>
            <div class="card-tools">
                @include('admin.layouts.locale')
                <a href="{{ route('campaigns.create') }}" class="btn btn-md btn-success"> <i class="fas fa-plus"></i> Add New</a>
                <a href="javascript:void(0)" id="bulkDeleteBtn" class="btn btn-md btn-danger">
                    <i class="fas fa-trash"></i> Bulk Delete
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered nowrap dataTable" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10px">
                                <input type="checkbox" id="checkAll">
                            </th>

                            <th>Sl</th>
                            <th>Project Image</th>
                            <th>Project Title</th>
                            <!--<th>Slug</th>-->
                            <th>Project Status</th>
                            <!-- <th> Footer Image </th> -->
                            <th>Project Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php $i = (($campaigns->currentPage() - 1) * $campaigns->perPage() + 1); ?>
                        @foreach($campaigns as $key => $value)
                        @php
                        $currentLocale = session('locale', config('app.locale'));
                                    $campaignPath = $currentLocale === 'es'
                                        ? ($value->getTranslation('path', 'es', false) ?: $value->getTranslation('path', 'en', false))
                                        : ($value->getTranslation('path', 'en', false) ?: $value->getTranslation('path', 'es', false));

                                    $campaignSlug = $currentLocale === 'es'
                                        ? ($value->getTranslation('slug', 'es', false) ?: $value->getTranslation('slug', 'en', false))
                                        : ($value->getTranslation('slug', 'en', false) ?: $value->getTranslation('slug', 'es', false));

                                    $campaignPath = is_string($campaignPath) ? trim($campaignPath) : '';
                                    $campaignSlug = is_string($campaignSlug) ? trim($campaignSlug) : '';

                                    $campaignUrl = null;

                                    if ($campaignPath !== '' && $campaignSlug !== '') {
                                        $campaignUrl = $currentLocale === 'es'
                                            ? route('campaignsdetailsEsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug])
                                            : route('campaignsdetailsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug]);
                                    }
                                @endphp
                        <tr>
                           <td width="10px">
                                <input type="checkbox" class="row-checkbox" value="{{ $value->id }}">
                            </td>
                            <td style="width: 30px; text-align: center;">
                                 {{$i++}}
                            </td>
                             <td>
                                @if($value->hero_image)
                                    <img src="{{ asset('storage/hero_image/'.$value->hero_image) }}" style="height:40px;border-radius:6px;">
                                    <!-- <img src="{{ asset('storage/hero_image/'.$value->hero_image) }}" style="height:40px;border-radius:6px;"> -->
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td><a href="{{ $campaignUrl }}" target="blanl">{{ $value->title }}</a></td>
                            <!--<td>{{ $value->slug }}</td>-->
                            <td>{{ $value->status }}</td>
                            <!-- <td>
                                @if($value->footer_image)
                                    <img src="{{ asset('storage/footer_image/'.$value->footer_image) }}" style="height:40px;border-radius:6px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td> -->
                            <td>
                                {{ $value->type }}
                            </td>
                            <td>
                                <form action="{{ route('campaigns.toggleStatus', $value) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="bg-transparent border-0 p-0 m-0 shadow-none focus:outline-none
                                                text-secondary hover:text-primary cursor-pointer"
                                            title="Toggle Status">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </form>


                                <a href="{{ route('campaigns.show', $value->id) }}" class="mr-3 ml-3"><i class="fas fa-eye"></i></a>
                                
                                <a href="{{ session('locale', config('app.locale')) === 'es' ? route('campaignsdetailsEsDyn', ['path' => $value->path, 'slug' => $value->slug]) : route('campaignsdetailsDyn', ['path' => $value->path, 'slug' => $value->slug]) }}" class="bg-transparent border-0 p-0 focus:outline-none shadow-none" title="View Live" target="_blank">
                                    <i class="fas fa-eye text-red mr-3"></i>
                                </a>
                                
                                <a href="{{ route('campaigns.edit', $value->id) }}" class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                                    <i class="fas fa-edit text-success mr-3"></i>
                                </a>

                                <form method="POST"
                                    action="{{ route('campaigns.destroy', $value->id) }}"
                                    class="d-inline delete-form">
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
            url: "{{ route('campaigns.bulk-delete') }}",
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