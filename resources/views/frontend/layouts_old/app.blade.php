<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'South American Initiative')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap core --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Main site CSS with cache-busting --}}
    @php
        $mainCssPath = public_path('css/app.css');
        $mainCssVer  = file_exists($mainCssPath) ? filemtime($mainCssPath) : time();
    @endphp
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ $mainCssVer }}">

    @stack('styles')
</head>
<body class="@yield('body_class', '')">

    {{-- HEADER --}}
    @include('frontend.layouts.partials.header')

    {{-- MAIN CONTENT --}}
    <main class="sai-main-content">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('frontend.layouts.partials.footer')

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Site JS (smooth scroll, dropdown, mobile menu, etc.) --}}
    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>

    @stack('scripts')
</body>
</html>
