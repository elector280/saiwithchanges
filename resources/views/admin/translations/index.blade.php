@extends('admin.layouts.master')


@section('css')
<style>

</style>
@endsection

@section('admin')

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Translations</h1>
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
            <h3 class="card-title">Translations</h3>
            <div class="card-tools">
                <!-- <a href="{{ route('stories.create') }}" class="btn btn-md btn-success"> <i class="fas fa-plus"></i> Add Story</a> -->
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered nowrap dataTable">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Lang code </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>#</td>
                    <td>Key</td>
                    <td>Value </td>
                    <td>Lang code </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection