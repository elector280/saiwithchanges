<header class="sai-header">

    {{-- TOP MINI BAR (EMAIL / PHONE / WHATSAPP) --}}
    <div class="topbar d-none d-md-block">
        <div class="container-xxl d-flex justify-content-end align-items-center gap-4">

            <div class="topbar-item">
                Email <a href="mailto:Donate@Sai.ngo">Donate@Sai.ngo</a>
            </div>

            <div class="topbar-item">
                Call Us <span class="topbar-phone">(800) 563-6099</span>
            </div>

            <div class="topbar-item d-flex align-items-center gap-1">
                Whatsapp >
                <span class="whatsapp-flag flag-red"></span>
                <span class="whatsapp-flag flag-white"></span>
            </div>
        </div>
    </div>

    {{-- MAIN RED HEADER BAR --}}
    <div class="sai-main-header">
        <div class="container-xxl d-flex align-items-stretch">

            {{-- LOGO + BLUE/YELLOW STRIPES --}}
            <a href="{{ url('/') }}" class="sai-logo-wrap d-flex align-items-stretch">
                <div class="sai-logo-box d-flex align-items-center">
                    <img src="{{ asset('images/logo-sai.png') }}"
                         alt="South American Initiative"
                         class="sai-logo-img">
                </div>
                <div class="sai-logo-stripe sai-logo-stripe-blue"></div>
                <div class="sai-logo-stripe sai-logo-stripe-yellow"></div>
            </a>

            {{-- NAVIGATION + DONATE --}}
            <nav class="sai-nav flex-grow-1 d-flex align-items-center justify-content-between">

                {{-- DESKTOP MENU --}}
                <ul class="sai-menu d-none d-lg-flex">
                    <li>
                        <a class="@yield('nav_home')" href="{{ url('/') }}">HOME</a>
                    </li>
                    <li>
                        <a class="@yield('nav_about')" href="#about">ABOUT US</a>
                    </li>

                    <li class="has-dropdown">
                        <a class="@yield('nav_campaigns')" href="#campaigns">
                            CAMPAIGNS ▾
                        </a>
                        <ul class="sai-submenu">
                            <li><a href="#campaigns">All Campaigns</a></li>
                            <li><a href="#campaigns">Medical Program</a></li>
                            <li><a href="#campaigns">Orphans</a></li>
                            <li><a href="#campaigns">Animals</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="@yield('nav_news')" href="#news">NEWS</a>
                    </li>

                    <li class="has-dropdown">
                        <a class="@yield('nav_help')" href="#help">
                            HELP MORE ▾
                        </a>
                        <ul class="sai-submenu">
                            <li><a href="#volunteer">Start Volunteering</a></li>
                            <li><a href="#sponsor">Become Sponsor</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="@yield('nav_contact')" href="#contact">CONTACT US</a>
                    </li>
                </ul>

                {{-- MOBILE TOGGLE (very simple) --}}
                <button class="sai-mobile-toggle d-lg-none" type="button">
                    ☰
                </button>

                {{-- DONATE BUTTON --}}
                <a href="#donate" class="btn sai-donate-btn">
                    DONATE >
                </a>
            </nav>
        </div>
    </div>

    {{-- MOBILE MENU (SHOWN WHEN TOGGLER CLICKED) --}}
    <div class="sai-mobile-menu d-lg-none">
        <ul class="sai-menu-mobile">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#campaigns">Campaigns</a></li>
            <li><a href="#news">News</a></li>
            <li><a href="#help">Help More</a></li>
            <li><a href="#contact">Contact Us</a></li>
        </ul>
    </div>
</header>
