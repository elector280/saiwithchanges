@extends('layouts.frontend.master')

@section('title')
    {{ $subcategory->name }}
@endsection

@section('content')
    <div class="container text-center mt-4 mb-5">
        <h1 class="mb-5">{{ $subcategory->name }}</h1>

        <div class="row">
            @foreach ($filteredBySubCategoryProducts as $product)
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body bg-light">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }}</p>
                            <div class="text-center">
                                <button class="btn btn-sm btn-outline-success">Add to Cart</button>
                                <button class="btn btn-sm btn-danger">Buy Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
