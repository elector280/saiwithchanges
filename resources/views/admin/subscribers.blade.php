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
        <h1 class="m-0">Subscribers</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Subscribers</li>
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
                <h3 class="card-title">Subscribers</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered nowrap dataTable">
                <thead>
                <tr>
                    <th style="width: 10px">SL</th>
                    <th>Email</th>
                    <th>Subscribed</th>
                    <th>Subscribed</th>
                    <th>Unsubscribed</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscribers as $key => $subscriber)
                <tr>
                    <td>{{ $subscriber->id }}</td>
                    <td>{{ $subscriber->email }}</td>
                    <td>
                        @if($subscriber->is_subscribed == 1)
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle mr-1"></i>
                                Subscribed
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-times-circle mr-1"></i>
                                Unsubscribed
                            </span>
                        @endif
                    </td>
                    <td>{{ $subscriber->subscribed_at }}</td>
                    <td>{{ $subscriber->unsubscribed_at }}</td>
                    <td>

                        <form method="POST"  action="{{ route('subscribers.destroy', $subscriber->id) }}" class="d-inline delete-form">
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
        <!-- /.card -->
        </div>
    </div>
</div>

@endsection