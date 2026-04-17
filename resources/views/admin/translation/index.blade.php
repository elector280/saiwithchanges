@extends('admin.layouts.master')


@section('css')
<style>

</style>
@endsection

@section('admin')
    <br>
    <section>
        <div class="container">
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
                <div class="card-header bg-card">
                    <div class="card-title">Create Translationn</div>
                </div>
                <div class="card-body w3-light-gray">
                    <form action="{{ route('admin.translationStore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row py-2">
                            <div class="col-md-6 m-auto card p-5">
                                <div class="form-group">
                                    <label for="description">Key</label>
                                    <input type="text" class="form-control" name="lang_key" placeholder="lang key" required>
                                    @error('lang_key')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Value</label>
                                    <input type="text" class="form-control" name="lang_value" placeholder="lang value" required>
                                </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary float-right" value="Save">
                            </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>


@endsection 