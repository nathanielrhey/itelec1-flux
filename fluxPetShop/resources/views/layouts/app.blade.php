<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'fluxPetShop')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/flux-icon.png') }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @include('layouts.styles')
</head>
<body>
    @include('layouts.nav')

    <main class="container main-content">
        @if (session('success'))
            <div class="alert alert-success" role="status">
                <strong>Success:</strong> {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info" role="status">
                {{ session('info') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            fluxPetShop &middot; Group flux (IT-ELEC 1 Final Project)
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
