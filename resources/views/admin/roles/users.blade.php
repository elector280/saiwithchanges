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
        <h1 class="m-0">User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">User</li>
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
            setTimeout(function () { $('#success-alert').alert('close'); }, 5000);
        </script>
    @endif
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                        Add User
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
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $key => $user)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->phone }}
                    </td>
                    <td>
                        {{ $user->getRoleNames()->first() }}
                    </td>
                    <td>
                         <form method="POST"  action="{{ route('users.destroy', $user->id) }}" class="d-inline delete-form">
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
                                data-target="#modal-lg-{{ $user->id }}"
                                class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                            <i class="fas fa-edit text-success mr-3"></i>
                        </button>
                    </td>
                </tr>

                <div class="modal fade" id="modal-lg-{{ $user->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Update User</h3>
                                    </div>
                                    
                                    <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="card-body">                
                                            <div class="form-group row">
                                                <label for="nane" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                <input type="text" name="name" placeholder="Name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                <input type="text" name="email" placeholder="Email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                                <div class="col-sm-10">
                                                <input type="text" name="phone" placeholder="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="role_id" class="col-sm-2 col-form-label">Role</label>
                                                <div class="col-sm-10">
                                                    <select name="role_id" id="role_id" class="form-control" required>
                                                        <option value="">Select role</option>
                                                        @foreach($roles as $role)
                                                        <option value="{{ $role->id  }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>                                                
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Password</label>

                                                <div class="col-sm-10">
                                                    <div class="input-group password-toggle">
                                                        <input
                                                            type="password"
                                                            name="password"
                                                            placeholder="password"
                                                            class="form-control password-input"
                                                            id="password" required
                                                        >
                                                        <div class="input-group-append">
                                                            <button type="button"
                                                                    class="btn btn-outline-secondary toggle-password-btn">
                                                                <i class="fas fa-eye toggle-password-icon"></i>
                                                            </button>
                                                        </div>
                                                    </div>
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
                        <h3 class="card-title">Create User</h3>
                    </div>
                    
                    <form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
                        @csrf 
                        <div class="card-body">                
                            <div class="form-group row">
                                <label for="nane" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                <input type="text" name="name" placeholder="Name" id="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                <input type="text" name="email" placeholder="Email" id="email" class="form-control" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                <input type="text" name="phone" placeholder="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role_id" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <select name="role_id" id="role_id" class="form-control" >
                                        <option value="">Select role</option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>                                                
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>

                                <div class="col-sm-10">
                                    <div class="input-group password-toggle">
                                        <input
                                            type="password"
                                            name="password"
                                            placeholder="password"
                                            class="form-control password-input"
                                            id="password" required
                                        >
                                        <div class="input-group-append">
                                            <button type="button"
                                                    class="btn btn-outline-secondary toggle-password-btn">
                                                <i class="fas fa-eye toggle-password-icon"></i>
                                            </button>
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // প্রতিটি password-toggle গ্রুপের জন্য আলাদা listener
        document.querySelectorAll('.password-toggle').forEach(function (wrapper) {
            const input = wrapper.querySelector('.password-input');
            const btn   = wrapper.querySelector('.toggle-password-btn');
            const icon  = wrapper.querySelector('.toggle-password-icon');

            if (!input || !btn) return;

            btn.addEventListener('click', function () {
                const isHidden = input.getAttribute('type') === 'password';

                input.setAttribute('type', isHidden ? 'text' : 'password');

                if (icon) {
                    icon.classList.toggle('fa-eye', !isHidden);
                    icon.classList.toggle('fa-eye-slash', isHidden);
                }
            });
        });
    });
</script>

@endsection