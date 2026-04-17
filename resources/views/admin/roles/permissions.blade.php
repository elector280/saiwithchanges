@extends('admin.layouts.master')


@section('css')
<style>

</style>
@endsection

@section('admin')

<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Permission</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Permission</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permission</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                        Add Permission
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered dataTable">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Guard</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $key => $permission)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        {{ $permission->guard_name }}
                    </td>
                    <td>
                        <form method="POST"  action="{{ route('permissions.destroy', $permission->id) }}" class="d-inline delete-form">
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
                                data-target="#modal-lg-{{ $permission->id }}"
                                class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                            <i class="fas fa-edit text-success mr-3"></i>
                        </button>
                    </td>
                </tr>

                <div class="modal fade" id="modal-lg-{{ $permission->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Update Permission</h3>
                                    </div>
                                    
                                    <form class="form-horizontal" method="POST" action="{{ route('permissions.update', $permission->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="card-body">                
                                            <div class="form-group row">
                                                <label for="nane" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                <input type="text" name="name" placeholder="Name" id="name" class="form-control" value="{{ $permission->name }}" required>
                                                </div>
                                            </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-info">Update</button>
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
                        <h3 class="card-title">Create Permission</h3>
                    </div>
                    
                    <form class="form-horizontal" method="POST" action="{{ route('permissions.store') }}">
                        @csrf 
                        <div class="card-body">                
                            <div class="form-group row">
                                <label for="nane" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                <input type="text" name="name" placeholder="Name" id="name" class="form-control" required>
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

@endsection