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
                <a href="#" class="btn btn-md btn-success"> <i class="fas fa-plus"></i> Add Pages</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>Project Title</th>
                    <th>Created At</th>
                    <th>Project Photo</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>#</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <i class="fas fa-eye ml-2"></i>
                        <i class="fas fa-edit ml-2"></i>
                        <i class="fas fa-trash ml-2"></i>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection