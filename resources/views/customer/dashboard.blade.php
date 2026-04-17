@extends('layouts.frontend.master')

@section('content')
<div class="container py-4">
    <div class="row g-3">

        {{-- Sidebar --}}
        <div class="col-12 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;">
                            <span class="fw-bold">{{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}</span>
                        </div>
                        <div>
                            <div class="fw-bold">{{ auth()->user()->name ?? 'Customer' }}</div>
                            <div class="text-muted small">{{ auth()->user()->email ?? '' }}</div>
                        </div>
                    </div>

                    <div class="list-group" id="dashboardTabs">
                        <button type="button" class="list-group-item list-group-item-action active"
                                data-tab="tab-profile">
                            Profile
                        </button>

                        <button type="button" class="list-group-item list-group-item-action"
                                data-tab="tab-password">
                            Password
                        </button>

                        <button type="button" class="list-group-item list-group-item-action"
                                data-tab="tab-orders">
                            Orders
                        </button>
                    </div>

                    <hr class="my-3">

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger w-100" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="col-12 col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- Profile Tab --}}
                    <div class="tab-section" id="tab-profile">
                        <h5 class="mb-3">Profile</h5>

                        <form action="{{ route('customer.profile.update') }}" method="POST">
                            @csrf
                            

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ old('name', auth()->user()->name) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email', auth()->user()->email) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone_number" class="form-control"
                                           value="{{ old('phone_number', auth()->user()->phone_number ?? '') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control"
                                           value="{{ old('address', auth()->user()->address ?? '') }}">
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Password Tab --}}
                    <div class="tab-section d-none" id="tab-password">
                        <h5 class="mb-3">Change Password</h5>

                        <form action="{{ route('customer.password.update') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Current Password</label>
                                    <input type="password"
                                        name="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror">

                                    @error('current_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">New Password</label>
                                    <input type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror">

                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password"
                                        name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror">

                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-warning" type="submit">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>


                    {{-- Orders Tab --}}
                    <div class="tab-section d-none" id="tab-orders">
                        <h5 class="mb-3">My Orders</h5>

                        {{-- Example table (তুমি তোমার order data loop করবা) --}}

                        @php 
                        $incoices = App\Models\Invoice::where('user_id', auth()->user()->id)->get();
                        @endphp

                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($incoices as $k=>$order)
                                <tr>
                                    <td>1</td>
                                    <td>INV-202601260101</td>
                                    <td>{{ now()->format('d M Y') }}</td>
                                    <td>৳ 23060</td>
                                    <td>
                                        @if($order->order_status == 1)
                                        <span class="badge bg-danger">
                                            Pending
                                        </span>
                                        @elseif($order->order_status == 2)
                                            <span class="badge bg-warning">
                                                In progress
                                            </span>
                                        @elseif($order->order_status == 3)
                                            <span class="badge bg-primary">
                                                Shipping
                                            </span>
                                        @elseif($order->order_status == 4)
                                            <span class="badge bg-info">
                                                Delivery
                                            </span>
                                        @elseif($order->order_status == 5)
                                            <span class="badge bg-success">
                                                Complete
                                            </span>
                                        @endif
                                    </td>
                                    <!-- <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                    </td> -->
                                </tr>
                                @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- Tab System Script --}}
<script>
    (function () {
        const buttons = document.querySelectorAll('#dashboardTabs [data-tab]');
        const sections = document.querySelectorAll('.tab-section');

        buttons.forEach(btn => {
            btn.addEventListener('click', function () {
                // active button
                buttons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // show selected section
                const target = this.getAttribute('data-tab');
                sections.forEach(sec => sec.classList.add('d-none'));
                document.getElementById(target).classList.remove('d-none');
            });
        });
    })();
</script>
@endsection
