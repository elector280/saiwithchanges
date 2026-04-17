@extends('layouts.frontend.master')

@section('title')
    {{ $title }}
@endsection

@section('content')
    {{-- Products Section --}}
    <div class="container text-center mt-4 mb-5">
        <h1 class="mb-5">{{ $title }}</h1>

        <div class="row">
            @forelse ($filteredProducts as $product)
                 @include('home.product_card')
            @empty
                <p>No products found for this Category.</p>
            @endforelse
        </div>
    </div>
@endsection
