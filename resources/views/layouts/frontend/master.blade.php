<!DOCTYPE html>
<html lang="en">

<head>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>@yield('title', 'Welcome to WareFlow BD')</title>
    <meta name="description" content="@yield('meta_description', $settings->meta_description ?? '')">
    <meta name="keywords" content="@yield('meta_keyword', $settings->meta_keyword ?? '')">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            /* Push footer to bottom */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
            background-color: black;
            border-radius: 50%;
            width: 45px;
            height: 45px;
        }



        /* ===== 5 CARDS PER ROW (LG UP) ===== */
        @media (min-width: 992px) {
            .col-lg-2-4 {
                width: 20%;
            }
        }

        /* ===== CARD ===== */
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            /* important */
        }

        /* IMAGE = 70% */
        .product-img {
            flex: 7;
            width: 100%;
            object-fit: contain;
            background: #f8f9fa;
            padding: 10px;
        }

        /* BODY = 30% */
        .product-body {
            flex: 3;
            display: flex;
            flex-direction: column;
        }


        /* FIXED TITLE HEIGHT */
        .title-fixed {
            min-height: 48px;
            line-height: 22px;
            font-size: 16px;
            font-weight: 600;
        }

        /* BIGGER PRICE */
        .price-fixed {
            min-height: 32px;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* BIGGER BUTTON AREA */
        .btn-area {
            min-height: 60px;
        }

        /* BIGGER BUTTONS */
        .btn-area .btn {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
        }

        html {
            scroll-behavior: smooth;
        }

        /* alert */
        #flashAlert {
            transition: opacity 0.5s ease-in-out;
        }

        .navbar {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .nav-link {
            color: #333 !important;
            transition: all 0.25s ease;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #198754 !important; /* bootstrap success green */
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 8px;
            left: 50%;
            background-color: #198754;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 60%;
        }

        .btn-primary, .btn-outline-success {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover, .btn-outline-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.12);
        }

        .rounded-pill {
            border-radius: 50rem !important;
        }

        .cat-chip{
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  border-radius: 999px;
  text-decoration: none;
  color: #111827;
  background: #ffffff;
  border: 1px solid rgba(0,0,0,0.08);
  box-shadow: 0 8px 18px rgba(0,0,0,0.06);
  transition: transform .15s ease, box-shadow .15s ease, background .15s ease, border-color .15s ease;
  user-select: none;
  white-space: nowrap;
}

.cat-chip:hover{
  background: rgba(225,59,53,0.06);
  border-color: #198754;
  transform: translateY(-1px);
  box-shadow: 0 12px 24px rgba(40, 194, 53, 0.14);
  color: #111827;
}

.cat-chip:active{
  transform: translateY(0);
  box-shadow: 0 8px 18px rgba(0,0,0,0.06);
}

.cat-chip__dot{
  width: 10px;
  height: 10px;
  border-radius: 999px;
  background: #198754;
  box-shadow: 0 0 0 4px rgba(53, 225, 82, 0.12);
}

.cat-chip__text{
  font-weight: 700;
  font-size: 15px;
  letter-spacing: .02em;
}

.cat-chip__arrow{
  font-size: 18px;
  line-height: 1;
  color: rgba(17,24,39,0.7);
}


  /* controls নিচে */
  #carouselExample { position: relative; }

  .carousel-bottom-btn{
    top: auto !important;
    bottom: 18px !important;
    transform: none !important;
    width: 44px;
    height: 44px;
    border-radius: 999px;
    background: rgba(0,0,0,0.35);
  }

  /* left/right position */
  .carousel-control-prev.carousel-bottom-btn{ left: 18px; }
  .carousel-control-next.carousel-bottom-btn{ right: 18px; }

  .carousel-bottom-indicators{
    bottom: 10px;
  }


  .cat-marquee{
  overflow: hidden;
  width: 100%;
  padding: 10px 0;
  position: relative;
}

.cat-track{
  display: flex;
  align-items: center;
  gap: 12px;
  width: max-content;
  animation: catScroll 30s linear infinite;
}

/* hover করলে pause (optional) */
.cat-marquee:hover .cat-track{
  animation-play-state: paused;
}

/* seamless loop */
@keyframes catScroll{
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

/* আপনার chip স্টাইল না থাকলে sample */
.cat-chip{
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 14px;
  border: 1px solid rgba(0,0,0,0.10);
  border-radius: 999px;
  text-decoration: none;
  color: #111;
  background: #fff;
  white-space: nowrap;
}

.cat-chip__dot{
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background: #198754;
}

.cat-chip__arrow{
  opacity: .6;
}


/* hover করলে dropdown show */
.dropdown-hover:hover > .dropdown-menu {
  display: block;
  margin-top: 0; /* gap remove */
}

/* caret/hover feel better */
.dropdown-hover > .dropdown-toggle::after{
  margin-left: .4rem;
}

/* optional: smooth */
.dropdown-hover > .dropdown-menu{
  margin-top: 0;
}

/* dropdown container একটু সুন্দর */
.dropdown-menu{
  padding: 10px;
  border-radius: 14px;
  border: 1px solid rgba(0,0,0,0.08);
  box-shadow: 0 12px 30px rgba(0,0,0,0.10);
}

/* box style item */
.cat-box{
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;

  padding: 10px 12px;
  margin: 6px 0;

  border-radius: 12px;
  border: 1px solid rgba(0,0,0,0.08);
  background: #fff;

  font-weight: 600;
  transition: all .18s ease;
}

/* hover effect */
.cat-box:hover{
  background: rgba(65, 230, 147, 0.3);          /* light primary */
  border-color: rgba(53, 225, 62, 0.35);
  color: #047a31;
  transform: translateX(2px);
}

/* remove bootstrap default active bg */
.dropdown-item:active{
  background: transparent !important;
}

/* arrow style */
.cat-box__arrow{
  opacity: .6;
  font-size: 18px;
}


    </style>
</head>

<body>
    <!-- Top Navbar Start -->
    <!-- Add this in your <head> if not already included -->

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top" style="z-index: 1050;">
    <div class="container px-3 px-md-4">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home.index') }}">
            @if (!$settings || !$settings->logo)
                <img src="{{ asset('images/logos/Image_not_available.jpg') }}" alt="Logo" 
                     class="img-fluid" style="max-height: 60px; width: auto;">
            @else
                <img src="{{ asset($settings->logo) }}" alt="Logo" 
                     class="img-fluid" style="max-height: 60px; width: auto;">
            @endif
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Main content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Categories + static links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
              

                <li class="nav-item">
                    <a class="nav-link px-3 py-3" href="{{ route('home.index') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-3" href="{{ route('allProducts') }}">Shop</a>
                </li>
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle px-3 py-3"
                    href="#"
                    role="button"
                    aria-expanded="false">
                    Categories
                    </a>

                    <ul class="dropdown-menu">
                        @if(!empty($global_categories))
                        @foreach($global_categories as $category)
                            <li>
                                <a class="dropdown-item cat-box"
                                href="{{ route('home.filteredProducts', $category->id) }}">
                                    <span class="cat-box__name">{{ $category->name }}</span>
                                    <span class="cat-box__arrow">&rsaquo;</span>
                                </a>
                            </li>
                        @endforeach
                        @endif
                    </ul>
                </li>


                <li class="nav-item">
                    <a class="nav-link px-3 py-3" href="{{ route('home.about.us') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-3" href="{{ route('home.contact.us') }}">Contact</a>
                </li>
            </ul>

            @php
                use Illuminate\Support\Facades\Auth;
                use App\Models\Cart;

                if (Auth::check()) {
                    // লগইন থাকলে user wise
                    $cartCount1 = Cart::where('user_id', Auth::id())->sum('quantity'); // চাইলে ->count()
                } else {
                    // গেস্ট হলে session wise
                    $cartCount1 = Cart::whereNull('user_id')
                        ->where('session_id', session()->getId())
                        ->sum('quantity'); // চাইলে ->count()
                }
            @endphp


            <!-- Auth / Cart section -->
            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <a href="{{ route('cart.index') }}" class="position-relative text-decoration-none">
                    <button class="btn btn-outline-success position-relative px-4 py-2 rounded-pill">
                        <i class="bi bi-cart3 me-1"></i> Cart
                        @if (!empty($cartCount) && $cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger px-2 py-1 text-white fs-6">
                                {{ $cartCount }}
                            </span>
                        @endif

                    </button>
                </a>
                @auth
                    <!-- Dashboard -->
                     @if(Auth::user()->type == 'admin')
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">
                        <button class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="bi bi-grid-1x2-fill me-1"></i> Dashboard
                        </button>
                    </a>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-primary px-4 py-2 rounded-pill dropdown-toggle"
                                type="button"
                                id="customerMenu"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="bi bi-grid-1x2-fill me-1"></i> {{ auth()->user()->name }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="customerMenu">
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.dashboard') }}">
                                    <i class="bi bi-person-circle me-2"></i> Dashboard
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endif
                @else
                    <a href="{{ route('customer.login') }}" class="text-decoration-none">
                        <button class="btn btn-primary px-4 py-2 rounded-pill fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Account
                        </button>
                    </a>
                @endauth
            </div> 
        </div>
    </div>
</nav>
    <!-- Top Navbar End -->

    <main>
        {{-- alert --}}
        @if (session('success'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; margin-top: 70px;">
                <div class="alert alert-success alert-dismissible fade show shadow" role="alert" id="flashAlert">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; margin-top: 70px;">
                <div class="alert alert-danger alert-dismissible fade show shadow" role="alert" id="flashAlert">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>


 
<footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">

        <div class="row gy-4">
            {{-- ✅ About --}}
            <div class="col-12 col-md-6 col-lg-4 text-center text-md-start">
                <h5 class="fw-bold mb-3">About us</h5>
                <p class="text-white-50 mb-3">
                    We provide high-quality computer components and accessories under the brand
                    <span class="fw-semibold text-white">
                        {{ $settings->company_name ?? '' }}
                    </span>
                </p>

                <ul class="list-unstyled small mb-0">
                    <li class="mb-2 d-flex justify-content-center justify-content-md-start align-items-center gap-2">
                        <i class="bi bi-envelope"></i>
                        <a class="text-white text-decoration-none"
                           href="mailto:{{ $settings->email ?? 'info.wareflowbd@gmail.com' }}">
                            {{ $settings->email ?? 'info.wareflowbd@gmail.com' }}
                        </a>
                    </li>

                    <li class="d-flex justify-content-center justify-content-md-start align-items-center gap-2">
                        <i class="bi bi-telephone"></i>
                        <a class="text-white text-decoration-none"
                           href="tel:{{ $settings->contact_no ?? '+8801789489363' }}">
                            {{ $settings->contact_no ?? '+8801789489363' }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- ✅ Quick Links --}}
            <div class="col-12 col-md-6 col-lg-4 text-center text-md-start">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('home.about.us') }}"
                           class="text-white-50 text-decoration-none d-inline-flex align-items-center gap-2">
                            <i class="bi bi-chevron-right"></i> About
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('home.contact.us') }}"
                           class="text-white-50 text-decoration-none d-inline-flex align-items-center gap-2">
                            <i class="bi bi-chevron-right"></i> Contact
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('allProducts') }}" 
                           class="text-white-50 text-decoration-none d-inline-flex align-items-center gap-2">
                            <i class="bi bi-chevron-right"></i> Shop
                        </a>
                    </li>
                </ul>
            </div>

            {{-- ✅ Social + CTA --}}
            <div class="col-12 col-lg-4 text-center text-lg-start">
                <h5 class="fw-bold mb-3">Follow us</h5>

                <div class="d-flex justify-content-center justify-content-lg-start gap-2 mb-3">
                    <a href="{{ $settings->facebook ?? '#' }}" target="_blank"
                       class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center"
                       style="width:42px;height:42px;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="{{ $settings->instagram ?? '#' }}" target="_blank"
                       class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center"
                       style="width:42px;height:42px;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="{{ $settings->youtube ?? '#' }}" target="_blank"
                       class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center"
                       style="width:42px;height:42px;">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>

                <div class="p-3 rounded-3 bg-black bg-opacity-25">
                    <div class="fw-semibold mb-1">Need help?</div>
                    <div class="small text-white-50 mb-3">
                        Call or email us.
                    </div>

                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center justify-content-lg-start">
                        <a href="tel:{{ $settings->contact_no ?? '+8801789489363' }}"
                           class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-telephone-fill me-1"></i> Call
                        </a>
                        <a href="mailto:{{ $settings->email ?? 'info.wareflowbd@gmail.com' }}"
                           class="btn btn-outline-light btn-sm px-3">
                            <i class="bi bi-envelope me-1"></i> Email
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-light opacity-25 my-4">

        {{-- ✅ Bottom bar --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="mb-0 small text-white-50 text-center text-md-start">
                &copy; {{ date('Y') }} <span class="text-white">{{ $settings->company_name ?? 'WareFlow BD' }}</span>. All rights reserved.
            </p>

            <div class="d-flex gap-3 small">
                <a href="{{ route('home.about.us') }}" class="text-white-50 text-decoration-none">About</a>
                <a href="{{ route('home.contact.us') }}" class="text-white-50 text-decoration-none">Contact</a>
            </div>
        </div>

    </div>
</footer>

    <!-- Footer End -->



    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Js for alert Start --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('flashAlert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }
        });

        window.addEventListener('scroll', () => {
            const nav = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                nav.classList.add('bg-light', 'shadow');
                nav.classList.remove('bg-white');
            } else {
                nav.classList.remove('bg-light', 'shadow');
                nav.classList.add('bg-white');
            }
        });
    </script>

    
    {{-- Js for alert End --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        < script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" >
    </script>

    </script>
</body>

</html>
