<footer class="footer pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            {{-- LEFT --}}
            <div class="col-md-4">
                <div class="mb-3 d-flex align-items-center">
                    <img src="{{ asset('images/logo/logo-footer.png') }}" height="42" class="me-2" alt="">
                    <span class="fw-bold text-uppercase small">
                        South American Initiative
                    </span>
                </div>
                <p class="mb-2">
                    South American Initiative is a 501(c)(3) charitable organization, EIN 00-000000.
                    Donations are tax deductible as allowed by law.
                </p>
                <p class="mb-0 small">
                    © {{ date('Y') }} South American Initiative. All rights reserved.
                </p>
            </div>

            {{-- MIDDLE --}}
            <div class="col-md-4">
                <h6 class="text-uppercase fw-bold mb-3 small">Contact</h6>
                <p class="mb-1">123 Non-Profit Street, Miami, FL</p>
                <p class="mb-1">Phone: +1 (800) 563-6099</p>
                <p class="mb-1">Email: donate@sai.ngo</p>
            </div>

            {{-- RIGHT --}}
            <div class="col-md-4">
                <h6 class="text-uppercase fw-bold mb-3 small">Quick Links</h6>
                <ul class="list-unstyled mb-3">
                    <li><a href="#campaigns">Campaigns</a></li>
                    <li><a href="#news">Articles &amp; News</a></li>
                    <li><a href="#reviews">Reviews</a></li>
                    <li><a href="#numbers">Our Numbers</a></li>
                </ul>
                <a href="#donate" class="btn btn-sm btn-donate">Donate Now</a>
            </div>
        </div>
    </div>
</footer>
