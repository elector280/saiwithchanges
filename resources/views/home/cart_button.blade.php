<div class="btn-area mt-auto px-2 pb-3">
    <div class="d-flex align-items-center gap-2">
        <form action="{{ route('cart.onepagecheckout', $product->id) }}" method="POST" class="flex-grow-1">
        @csrf
        <button type="submit"
            class="btn w-100 text-white fw-semibold py-2"
            style="background:#0f782f;border:0;border-radius:6px; font-size:14px;">
            Order now
        </button>
        </form>
        <form action="{{ route('cart.addToCart', $product->id) }}" method="POST">
        @csrf
        <button type="submit"
            class="btn d-flex align-items-center justify-content-center"
            style="width:46px;height:38px;background:#fff;border:1px solid #0f782f; border-radius:6px;">
                <i class="bi bi-cart3" style="color:#db7609;font-size:18px;"></i>
        </button>
        </form>
    </div>
</div>