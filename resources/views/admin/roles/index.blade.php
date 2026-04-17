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
        <h1 class="m-0">Roles</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Roles</li>
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
                <h3 class="card-title">Roles</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                        Add Roles
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered nowrap dataTable">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Guard</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $key => $role)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        {{ $role->guard_name }}
                    </td>
                    <td>
                         <form method="POST"  action="{{ route('roles.destroy', $role->id) }}" class="d-inline delete-form">
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
                                data-target="#modal-lg-{{ $role->id }}"
                                class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                            <i class="fas fa-edit text-success mr-3"></i>
                        </button>

                    </td>
                </tr>

                
                <div class="modal fade" id="modal-lg-{{ $role->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Create role</h3>
                                    </div>
                                    
                                    <form class="form-horizontal" method="POST" action="{{ route('roles.update', $role->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="card-body">                
                                            <div class="form-group row">
                                                <label for="nane" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                <input type="text" name="name" placeholder="Name" id="name" class="form-control" value="{{ $role->name }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row mt-3">
                                                <label class="col-sm-2 col-form-label">Permissions</label>

                                                <div class="col-sm-10">
                                                    <div class="border rounded bg-light p-3">
                                                        <small class="text-muted d-block mb-2">
                                                            Select permissions for this role
                                                        </small>

                                                        @php
                                                            $oldPermissions = old('permission', []);

                                                            if (!empty($oldPermissions) && old('role_id') == $role->id) {
                                                                $selectedPermissions = array_keys($oldPermissions);
                                                            } else {
                                                                $selectedPermissions = $role->permissions->pluck('id')->toArray();
                                                            }
                                                        @endphp

                                                        <div class="row">
                                                            @foreach($permission as $value)
                                                                <div class="col-6 col-md-4 mb-2">
                                                                    <div class="custom-control custom-checkbox permission-pill">
                                                                        <input
                                                                            type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="perm-{{ $role->id }}-{{ $value->id }}"
                                                                            name="permission[{{ $value->id }}]"
                                                                            value="{{ $value->id }}"
                                                                            @checked(in_array($value->id, $selectedPermissions))
                                                                        >
                                                                        <label class="custom-control-label"
                                                                            for="perm-{{ $role->id }}-{{ $value->id }}">
                                                                            {{ $value->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
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
                        <h3 class="card-title">Create role</h3>
                    </div>
                    
                    <form class="form-horizontal" method="POST" action="{{ route('roles.store') }}">
                        @csrf 
                        <div class="card-body">                
                            <div class="form-group row">
                                <label for="nane" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                <input type="text" name="name" placeholder="Name" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Permission:</label>

                                <div class="col-sm-10">
                                    <div class="border rounded bg-light p-3">
                                        <small class="text-muted d-block mb-2">
                                            Select permissions for this role
                                        </small>

                                        <div class="row">
                                            @foreach($permission as $value)
                                                <div class="col-6 col-md-4 mb-2">
                                                    <div class="custom-control custom-checkbox permission-pill">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            id="perm-{{ $value->id }}"
                                                            name="permission[{{ $value->id }}]"
                                                            value="{{ $value->id }}"
                                                        >
                                                        <label class="custom-control-label" for="perm-{{ $value->id }}">
                                                            {{ $value->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
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