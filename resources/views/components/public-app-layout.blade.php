<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @hasSection('title')
                @yield('title') - The Bird Project
            @else
                The Bird Project
            @endif
        </title>

        <!-- Favicon and identity 
            realfavicongenerator.net
        -->
        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
        <meta name="apple-mobile-web-app-title" content="The Bird Project" />
        <link rel="manifest" href="/site.webmanifest" />

        <!-- Scripts -->

        <meta property="csp-nonce" content="{{ csp_nonce() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        @stack('preload')
    </head>
    <body class="flex flex-col min-h-screen font-sans antialiased bg-gray-300 dark:bg-gray-600">
        <!-- Skip to main content link 
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 bg-white text-black px-4 py-2 rounded shadow">
            Skip to main content
        </a>-->
        <div class="">
            <!-- Admin/Public Navbar choosing -->
           @if ( request()->is('admin*') )
                @include('layouts.admin-nav')
            @else
                @include('layouts.public-nav')
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-700">
                    <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <!-- Page Content -->
            <main id="main-content" class="bg-gray-200 dark:bg-gray-600">
                {{ $slot }}
            </main>
        </div>
          @stack('scripts')
    </body>
    <x-footer />
</html>
