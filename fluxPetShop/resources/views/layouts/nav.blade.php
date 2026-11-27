<header class="topbar">
    <div class="container topbar-inner">
        <a href="{{ route('home') }}" class="brand">
            <img src="{{ asset('images/flux-icon.png') }}" alt="FLUX Pet Shop Logo" class="brand-logo">
            <span class="brand-text">
                <span>FLUX</span>
                <span class="brand-sub">Pet Shop</span>
            </span>
        </a>

        <button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="main-nav">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="nav" id="main-nav" aria-label="Main navigation">
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
            <a href="{{ route('contact.create') }}" class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                Contact Us
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                Admin
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

@push('scripts')
    <script>
        (function () {
            var toggle = document.getElementById('nav-toggle');
            var nav    = document.getElementById('main-nav');
            if (!toggle || !nav) return;

            toggle.addEventListener('click', function () {
                var open = nav.classList.toggle('nav-open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.classList.toggle('is-open', open);
            });

            nav.querySelectorAll('.nav-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    nav.classList.remove('nav-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.classList.remove('is-open');
                });
            });

            document.addEventListener('click', function (e) {
                if (!nav.contains(e.target) && !toggle.contains(e.target)) {
                    nav.classList.remove('nav-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.classList.remove('is-open');
                }
            });
        })();
    </script>
@endpush
