<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- INCLUDE TAILWIND CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- RECEIVE SECTION: TITLE --}}
    <title>@yield('title') | {{ $sitename }}</title>

    {{-- INCLUDE SOME CUSTOM STYLES --}}
    @include('partials.styles')

    <!-- glightbox: img/vid gallery -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    {{-- slider --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css">
</head>
<body style="background-color: var(--bg);" class="flex flex-col h-[100vh] text-[var(--accent)] font-mono">

    <main class="flex-1 pb-[100px]">
        {{-- INCLUDE HEADER --}}
        @include('partials.header')

        {{-- RECEIVE SECTION: MAIN CONTENT --}}
        @yield('content')
    </main>

    {{-- INCLUDE FOOTER --}}
    @include('partials.footer')

    {{-- JS: show now time --}}
    {{-- @include('partials.js_show_now_time') --}}

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
</body>
</html>