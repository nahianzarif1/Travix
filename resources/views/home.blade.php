@extends('layouts.app')

@section('content')
<div>
    <!-- TOP NAV -->
    <div class="bg-white border-bottom shadow-sm topbar">
        <div class="container-fluid d-flex align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="h5 fw-bold mb-0">TRAVIX</div>
                <small class="text-muted">Travel Management BD</small>
            </div>
            <nav class="nav" role="navigation" aria-label="Main navigation">
                <a href="#" class="nav-link sidebar-link active" data-view="dashboard">Dashboard</a>
                <a href="#" class="nav-link sidebar-link" data-view="flights">Flights</a>
                <a href="#" class="nav-link sidebar-link" data-view="hotels">Hotels</a>
                <a href="#" class="nav-link sidebar-link" data-view="packages">Packages</a>
                <a href="#" class="nav-link sidebar-link" data-view="map">Map</a>
                <a href="#" class="nav-link sidebar-link" data-view="bookings">Bookings</a>
                <a href="#" class="nav-link sidebar-link" data-view="payments">Payments</a>
                <a href="{{ route('payment.history') }}" class="nav-link sidebar-link">Payment History</a>
            </nav>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted d-none d-md-inline">Signed in as: <strong>{{ auth()->user()->name ?? 'Guest' }}</strong></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Page header under nav -->
    <div class="container-fluid d-flex justify-content-between align-items-center p-3">
        <div>
            <h5 id="viewTitle" class="mb-0">Dashboard</h5>
            <small class="text-muted">Welcome back, {{ auth()->user()->name ?? 'User' }}</small>
        </div>
    </div>

    <!-- Content area -->
    <div class="p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
            <!-- Dashboard overview (default) -->
            <div id="section-dashboard" class="dashboard-section">
                @include('dashboard.sections.overview')
            </div>

            <!-- Flight booking -->
            <div id="section-flights" class="dashboard-section" style="display:none;">
                @include('dashboard.sections.flight_booking')
            </div>

            <!-- Hotel booking -->
            <div id="section-hotels" class="dashboard-section" style="display:none;">
                @include('dashboard.sections.hotel_booking')
            </div>

            <!-- Tour packages -->
            <div id="section-packages" class="dashboard-section" style="display:none;">
                @include('dashboard.sections.packages')
            </div>

            <!-- Map -->
            <div id="section-map" class="dashboard-section" style="display:none;">
                @include('dashboard.sections.map')
            </div>

            <!-- My bookings -->
            <div id="section-bookings" class="dashboard-section" style="display:none;">
                @include('dashboard.sections.bookings')
            </div>

            <!-- Payments -->
            <div id="section-payments" class="dashboard-section" style="display:none;">
                @php
                    $user = auth()->user();
                    $pendingBookings = \App\Models\Booking::where('user_id', $user->id)
                        ->where('status', 'confirmed')
                        ->whereDoesntHave('paymentItems')
                        ->get();
                    
                    $flightTotal = $pendingBookings->where('type', 'flight')->sum('amount');
                    $hotelTotal = $pendingBookings->where('type', 'hotel')->sum('amount');
                    $tourTotal = $pendingBookings->where('type', 'tour')->sum('amount');
                    $grandTotal = $flightTotal + $hotelTotal + $tourTotal;
                @endphp
                @include('dashboard.sections.payments', compact('pendingBookings', 'flightTotal', 'hotelTotal', 'tourTotal', 'grandTotal'))
            </div>
        </div>
    </div>
</div>

<!-- Inline JS to switch views (client-side, like your React activeView logic) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.sidebar-link');
    const sections = document.querySelectorAll('.dashboard-section');
    const titleEl = document.getElementById('viewTitle');

    function setActive(view) {
        // toggle active link
        links.forEach(l => {
            if (l.dataset.view === view) l.classList.add('active');
            else l.classList.remove('active');
        });

        // show/hide sections
        sections.forEach(s => {
            s.style.display = (s.id === 'section-' + view) ? 'block' : 'none';
        });

        // update title (human readable)
        const pretty = view === 'dashboard' ? 'Dashboard' : view.replace('-', ' ').replace(/\b\w/g, c => c.toUpperCase());
        titleEl.innerText = pretty;

        // update url hash for bookmarking/back
        history.replaceState(null, '', '#' + view);

        // notify sections about view changes (needed for Leaflet sizing)
        try {
            window.dispatchEvent(new CustomEvent('travix:view', { detail: { view } }));
            if (view === 'map') {
                // defer to allow layout to paint before sizing map
                setTimeout(() => window.dispatchEvent(new Event('travix:map:show')), 50);
            }
        } catch (e) {}
    }

    // click handlers
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const view = this.dataset.view;
            setActive(view);
        });
    });

    // initialize from hash or dashboard default
    const initial = location.hash ? location.hash.replace('#','') : 'dashboard';
    setActive(initial);
});
</script>
@endsection


