@extends('layouts.app')

@section('content')
<div>
    <!-- TOP NAV -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="h4 fw-bold text-primary mb-0 me-2">✈️ TRAVIX</div>
                <small class="text-muted d-none d-md-inline">Travel Management</small>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link sidebar-link active" data-view="dashboard">
                            <i class="bi bi-house-door me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link sidebar-link" data-view="flights">
                            <i class="bi bi-airplane me-1"></i>Flights
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link sidebar-link" data-view="hotels">
                            <i class="bi bi-building me-1"></i>Hotels
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link sidebar-link" data-view="packages">
                            <i class="bi bi-bag me-1"></i>Packages
                        </a>
                    </li>
                    <li class="nav-item">
        <a href="#" class="nav-link sidebar-link" data-view="map">
            <i class="bi bi-geo-alt me-1"></i>Map
        </a>
    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link sidebar-link" data-view="bookings">
                            <i class="bi bi-journal-text me-1"></i>My Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link sidebar-link" data-view="payments">
                            <i class="bi bi-credit-card me-1"></i>Payments
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name ?? 'Guest' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('payment.history') }}"><i class="bi bi-clock-history me-2"></i>Payment History</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-gear me-2"></i>Admin Panel</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

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


