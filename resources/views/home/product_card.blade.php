@php
    $old = (float) ($product->old_price ?? 0);
    $new = (float) ($product->selling_price ?? 0);
    $offPercent = ($old > 0 && $new > 0 && $old > $new) ? round((($old - $new) / $old) * 100) : null;
@endphp
<div class="col-6 col-md-3">
    <div class="position-relative product-card h-100">
        <a href="{{ route('home.productDetails', $product->id) }}"
            class="text-decoration-none d-block">
            <img src="{{ asset($product->image) }}" class="product-img" alt="{{ $product->name }}">
        </a>
        @if($offPercent)
            <span class="badge rounded-pill text-bg-primary position-absolute top-0 end-0 m-2">
                {{ $offPercent }}% discount
            </span>
        @endif
         

        <div class="product-body bg-primary-subtle text-primary-emphasis d-flex flex-column">
            <h5 class="card-title title-fixed text-center mt-3 px-2"> {{ $product->name }} </h5>
            <p class="card-text text-center mb-3">Price: <b>{{ $product->selling_price }}</b> BDT</p>
            @include('home.cart_button')
        </div> 
    </div>
</div>