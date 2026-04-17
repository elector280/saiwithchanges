@extends('layouts.frontend.master')

@section('title')
    @if (!$settings)
    @else
        {{ $settings->company_name }}
    @endif
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Hero Carousel Start -->
           <div class="col-12">
  <div id="carouselExample"
       class="carousel slide"
       data-bs-ride="carousel"
       data-bs-interval="3000"
       data-bs-pause="false"
       data-bs-touch="true">

    <div class="carousel-inner">
      @foreach ($sliders as $slider)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
          <img src="{{ asset($slider->image) }}"
               class="d-block w-100"
               style="height:500px; object-fit:cover;"
               alt="Slider image">
        </div>
      @endforeach
    </div>

    <!-- Controls (bottom) -->
    <!-- <button class="carousel-control-prev carousel-bottom-btn" type="button"
            data-bs-target="#carouselExample" data-bs-slide="prev" aria-label="Previous">
      <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next carousel-bottom-btn" type="button"
            data-bs-target="#carouselExample" data-bs-slide="next" aria-label="Next">
      <span class="carousel-control-next-icon"></span>
    </button> -->

    <!-- (Optional) Indicators নিচে চাইলে -->
    <div class="carousel-indicators carousel-bottom-indicators">
      @foreach ($sliders as $slider)
        <button type="button"
                data-bs-target="#carouselExample"
                data-bs-slide-to="{{ $loop->index }}"
                class="{{ $loop->first ? 'active' : '' }}"
                aria-current="{{ $loop->first ? 'true' : 'false' }}"
                aria-label="Slide {{ $loop->iteration }}"></button>
      @endforeach
    </div>

  </div>
</div>

            <!-- Hero Carousel End -->
        </div>
    </div>

    <!-- Catagories marquee Start -->
   <div class="container mt-5">
        <div class="cat-marquee">
            <div class="cat-track">
                {{-- 1st copy --}}
                @foreach ($categories as $category)
                    <a href="{{ route('home.filteredProducts', $category->id) }}"
                      class="cat-chip">
                        <span class="cat-chip__dot"></span>
                        <span class="cat-chip__text">{{ $category->name }}</span>
                        <span class="cat-chip__arrow">&rsaquo;</span>
                    </a>
                @endforeach

                {{-- 2nd copy (for seamless loop) --}}
                @foreach ($categories as $category)
                    <a href="{{ route('home.filteredProducts', $category->id) }}"
                      class="cat-chip">
                        <span class="cat-chip__dot"></span>
                        <span class="cat-chip__text">{{ $category->name }}</span>
                        <span class="cat-chip__arrow">&rsaquo;</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Categories marquee End -->

    <!-- Products Card carousel grouped by category Start -->
        <div class="container text-center my-5">
            <section id="">
                <h1 class="mb-4">Best Selling Products</h1>

                <div class="row g-3">
                    @foreach ($best_sellings as $product)
                      @include('home.product_card')
                    @endforeach
                </div>
            </section>
        </div>

        <div class="container text-center my-5">
            <section id="">
                <h1 class="mb-4">Featured Products</h1>

                <div class="row g-3">
                    @foreach ($features_products as $product)
                        @include('home.product_card')
                    @endforeach
                </div>
            </section>
        </div>

        <div class="container text-center my-5">
            <section id="">
                <h1 class="mb-4">New Arrival Products</h1>

                
                <div class="row g-3">
                    @foreach ($new_arrivals as $product)
                         @include('home.product_card')
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Products Card carousel grouped by category End -->

        <style>
            .same-banner {
                width: 100%;
                height: 260px;          /* চাইলে height বাড়ানো/কমানো যাবে */
                object-fit: cover;      /* same size রাখবে, ইমেজ crop হতে পারে */
                border-radius: 2px;}
        </style>

        <div class="container text-center my-5">
        <section>
            <div class="row g-3">
            <div class="col-12 col-md-6">
                <img src="{{ asset('images/banner-main-page1.jpg') }}"
                    alt="Banner 1"
                    class="img-fluid img-thumbnail same-banner">
            </div>

            <div class="col-12 col-md-6">
                <img src="{{ asset('images/banner-main-page2.jpg') }}"
                    alt="Banner 2"
                    class="img-fluid img-thumbnail same-banner">
            </div>
            </div>
        </section>
        </div>
@endsection
