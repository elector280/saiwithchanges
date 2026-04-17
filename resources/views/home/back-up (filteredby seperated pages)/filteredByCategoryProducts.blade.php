@extends('layouts.frontend.master')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    <!-- Sub-Catagories marquee Start -->
    <div class="container-fluid mt-4">
        <div class="container-fluid text-center">
            <h1 class="mb-5">Sub-Categories</h1>
        </div>
        <marquee class="mt-2" scrollamount="10" width="100%" direction="left" height="220px">
            <div class="d-flex">
                @foreach ($subcategories as $subcategory)
                    <a href="{{ route('home.filteredBySubCategoryProducts', str_replace(' ', '-', $subcategory->name)) }}"
                        class="text-decoration-none">
                        <div class="text-center mx-4">
                            <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}"
                                class="img-thumbnail rounded-circle object-fit-cover mb-2"
                                style="width: 150px; height: 150px;">
                            <div class="fw-bold fs-5 text-dark">{{ $subcategory->name }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </marquee>
    </div>
    <!-- Sub-Catagories marquee End -->


    <div class="container text-center mb-5">
        <h1 class="mb-5">{{ $category->name }}</h1>

        <div class="row">
            @foreach ($filteredByCategoryProducts as $product)
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
