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
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <meta property="csp-nonce" content="{{ csp_nonce() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

<body class="relative font-sans antialiased min-h-screen overflow-hidden">
  @yield('content')
</body>
</html>
