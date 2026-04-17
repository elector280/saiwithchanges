@extends('layouts.frontend.master')

@section('title')
    Thank You - Order Successful
@endsection

@section('content')
<div class="container my-4 my-md-5">

    {{-- Screen heading (Print এ hide হবে) --}}
    <h1 class="text-center mb-2 mb-md-3 d-print-none">Order Successful!</h1>
    <p class="text-center text-muted mb-4 mb-md-5 d-print-none">
        Thanks for your order. Your invoice is ready to print.
    </p>

    {{-- Actions (NOT printed) --}}
    <div class="d-flex justify-content-center gap-2 flex-wrap mb-4 d-print-none">
        <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
            Continue Shopping
        </a>
        <button type="button" class="btn btn-primary" onclick="printInvoice()">
            Print Invoice
        </button>
    </div>
    <div class="d-flex justify-content-center gap-2 flex-wrap mb-4 d-print-none">
        @if(session('default_pass_msg'))
            <div class="alert alert-info mt-3">
                {{ session('default_pass_msg') }}
            </div>
        @endif

    </div>

    {{-- ✅ PRINT ROOT: only this block will be printed --}}
    <div id="printRoot">
        <div id="invoiceArea">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="mb-0 fw-bold">Invoice</h5>
                        <div class="small text-muted">
                            Invoice No: <b>{{ $invoice->invoice_no ?? ('#'.$invoice->id) }}</b>
                        </div>
                    </div>

                    <div class="text-end">
                        <div class="small text-muted">Date</div>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($invoice->date)->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $payment  = $invoice->payment ?? null;
                        $customer = $payment->customer ?? null;
                    @endphp

                    {{-- ✅ Customer (left) + Order (right) --}}
                    <div class="row g-3 info-row">
                        <div class="col-12 col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="fw-bold mb-2">Customer Information</div>

                                <div class="mb-2">
                                    <div class="small text-muted">Name</div>
                                    <div class="fw-semibold">{{ $customer->name ?? '-' }}</div>
                                </div>

                                <div class="mb-2">
                                    <div class="small text-muted">Email</div>
                                    <div class="fw-semibold">{{ $customer->email ?? '-' }}</div>
                                </div>

                                <div class="mb-2">
                                    <div class="small text-muted">Phone</div>
                                    <div class="fw-semibold">{{ $customer->mobile_no ?? '-' }}</div>
                                </div>

                                <div class="mb-0">
                                    <div class="small text-muted">Address</div>
                                    <div class="fw-semibold">{{ $customer->address ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="fw-bold mb-2">Order Information</div>

                                <div class="mb-2 d-flex justify-content-between">
                                    <div class="text-muted">Order ID</div>
                                    <div class="fw-semibold">#{{ $invoice->id }}</div>
                                </div>

                                <div class="mb-2 d-flex justify-content-between">
                                    <div class="text-muted">Status</div>
                                    <div class="fw-semibold">
                                        {{ ($invoice->status ?? '0') == '0' ? 'Pending' : 'Approved' }}
                                    </div>
                                </div>

                                <div class="mb-2 d-flex justify-content-between">
                                    <div class="text-muted">Items</div>
                                    <div class="fw-semibold">{{ $invoice->invoice_details->count() ?? 0 }}</div>
                                </div>

                                <div class="mb-0 d-flex justify-content-between">
                                    <div class="text-muted">Payment</div>
                                    <div class="fw-semibold">{{ $payment->paid_status ?? 'full_due' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- ✅ Items --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-bold">Ordered Items</div>
                        <div class="small text-muted">
                            Total Items: <b>{{ $invoice->invoice_details->count() ?? 0 }}</b>
                        </div>
                    </div>

                    {{-- Mobile cards (screen only) --}}
                    <div class="d-block d-md-none">
                        @foreach($invoice->invoice_details as $item)
                            <div class="border rounded-3 p-2 mb-2">
                                <div class="fw-bold">{{ $item->product->name ?? 'Product' }}</div>
                                <div class="small text-muted mt-1">
                                    Qty: <b>{{ $item->selling_qty }}</b> • Unit: <b>{{ $item->unit_price }}</b>
                                </div>
                                <div class="mt-1">
                                    Total: <span class="fw-bold">{{ $item->selling_price }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop table (print will force this) --}}
                    <div class="d-none d-md-block table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width:70px;">SL</th>
                                    <th>Product Name</th>
                                    <th style="width:120px;" class="text-end">Qty</th>
                                    <th style="width:160px;" class="text-end">Unit Price</th>
                                    <th style="width:180px;" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->invoice_details as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $item->product->name ?? 'Product' }}</td>
                                        <td class="text-end">{{ $item->selling_qty }}</td>
                                        <td class="text-end">{{ $item->unit_price }}</td>
                                        <td class="text-end fw-semibold">{{ $item->selling_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- ✅ Totals --}}
                    @php
                        $sub = $invoice->invoice_details->sum('selling_price');
                        $delivery = (float) ($invoice->delivery_fee ?? 0);
                        $grand = (float) ($payment->selling_price ?? ($sub + $delivery));
                    @endphp

                    <div class="border-top pt-3 mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <div>Sub-Total</div>
                            <div><strong>{{ $sub }}</strong></div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <div>Delivery Charge</div>
                            <div><strong>{{ $delivery }}</strong></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fs-5 fw-bold">Grand Total</div>
                            <div class="fs-5 fw-bold">{{ $grand }}</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Bottom Print Button (NOT printed) --}}
            <div class="d-flex justify-content-end mt-3 d-print-none">
                <button type="button" class="btn btn-primary" onclick="printInvoice()">
                    Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* ✅ PRINT: only #printRoot will print */
@media print {

    /* hide everything */
    body * { visibility: hidden !important; }

    /* show only printRoot */
    #printRoot, #printRoot * { visibility: visible !important; }

    /* position printRoot at top-left */
    #printRoot {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
    }

    /* hide actions/buttons */
    .d-print-none { display: none !important; }

    /* force desktop table, hide mobile cards */
    .d-md-none { display: none !important; }
    .d-none.d-md-block { display: block !important; }

    /* keep customer+order side-by-side in print */
    #printRoot .info-row{
        display: flex !important;
        flex-wrap: nowrap !important;
        gap: 12px !important;
    }
    #printRoot .info-row > .col-12.col-md-6{
        flex: 0 0 50% !important;
        max-width: 50% !important;
        width: 50% !important;
    }

    /* remove shadows */
    .card, .shadow, .shadow-sm { box-shadow: none !important; }

    /* table print friendly */
    table { width: 100% !important; border-collapse: collapse !important; }
    th, td { border: 1px solid #dee2e6 !important; padding: 8px !important; vertical-align: middle !important; }
    thead th { background: #f8f9fa !important; }

    /* avoid breaking important blocks */
    .card, .border, .row, tr, td, th { break-inside: avoid !important; page-break-inside: avoid !important; }

    /* keep colors */
    body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}

@page { margin: 12mm; }
</style>

<script>
function printInvoice(){
    window.print();
}
</script>
@endsection
