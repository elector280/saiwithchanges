@extends('layouts.frontend.master')

@section('title')
    About Us
@endsection

@section('content')
    <div class="bg-light">
        <div class="container py-5">

            <!-- HERO -->
            <div class="card border-0 shadow-sm overflow-hidden mb-5">
                <div class="card-body p-4 p-md-5 position-relative"
                     style="background: linear-gradient(135deg, rgba(13,110,253,.12), rgba(13,202,240,.10), rgba(255,255,255,.9));">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <span class="badge rounded-pill text-bg-primary px-3 py-2">
                                Trusted Tech Retailer in Bangladesh
                            </span>

                            <h1 class="mt-3 fw-bold display-6 mb-2">
                                About <span class="text-primary">WareFlow BD</span>
                            </h1>
                            <p class="text-muted mb-4">
                                Leading Computer, Laptop & Tech Retailer in Bangladesh driven by genuine products,
                                great pricing, and customer-first service.
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('home.index') }}" class="btn btn-primary btn-lg">
                                    Start Shopping
                                </a>
                                <a href="#story" class="btn btn-outline-primary btn-lg">
                                    Our Story
                                </a>
                            </div>

                            <!-- Quick Stats -->
                            <div class="row g-3 mt-4">
                                <div class="col-6 col-md-3">
                                    <div class="p-3 bg-white rounded-4 border h-100">
                                        <div class="small text-muted">Founded</div>
                                        <div class="h5 fw-bold mb-0">2025</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="p-3 bg-white rounded-4 border h-100">
                                        <div class="small text-muted">Employees</div>
                                        <div class="h5 fw-bold mb-0">350+</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="p-3 bg-white rounded-4 border h-100">
                                        <div class="small text-muted">Outlets</div>
                                        <div class="h5 fw-bold mb-0">20+</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="p-3 bg-white rounded-4 border h-100">
                                        <div class="small text-muted">Coverage</div>
                                        <div class="h5 fw-bold mb-0">Nationwide</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side Card -->
                        <div class="col-lg-5">
                            <div class="bg-white border rounded-4 p-4 shadow-sm">
                                <h5 class="fw-bold mb-3">Why customers choose us</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex gap-2 mb-2">
                                        <span class="mt-2 d-inline-block rounded-circle bg-primary" style="width:10px;height:10px;"></span>
                                        <span class="text-muted">Genuine tech products with warranty support</span>
                                    </li>
                                    <li class="d-flex gap-2 mb-2">
                                        <span class="mt-2 d-inline-block rounded-circle bg-primary" style="width:10px;height:10px;"></span>
                                        <span class="text-muted">Strong after-sales service & customer care</span>
                                    </li>
                                    <li class="d-flex gap-2 mb-2">
                                        <span class="mt-2 d-inline-block rounded-circle bg-primary" style="width:10px;height:10px;"></span>
                                        <span class="text-muted">Online order + delivery across Bangladesh</span>
                                    </li>
                                    <li class="d-flex gap-2">
                                        <span class="mt-2 d-inline-block rounded-circle bg-primary" style="width:10px;height:10px;"></span>
                                        <span class="text-muted">Competitive pricing & curated products</span>
                                    </li>
                                </ul>

                                <div class="mt-4 p-3 rounded-4"
                                     style="background: rgba(13,110,253,.08); border: 1px solid rgba(13,110,253,.18);">
                                    <div class="small fw-semibold text-primary">Motto</div>
                                    <div class="text-muted">“Customers Come First”</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- STORY + ISO -->
            <div id="story" class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="fw-bold mb-3">Our Story</h3>
                            <p class="text-muted">
                                WareFlow BD has been founded on 1 August 2025. From then to now, we’ve grown through dedication,
                                customer satisfaction, and consistent service improvement. We operate across major territories and
                                maintain both physical outlets and a successful e-commerce platform.
                            </p>

                            <!-- Timeline style -->
                            <div class="mt-4">
                                <div class="d-flex gap-3 mb-3">
                                    <div class="rounded-4 d-flex align-items-center justify-content-center fw-bold text-primary"
                                         style="width:44px;height:44px;background: rgba(13,110,253,.10); border: 1px solid rgba(13,110,253,.20);">
                                        1
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Started with a simple goal</div>
                                        <div class="text-muted small">Provide genuine products with trustworthy support.</div>
                                    </div>
                                </div>

                                <div class="d-flex gap-3 mb-3">
                                    <div class="rounded-4 d-flex align-items-center justify-content-center fw-bold text-primary"
                                         style="width:44px;height:44px;background: rgba(13,110,253,.10); border: 1px solid rgba(13,110,253,.20);">
                                        2
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Expanded nationwide</div>
                                        <div class="text-muted small">Outlets in multiple regions + strong online presence.</div>
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    <div class="rounded-4 d-flex align-items-center justify-content-center fw-bold text-primary"
                                         style="width:44px;height:44px;background: rgba(13,110,253,.10); border: 1px solid rgba(13,110,253,.20);">
                                        3
                                    </div>
                                    <div>
                                        <div class="fw-semibold">After-sales excellence</div>
                                        <div class="text-muted small">We improve service to keep customers satisfied.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ISO -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="fw-bold mb-3">ISO Certified Quality</h4>
                            <p class="text-muted">
                                We maintain quality management standards and regulatory requirements to deliver dependable service.
                            </p>

                            <div class="p-3 rounded-4 mt-3"
                                 style="background: rgba(13,110,253,.08); border: 1px solid rgba(13,110,253,.18);">
                                <div class="small fw-semibold text-primary">Certification</div>
                                <div class="text-muted">ISO 9001:2025 (Certified in 2025)</div>
                            </div>

                            <div class="mt-4">
                                <div class="p-3 bg-light rounded-4 border">
                                    <div class="fw-semibold">What it means</div>
                                    <div class="text-muted small">Consistent processes, improved service, higher confidence.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- MISSION / SERVICES / CORPORATE -->
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="fw-bold">The Main Goal and Aim</h4>
                            <p class="text-muted mb-0">
                                We aim to fulfill customer needs by providing required products and a reliable delivery system across Bangladesh.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="fw-bold">Services Being Provided</h4>
                            <p class="text-muted">
                                Best quality tech products at reasonable price, checked and reviewed before selling with after-sales support.
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                @php
                                    $services = ['Desktop PC','Monitor','Laptop','Mobile Phone','Tablet','Smart Watch','Headphone','WiFi Camera'];
                                @endphp
                                @foreach ($services as $item)
                                    <span class="badge rounded-pill text-bg-light border text-dark py-2 px-3">
                                        {{ $item }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="fw-bold">Dealing with Corporate Sector</h4>
                            <p class="text-muted mb-0">
                                We support banks, hospitals, government and MNCs with IT hardware, networking products, servers, routers and more.
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- BRANDS -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2">
                        <div>
                            <h3 class="fw-bold mb-1">Top-Selling Brands</h3>
                            <p class="text-muted mb-0">Popular brands trusted for quality and after-sales support.</p>
                        </div>
                    </div>

                    @php
                        $brands = [
                            'Samsung','Lenovo','MSI','Apple','Xiaomi','Redmi','Teclast','Havit','COLMI','Intel','EZVIZ',
                            'IMILAB','Onikuma','Fantech','AMD Ryzen','Noctua','Razer','R&M','Team','XFX','Zyxel'
                        ];
                    @endphp

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        @foreach ($brands as $brand)
                            <span class="badge rounded-pill text-bg-white border text-dark py-2 px-3 shadow-sm">
                                {{ $brand }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- CUSTOMER SATISFACTION + CTA -->
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="fw-bold">Customer Satisfaction</h3>
                            <p class="text-muted">
                                We continuously improve to fulfill customer desires online buying, delivery service across Bangladesh,
                                and strong after-sales customer support.
                            </p>

                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border h-100">
                                        <div class="fw-semibold">Easy Online Order</div>
                                        <div class="text-muted small">Browse, compare, and buy from anywhere.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border h-100">
                                        <div class="fw-semibold">Nationwide Delivery</div>
                                        <div class="text-muted small">Reliable delivery to your doorstep.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border h-100">
                                        <div class="fw-semibold">After-Sales Support</div>
                                        <div class="text-muted small">Warranty support and service assistance.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border h-100">
                                        <div class="fw-semibold">Best Value</div>
                                        <div class="text-muted small">Competitive pricing and genuine products.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100 text-white overflow-hidden"
                         style="background: linear-gradient(135deg, #0d6efd, #0dcaf0);">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="fw-bold">Explore Our Products</h3>
                            <p class="mb-4 opacity-90">
                                Visit our e-commerce site or nearest store to find the best tech products at the best value.
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('home.index') }}" class="btn btn-light btn-lg fw-semibold">
                                    Start Shopping
                                </a>
                                <a href="{{ route('home.index') }}" class="btn btn-outline-light btn-lg fw-semibold">
                                    Browse Categories
                                </a>
                            </div>

                            <div class="row g-3 mt-4">
                                <div class="col-4">
                                    <div class="p-3 rounded-4" style="background: rgba(255,255,255,.15);">
                                        <div class="fw-semibold">Genuine</div>
                                        <div class="small opacity-75">Products</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 rounded-4" style="background: rgba(255,255,255,.15);">
                                        <div class="fw-semibold">Support</div>
                                        <div class="small opacity-75">Service</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 rounded-4" style="background: rgba(255,255,255,.15);">
                                        <div class="fw-semibold">Delivery</div>
                                        <div class="small opacity-75">Fast</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
