@extends('layouts.frontend.master')

@section('title')
    Contact Us
@endsection

@section('content')
    <div class="bg-light">
        <div class="container py-5">

            <!-- HERO -->
            <div class="card border-0 shadow-sm overflow-hidden mb-5">
                <div class="card-body p-4 p-md-5"
                     style="background: linear-gradient(135deg, rgba(13,110,253,.14), rgba(13,202,240,.12), rgba(255,255,255,.92));">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <span class="badge rounded-pill text-bg-primary px-3 py-2">
                                We’re here to help
                            </span>
                            <h1 class="mt-3 fw-bold display-6 mb-2">Contact us</h1>
                            <p class="text-muted mb-0">
                                Have a question about products, delivery, warranty, or anything else?
                                Send us a message — we’ll respond as soon as possible.
                            </p>
                        </div>
                        <div class="col-lg-5">
                            <div class="bg-white border rounded-4 p-4 shadow-sm">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="rounded-4 d-flex align-items-center justify-content-center"
                                         style="width:44px;height:44px;background: rgba(13,110,253,.10); border: 1px solid rgba(13,110,253,.20);">
                                        <i class="bi bi-clock text-primary fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Support Hours</div>
                                        <div class="text-muted small">Sat–Thu: 10:00 AM – 8:00 PM</div>
                                        <div class="text-muted small">Friday: Closed</div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="d-flex align-items-start gap-3">
                                    <div class="rounded-4 d-flex align-items-center justify-content-center"
                                         style="width:44px;height:44px;background: rgba(13,110,253,.10); border: 1px solid rgba(13,110,253,.20);">
                                        <i class="bi bi-shield-check text-primary fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Fast Response</div>
                                        <div class="text-muted small">Usually within 24 hours</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- CONTACT INFO CARDS -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-3 rounded-4 d-flex align-items-center justify-content-center"
                                 style="width:56px;height:56px;background: rgba(13,110,253,.10); border: 1px solid rgba(13,110,253,.20);">
                                <i class="bi bi-telephone-fill text-primary fs-4"></i>
                            </div>
                            <h5 class="fw-bold mb-1">Phone</h5>
                            <p class="text-muted mb-0">
                                <a class="text-decoration-none" href="tel:+8801789489363">+8801789489363</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-3 rounded-4 d-flex align-items-center justify-content-center"
                                 style="width:56px;height:56px;background: rgba(13,110,253,.10); border: 1px solid rgba(13,110,253,.20);">
                                <i class="bi bi-envelope-fill text-primary fs-4"></i>
                            </div>
                            <h5 class="fw-bold mb-1">Email</h5>
                            <p class="text-muted mb-0">
                                <a class="text-decoration-none" href="mailto:info.wareflowbd@gmail.com">info.wareflowbd@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-3 rounded-4 d-flex align-items-center justify-content-center"
                                 style="width:56px;height:56px;background: rgba(13,110,253,.10); border: 1px solid rgba(13,110,253,.20);">
                                <i class="bi bi-geo-alt-fill text-primary fs-4"></i>
                            </div>
                            <h5 class="fw-bold mb-1">Address</h5>
                            <p class="text-muted mb-0">Dhaka, Bangladesh</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- FORM + MAP -->
            <div class="row g-4 align-items-stretch">
                <!-- FORM -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                <h3 class="fw-bold mb-0">Send us a message</h3>
                                <span class="badge rounded-pill text-bg-light border text-dark px-3 py-2">
                                    We reply within 24h
                                </span>
                            </div>
                            <p class="text-muted">
                                Fill out the form and our team will contact you shortly.
                            </p>

                            <form action="{{ route('home.customerContact') }}" method="POST" class="mt-4">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-semibold">Full Name</label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name"
                                               placeholder="Your full name" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                                               placeholder="name@example.com" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold">Phone Number (optional)</label>
                                        <input type="text" class="form-control form-control-lg" id="phone" name="phone"
                                               placeholder="+8801XXXXXXXXX">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Subject (optional)</label>
                                        <input type="text" class="form-control form-control-lg" name="subject"
                                               placeholder="e.g., Product inquiry">
                                        {{-- যদি subject DB/Controller এ না লাগে, এই ইনপুটটি remove করতে পারবেন --}}
                                    </div>

                                    <div class="col-12">
                                        <label for="message" class="form-label fw-semibold">Your Message</label>
                                        <textarea class="form-control form-control-lg" id="message" name="message"
                                                  rows="6" placeholder="Write your message..." required></textarea>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="bi bi-send me-2"></i>
                                            Send Message
                                        </button>

                                        <div class="text-muted small mt-2">
                                            By sending this message, you agree to be contacted back regarding your inquiry.
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- MAP / LOCATION -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="p-4 p-md-5">
                                <h4 class="fw-bold mb-1">Our Location</h4>
                                <p class="text-muted mb-3">Find us easily on Google Maps.</p>

                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex gap-2 align-items-start">
                                        <i class="bi bi-geo text-primary mt-1"></i>
                                        <span class="text-muted">Dhaka, Bangladesh</span>
                                    </div>
                                    <div class="d-flex gap-2 align-items-start">
                                        <i class="bi bi-telephone text-primary mt-1"></i>
                                        <a class="text-decoration-none" href="tel:+8801789489363">+8801789489363</a>
                                    </div>
                                    <div class="d-flex gap-2 align-items-start">
                                        <i class="bi bi-envelope text-primary mt-1"></i>
                                        <a class="text-decoration-none" href="mailto:info.wareflowbd@gmail.com">info.wareflowbd@gmail.com</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Map Embed -->
                            <div class="ratio ratio-4x3 border-top">
                                <iframe
                                    src="https://www.google.com/maps?q=Baily%20Road%20Dhaka&output=embed"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
