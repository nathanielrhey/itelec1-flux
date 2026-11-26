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
    <header class="topbar">
        <div class="container topbar-inner">
            <a href="{{ route('home') }}" class="brand">
                <img src="{{ asset('images/flux-icon.png') }}" alt="FLUX Pet Shop Logo" class="brand-logo">
                <span class="brand-text">
                    <span>FLUX</span>
                    <span class="brand-sub">Pet Shop</span>
                </span>
            </a>

            <nav class="nav" aria-label="Main navigation">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>
                <a href="{{ route('catalog') }}" class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}">
                    Catalog
                </a>
                <a href="{{ route('orders.create') }}" class="nav-link {{ request()->routeIs('orders.create') ? 'active' : '' }}">
                    Place Order
                </a>
                <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    Orders
                </a>
                <a href="{{ route('orders.status') }}" class="nav-link {{ request()->routeIs('orders.show') ? 'active' : '' }}">
                    Order Status
                    @if (session('last_order_reference'))
                        <span class="badge badge-info">{{ session('last_order_reference') }}</span>
                    @endif
                </a>
            </nav>
        </div>

        @if (session()->has('visitor_name') || session()->has('last_order_reference'))
            <div class="session-bar">
                <div class="container session-bar-inner">
                    <div class="session-details">
                        @if (session('visitor_name'))
                            <span>Welcome back, <strong>{{ session('visitor_name') }}</strong></span>
                        @endif
                        @if (session('last_order_reference') && session('last_order_id'))
                            <span>
                                Latest Reference:
                                <a href="{{ route('orders.show', session('last_order_id')) }}">
                                    <strong>{{ session('last_order_reference') }}</strong>
                                </a>
                            </span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('session.forget') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">Clear Session</button>
                    </form>
                </div>
            </div>
        @endif
    </header>

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
