@extends('layouts.frontend.master')

@section('title')
    Checkout - Order
@endsection

@section('content')
<div class="container my-4 my-md-5">
    <h1 class="text-center mb-4 mb-md-5">Welcome to Checkout Page.</h1>

    @if ($cartProducts->isEmpty())
        <h2 class="text-center mb-4">Cart is empty.</h2>
        <div class="d-flex justify-content-center">
            <div class="d-grid gap-2 text-center w-100" style="max-width:420px;">
                <a href="{{ route('home.index') }}" class="btn btn-lg btn-primary">Shop Now!</a>
            </div>
        </div>
    @else
        <form method="POST" action="{{ route('cart.confirmOrder') }}">
            @csrf

            <div class="row g-3 g-md-5">
                {{-- ✅ Customer Info (Mobile: top, Desktop: left) --}}
                <div class="col-12 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold">Customer Information</h5>
                        </div>

                        <div class="card-body">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', optional(auth()->user())->name) }}" placeholder="Full Name">
                                @error('name')
                                    <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="email" name="email" class="form-control"
                                    value=" {{ old('email', optional(auth()->user())->email) }}" placeholder="Email address">
                                @error('email')
                                    <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="text" name="phone_number" class="form-control"
                                    value=" {{ old('phone_number', optional(auth()->user())->phone_number) }}" placeholder="Enter phone number">
                                @error('phone_number')
                                    <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3"> 
                                <textarea class="form-control" name="address" rows="3"
                                    placeholder="Enter your address">{{ old('address', optional(auth()->user())->address) }}</textarea>
                                @error('address')
                                    <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <select class="form-select" id="delivery_fee" name="delivery_fee" required>
                                    <option value="" disabled selected>Delivery Location</option>
                                    <option value="60">Inside Dhaka ( + 60 )</option>
                                    <option value="120">Outside Dhaka ( + 120 )</option>
                                </select>
                            </div>

                            <div class="small text-muted">
                                Select delivery location to calculate total.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ✅ Ordered Items (Mobile: bottom, Desktop: right) --}}
                <div class="col-12 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="mb-0 fw-bold">Ordered Items</h5>
                            <div class="small text-muted">
                                Items: <b>{{ $cartProducts->count() }}</b>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            {{-- ✅ Mobile: Card list --}}
                            <div class="d-block d-md-none p-3">
                                @foreach ($cartProducts as $cartProduct)
                                    @php $p = $products->firstWhere('id', $cartProduct->product_id); @endphp

                                    <div class="border rounded-3 p-2 mb-2">
                                        <div class="d-flex gap-3">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset($p->image ?? '') }}"
                                                     class="rounded border"
                                                     style="width:80px;height:80px;object-fit:cover" alt="">
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="fw-bold">{{ $p->name ?? '' }}</div>
                                                <div class="small text-muted mt-1">
                                                    Qty: <b>{{ $cartProduct->quantity }}</b> • Unit: <b>{{ $cartProduct->unit_price }}</b>
                                                </div>
                                                <div class="mt-1">
                                                    Total: <span class="fw-bold">{{ $cartProduct->total_price }}</span>
                                                </div>

                                                {{-- hidden inputs --}}
                                                <input type="hidden" name="product_id[]" value="{{ $cartProduct->product_id }}">
                                                <input type="hidden" name="quantity[]" value="{{ $cartProduct->quantity }}">
                                                <input type="hidden" name="unit_price[]" value="{{ $cartProduct->unit_price }}">
                                                <input type="hidden" name="total_price[]" value="{{ $cartProduct->total_price }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- ✅ Desktop: Table view --}}
                            <div class="d-none d-md-block table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($cartProducts as $cartProduct)
                                            @php $p = $products->firstWhere('id', $cartProduct->product_id); @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-semibold">{{ $p->name ?? '' }}</td>

                                                <input type="hidden" name="product_id[]" value="{{ $cartProduct->product_id }}">

                                                <td>
                                                    <img src="{{ asset($p->image ?? '') }}" alt="" class="img-thumbnail" width="75">
                                                </td>

                                                <td>{{ $cartProduct->quantity }}</td>
                                                <input type="hidden" name="quantity[]" value="{{ $cartProduct->quantity }}">

                                                <td>{{ $cartProduct->unit_price }}</td>
                                                <input type="hidden" name="unit_price[]" value="{{ $cartProduct->unit_price }}">

                                                <td class="fw-semibold">{{ $cartProduct->total_price }}</td>
                                                <input type="hidden" name="total_price[]" value="{{ $cartProduct->total_price }}">
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Totals --}}
                            @php $sub = $cartProducts->sum('total_price'); @endphp

                            <div class="p-3 border-top">
                                <div class="d-flex justify-content-between mb-1">
                                    <div>Sub-Total</div>
                                    <div><strong id="subTotal">{{ $sub }}</strong></div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <div>Delivery Charge</div>
                                    <div><strong id="deliveryCharge">60</strong></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="fs-5 fw-bold">Grand Total</div>
                                    <div class="fs-5 fw-bold" id="grandTotal">{{ $sub + 60 }}</div>
                                </div>

                                <input type="hidden" name="sub_total" id="inputSubTotal" value="{{ $sub }}">
                                <input type="hidden" name="grand_total" id="inputGrandTotal" value="{{ $sub + 60 }}">
                            </div>
                        </div>
                    </div>

                    {{-- Buttons (Mobile: stacked, Desktop: left-right) --}}
                   <!-- ✅ Mobile: full width 2 buttons stacked | Desktop: left-right -->
                    <div class="row g-2 mt-3">
                        <div class="col-12 col-md-auto">
                            <a href="{{ route('cart.index') }}" class="btn btn-warning w-100">
                            Go back to Cart
                            </a>
                        </div>

                        <div class="col-12 col-md-auto ms-md-auto">
                            <button type="submit" class="btn btn-primary w-100">
                            Order Now
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    @endif
</div>

<script>
    const deliverySelect = document.getElementById('delivery_fee');
    const subTotalEl = document.getElementById('subTotal');
    const subTotal = Number(subTotalEl?.innerText || 0);

    if (deliverySelect) {
        deliverySelect.addEventListener('change', function() {
            const deliveryCharge = Number(this.value || 0);
            const grandTotal = subTotal + deliveryCharge;

            document.getElementById('deliveryCharge').innerText = deliveryCharge;
            document.getElementById('grandTotal').innerText = grandTotal;

            document.getElementById('inputSubTotal').value = subTotal;
            document.getElementById('inputGrandTotal').value = grandTotal;
        });
    }
</script>
@endsection
