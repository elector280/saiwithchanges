@extends('layouts.frontend.master')

@section('title')
    @if (!$settings)
    @else
        {{ $settings->company_name }}
    @endif
@endsection

@section('content')

<div class="container my-5">
    <section>
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
            <form method="GET" action="{{ url()->current() }}" class="w-100">
                <div class="row g-2">

                    {{-- Search --}}
                    <div class="col-12 col-md-3">
                        <input type="text" name="q" class="form-control"
                               placeholder="Search products..."
                               value="{{ request('q') }}">
                    </div>

                    {{-- Category --}}
                    <div class="col-12 col-md-2">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Min Price --}}
                    <div class="col-6 col-md-1">
                        <input type="number" name="min" class="form-control"
                               placeholder="Min"
                               value="{{ request('min') }}" min="0" step="1">
                    </div>

                    {{-- Max Price --}}
                    <div class="col-6 col-md-1">
                        <input type="number" name="max" class="form-control"
                               placeholder="Max"
                               value="{{ request('max') }}" min="0" step="1">
                    </div>

                    {{-- Sort --}}
                    <div class="col-12 col-md-2">
                        <select name="sort" class="form-select">
                            <option value="">Sort</option>
                            <option value="latest" {{ request('sort')=='latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price: Low</option>
                            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High</option>
                            <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                            <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-12 col-md-3 d-grid d-md-flex gap-2">
                        <button class="btn btn-primary w-100" type="submit">Apply</button>
                        <a class="btn btn-outline-secondary w-100" href="{{ url()->current() }}">Reset</a>
                    </div>

                </div>
            </form>
        </div>

        {{-- Optional: result count --}}
        <div class="text-muted mb-3">
            Showing <b>{{ $all_products->count() }}</b> of <b>{{ $all_products->total() }}</b> products
        </div>

        {{-- Products --}}
        <div class="row g-3">
            @forelse ($all_products as $product)
                @include('home.product_card')
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center mb-0">
                        No products found.
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination (keep filters) --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $all_products->appends(request()->query())->links() }}
        </div>
    </section>
</div>

@endsection
