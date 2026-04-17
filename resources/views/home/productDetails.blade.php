@extends('layouts.frontend.master')

@section('title')
    {{ $productDetails->name }}
@endsection

@section('content')
    @php
        $images = collect([]);

        // Relation: $productDetails->images (recommended)
        if (isset($productDetails->images) && $productDetails->images->count()) {
            $images = $productDetails->images->pluck('image_path'); // column name adjust
        }

        // Fallback array/collection
        if ($images->isEmpty() && isset($productImages) && count($productImages)) {
            $images = collect($productImages);
        }

        // Only main image fallback
        if ($images->isEmpty()) {
            $images = collect([$productDetails->image]);
        }

        $mainImage = $productDetails->images;

        $old = (float) ($productDetails->old_price ?? 0);
        $new = (float) ($productDetails->selling_price ?? 0);
        $offPercent = ($old > 0 && $new > 0 && $old > $new) ? round((($old - $new) / $old) * 100) : null;

        $releted_product = App\Models\Product::latest()->where('category_id', $productDetails->category_id)->take(4)->get();
    @endphp



    <div class="container mt-5">
        <div class="row justify-content-center- mt-3">
            <div class="col-12 col-md-12">
                <div class="row g-3">

                    <div class="col-lg-6  d-flex">
                        <div class="card shadow-sm w-100">
                            <div class="card-body">

                                <div class="position-relative border rounded-3 p-2 bg-white">
                                    @if($offPercent)
                                        <span class="badge rounded-pill text-bg-primary position-absolute top-0 end-0 m-2">
                                            {{ $offPercent }}% discount
                                        </span>
                                    @endif

                                    <img id="pdMainImage"
                                        src="{{ asset($productDetails->image) }}"
                                        class="img-fluid w-100"
                                        style="height:430px; object-fit:contain;"
                                        alt="{{ $productDetails->name }}">
                                </div>

                                {{-- Thumbnails --}}
                                <div class="d-flex gap-2 mt-3 flex-wrap">
                                    @foreach($mainImage as $k => $img)
                                        <button type="button"
                                                class="btn p-0 border rounded-3 overflow-hidden thumbBtn {{ $k===0 ? 'border-primary' : 'border-light' }}"
                                                data-img="{{ asset($img->gallery_image) }}"
                                                style="width:72px; height:72px;">
                                            <img src="{{ asset($img->gallery_image) }}"
                                                class="w-100 h-100"
                                                style="object-fit:cover;"
                                                alt="thumb-{{ $k }}"> 
                                        </button>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: DETAILS --}}
                    <div class="col-lg-6 d-flex">
                        <div class="card shadow-sm w-100">
                            <div class="card-body">

                                <div class="text-secondary small mb-2">
                                    Home / {{ $productDetails->category->name ?? 'Category' }}
                                </div>

                                <h3 class="fw-bold mb-2">{{ $productDetails->name }}</h3> <br>

                                {{-- Price --}}
                                <div class="d-flex align-items-end gap-2 flex-wrap mb-2">
                                    <div class="fs-5 fw-bold text-dark">
                                        BDT {{ number_format($productDetails->selling_price) }}
                                    </div>

                                    @if(!empty($productDetails->old_price))
                                        <div class="fs-6 text-secondary text-decoration-line-through">
                                            BDT {{ number_format($productDetails->old_price) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="small text-secondary mb-3">
                                    <div>
                                        <b>Stock:</b>
                                        @if(($productDetails->quantity ?? 0) >= 1)
                                            <span class="text-success fw-semibold">In Stock</span>
                                        @else
                                            <span class="text-danger fw-semibold">Out of Stock</span>
                                        @endif
                                    </div>
                                    <div>
                                    <br>
                                        <b>Short description:</b>
                                        <p style="white-space: pre-line;">
                                            {!! $productDetails->short_description !!}
                                        </p>
                                    </div>
                                </div>

                                {{-- Qty + Buttons --}}
                                <div class="row g-2 align-items-center mb-3">
                                    <div class="col">
                                        <div class="d-grid gap-2 d-md-flex">
                                            <form action="{{ route('cart.addToCart', $productDetails->id) }}" method="POST" class="flex-fill">
                                                @csrf
                                                <input type="hidden" name="quantity" id="cartQty">
                                                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                                    <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                                </button>
                                            </form>

                                            <form action="{{ route('cart.onepagecheckout', $productDetails->id) }}" method="POST" class="flex-fill">
                                                @csrf
                                                <input type="hidden" name="quantity" id="buyQty">
                                                <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold">
                                                    <i class="bi bi-bag-check me-1"></i> Order now
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Call / WhatsApp --}}
                                <div class="d-grid gap-2 mb-3">
                                    <a class="btn btn-success py-2 fw-semibold" href="tel:+8801789489363">
                                        <i class="bi bi-telephone-fill me-1"></i> +8801789489363
                                    </a>

                                    <a class="btn btn-success py-2 fw-semibold"
                                    style="background:#1f8f5f;border-color:#1f8f5f"
                                    href="https://wa.me/8801789489363" target="_blank">
                                        <i class="bi bi-whatsapp me-1"></i> Ask about this product
                                    </a>
                                </div>

                                {{-- Delivery Info --}}
                                <div class="alert alert-info d-flex gap-2 align-items-start mb-0" role="alert">
                                    <i class="bi bi-box-seam fs-4"></i>
                                    <div class="small">
                                        <div>Delivery charge ৳120 taka throughout Bangladesh</div>
                                        <div>Within Dhaka ৳70 Tk.</div>
                                        <div>Districts around Dhaka ৳100 Tk.</div>
                                        <div class="fw-semibold">Free delivery (conditions apply)</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center- mt-5 mb-5">
            <div class="col-12 col-md-12">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">
                                    Product Description
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab"
                                    data-bs-target="#review-tab-pane" type="button" role="tab"
                                    aria-controls="review-tab-pane" aria-selected="false">
                                    Reviews
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content mt-3" id="myTabContent">
                            <!-- Description -->
                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <p class="mb-0">{!! $productDetails->product_details !!}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews -->
                            <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab" tabindex="0">

                                @if($reviewImages->count() == 0)
                                    <div class="alert alert-light border mb-0">
                                        <div class="fw-semibold">No reviews yet.</div>
                                        <div class="text-muted small">Be the first to leave a review!</div>
                                    </div>
                                @else
                                    <div class="row g-3">
                                        @foreach ($reviewImages as $index => $review)
                                            <div class="col-12">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body p-4">
                                                        <!-- Header -->
                                                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                                                            <div class="d-flex align-items-center gap-1">
                                                                <!-- Avatar -->
                                                                <div class="rounded-circle overflow-hidden border d-flex align-items-center justify-content-center"
                                                                    style="width:44px;height:44px;">
                                                                    <img src="{{ asset($review->review_image) }}"
                                                                        class="w-100 h-100"
                                                                        alt="avatar"
                                                                        style="object-fit:cover;">
                                                                </div>


                                                                <div>
                                                                    <div class="fw-bold">
                                                                        {{ $review->user_name ?? 'Anonymous' }}
                                                                    </div>

                                                                    {{-- created_at থাকলে show --}}
                                                                    @if(!empty($review->created_at))
                                                                        <div class="text-muted small">
                                                                            {{ \Carbon\Carbon::parse($review->created_at)->format('d M, Y') }}
                                                                        </div>
                                                                    @else
                                                                        <div class="text-muted small">Verified buyer</div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Badge -->
                                                             @php
                                                                // প্রতি review এর rating (max 5 cap)
                                                                $raw = $review->rating ?? 0;
                                                                $avg = min(5, round($raw, 1));
                                                                $full = floor($avg);
                                                                $hasHalf = ($avg - $full) >= 0.5;
                                                            @endphp

                                                            <span class="badge rounded-pill text-bg-light border text-dark px-3 py-2
                                                                        d-inline-flex align-items-center gap-2 shadow-sm">
                                                                <span class="fw-semibold">{{ $raw }} Star</span>

                                                                <span class="d-inline-flex align-items-center gap-1 text-warning">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        @if($i <= $full)
                                                                            <i class="bi bi-star-fill"></i>
                                                                        @elseif($hasHalf && $i == $full + 1)
                                                                            <i class="bi bi-star-half"></i>
                                                                        @else
                                                                            <i class="bi bi-star"></i>
                                                                        @endif
                                                                    @endfor
                                                                </span>

                                                        </div>

                                                        <!-- Review Text -->
                                                        @if(!empty($review->text))
                                                            <p class="text-muted mt-3 mb-3">
                                                                {{ $review->text }}
                                                            </p>
                                                        @else
                                                            <p class="text-muted mt-3 mb-3">
                                                                Great product and service!
                                                            </p>
                                                        @endif

                                                        <!-- Image Gallery -->
                                                        @if(!empty($review->review_image))
                                                            <!-- <div class="row g-2">
                                                                <div class="col-6 col-md-3 col-lg-2">
                                                                    <button type="button"
                                                                        class="btn p-0 border-0 w-100"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#reviewImageModal"
                                                                        data-img="{{ asset($review->review_image) }}"
                                                                        data-title="{{ $review->user_name ?? 'Review Image' }}">
                                                                        <img src="{{ asset($review->review_image) }}"
                                                                            class="img-fluid rounded-3 border"
                                                                            style="aspect-ratio: 1/1; object-fit: cover;"
                                                                            alt="Review image">
                                                                    </button>
                                                                </div>
                                                            </div> -->
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Modal: Image Zoom -->
                    <div class="modal fade" id="reviewImageModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reviewImageTitle">Review Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <img id="reviewImagePreview" src="" class="img-fluid w-100" alt="Preview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="fw-bold mt-5 mb-3">Related Products</h4>
        <div class="row mt-5">
            @foreach ($releted_product as $product)
                @include('home.product_card')
            @endforeach
        </div>
    </div>




    <script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('reviewImageModal');
    const imgEl = document.getElementById('reviewImagePreview');
    const titleEl = document.getElementById('reviewImageTitle');

    modal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const img = btn.getAttribute('data-img');
        const title = btn.getAttribute('data-title') || 'Review Image';

        imgEl.src = img;
        titleEl.textContent = title;
    });

    // Optional: clear on close
    modal.addEventListener('hidden.bs.modal', function () {
        imgEl.src = '';
    });
});
</script>


<script>
    // thumbnail -> main image
    document.querySelectorAll('.thumbBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('pdMainImage').src = btn.dataset.img;

            document.querySelectorAll('.thumbBtn').forEach(b => {
                b.classList.remove('border-primary');
                b.classList.add('border-light');
            });

            btn.classList.add('border-primary');
            btn.classList.remove('border-light');
        });
    });

    // qty sync to forms
    const qtyInput = document.getElementById('qtyInput');
    const cartQty = document.getElementById('cartQty');
    const buyQty  = document.getElementById('buyQty');

    function syncQty(){
        let v = parseInt(qtyInput.value || 1, 10);
        if (isNaN(v) || v < 1) v = 1;
        qtyInput.value = v;
        cartQty.value = v;
        buyQty.value = v;
    }
    syncQty();

    document.getElementById('qtyPlus').addEventListener('click', () => {
        qtyInput.value = parseInt(qtyInput.value || 1, 10) + 1;
        syncQty();
    });

    document.getElementById('qtyMinus').addEventListener('click', () => {
        qtyInput.value = Math.max(1, parseInt(qtyInput.value || 1, 10) - 1);
        syncQty();
    });

    qtyInput.addEventListener('input', syncQty);
</script>

@endsection
