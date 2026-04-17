@extends('layouts.frontend.master')

@section('title')
    Checkout -Cart
@endsection

@section('content')
    {{-- ✅ Cart Page (Responsive + Single Modal works on Mobile) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<div class="container mt-5 mb-5">
    <h1 class="text-center mb-4">Welcome to Your Cart.</h1>

    @if ($cartProducts->isEmpty())
        <h2 class="text-center mb-4">Cart is empty.</h2>
        <div class="d-flex justify-content-center">
            <div class="d-grid gap-2 text-center w-100" style="max-width:420px;">
                <a href="{{ route('home.index') }}" class="btn btn-lg btn-primary">Shop Now!</a>
            </div>
        </div>
    @else

        {{-- =========================
            ✅ DESKTOP/TABLET VIEW
        ========================== --}}
        <div class="d-none d-md-block">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Total</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cartProducts as $cartProduct)
                            @php
                                $p = $products->firstWhere('id', $cartProduct->product_id);
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $p->name ?? '' }}</td>
                                <td>
                                    @if($p?->image)
                                        <img src="{{ asset($p->image) }}" class="img-thumbnail" width="70" alt="">
                                    @endif
                                </td>
                                <td>{{ $cartProduct->quantity }}</td>
                                <td>{{ $cartProduct->unit_price }}</td>
                                <td class="fw-semibold">{{ $cartProduct->total_price }}</td>
                                <td class="text-end">
                                    {{-- ✅ Single Modal Trigger --}}
                                    <button type="button"
                                            class="btn btn-outline-warning btn-sm editQtyBtn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editQtyModal"
                                            data-action="{{ route('cart.updateCart', $cartProduct->id) }}"
                                            data-name="{{ $p->name ?? '' }}"
                                            data-qty="{{ $cartProduct->quantity }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('cart.deleteItem', $cartProduct->id) }}" method="POST" class="d-inline">
                                        @csrf @method('delete')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Remove this item?')">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <a href="{{ route('home.index') }}" class="btn btn-primary">
                                    Continue Shopping
                                </a>
                            </td>

                            <td colspan="2" class="text-end">
                                Sub-Total: <strong>{{ $cartProducts->sum('total_price') }}</strong>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">
                                    Checkout
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- =========================
            ✅ MOBILE VIEW (Cards)
        ========================== --}}
        <div class="d-block d-md-none">
            <div class="row g-3">
                @foreach ($cartProducts as $cartProduct)
                    @php
                        $p = $products->firstWhere('id', $cartProduct->product_id);
                    @endphp

                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        @if($p?->image)
                                            <img src="{{ asset($p->image) }}"
                                                 class="rounded border"
                                                 style="width:90px;height:90px;object-fit:cover" alt="">
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="fw-bold">{{ $p->name ?? '' }}</div>

                                        <div class="small text-muted mt-1">
                                            Unit: <span class="fw-semibold">{{ $cartProduct->unit_price }}</span>
                                        </div>

                                        <div class="small text-muted">
                                            Qty: <span class="fw-semibold">{{ $cartProduct->quantity }}</span>
                                        </div>

                                        <div class="mt-1">
                                            Total: <span class="fw-bold">{{ $cartProduct->total_price }}</span>
                                        </div>

                                        <div class="d-flex gap-2 mt-3">
                                            {{-- ✅ Single Modal Trigger --}}
                                            <button type="button"
                                                    class="btn btn-outline-warning btn-sm flex-fill editQtyBtn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editQtyModal"
                                                    data-action="{{ route('cart.updateCart', $cartProduct->id) }}"
                                                    data-name="{{ $p->name ?? '' }}"
                                                    data-qty="{{ $cartProduct->quantity }}">
                                                Edit Qty
                                            </button>

                                            <form action="{{ route('cart.deleteItem', $cartProduct->id) }}" method="POST" class="flex-fill">
                                                @csrf @method('delete')
                                                <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                        onclick="return confirm('Remove this item?')">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Mobile summary --}}
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-semibold">Sub-Total</div>
                        <div class="fw-bold">{{ $cartProducts->sum('total_price') }}</div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Checkout</a>
                        <a href="{{ route('home.index') }}" class="btn btn-outline-primary">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>


<div class="modal fade" id="editQtyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form action="{{ route('cart.updateCart', $cartProduct->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Quantity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Product Name</label>
                        <input type="text" class="form-control"
                            value="{{ optional($products->firstWhere('id', $cartProduct->product_id))->name }}"
                            disabled>
                    </div>

                    <div class="mb-3">
                        <label for="qty{{ $cartProduct->id }}">New Quantity</label>
                        <input type="number" name="quantity" id="qty{{ $cartProduct->id }}"
                            class="form-control" value="{{ $cartProduct->quantity }}"
                            min="1" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>

@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('click', function(e){
  const btn = e.target.closest('.editQtyBtn');
  if(!btn) return;

  document.getElementById('editQtyForm').action = btn.dataset.action;
  document.getElementById('modalProductName').value = btn.dataset.name || '';
  document.getElementById('modalQty').value = btn.dataset.qty || 1;
});
</script>

@endsection 
