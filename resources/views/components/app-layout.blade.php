<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') - British Birds
        @else
            British Birds
        @endif
    </title>

    <!-- Favicon and identity -->
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="British Birds" />
    <link rel="manifest" href="/site.webmanifest" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Skip to main content link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 bg-white text-black px-4 py-2 rounded shadow">
        Skip to main content
    </a>

    @php
        // Automatically detect if current route is admin
        $isAdmin = request()->is('admin*') || Str::startsWith(Route::currentRouteName() ?? '', 'admin.');
    @endphp

    <div class="bg-gray-400 dark:bg-gray-900">
        {{-- Navigation --}}
        @if ($isAdmin)
            @include('layouts.admin-nav')
        @else
            @include('layouts.public-nav')
        @endif

        {{-- Page Heading --}}
        @isset($header)
            <header class="bg-white dark:bg-gray-700 shadow">
                <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Main content --}}
        <main id="main-content">
            {{ $slot }}
        </main>
    </div>

    <x-footer />
</body>
</html>
