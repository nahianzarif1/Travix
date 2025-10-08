@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- SIDEBAR -->
    <aside id="appSidebar" class="d-flex flex-column p-4 text-white"
           style="width:260px; min-height:100vh; position:fixed; background: linear-gradient(180deg,#003973,#00aaff);">
        <a href="{{ url('/') }}" class="text-white text-decoration-none mb-4">
            <div class="h4 fw-bold mb-0">TRAVIX</div>
            <small class="text-white-50">Travel Management BD</small>
        </a>

        <nav class="nav flex-column mb-4" role="navigation" aria-label="Main navigation">
            <a href="#" class="nav-link sidebar-link active text-white py-2" data-view="dashboard">Dashboard</a>
            <a href="#" class="nav-link sidebar-link text-white py-2" data-view="flights">Flight Booking</a>
            <a href="#" class="nav-link sidebar-link text-white py-2" data-view="hotels">Hotel Booking</a>
            <a href="#" class="nav-link sidebar-link text-white py-2" data-view="packages">Tour Packages</a>
            <a href="#" class="nav-link sidebar-link text-white py-2" data-view="map">Explore Map</a>
            <a href="#" class="nav-link sidebar-link text-white py-2" data-view="bookings">My Bookings</a>
        </nav>

        <div class="mt-auto text-white-50 small">
            © {{ date('Y') }} Travix
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main style="margin-left:260px; width:calc(100% - 260px); min-height:100vh;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center bg-white border-bottom p-3 shadow-sm">
            <div>
                <h5 id="viewTitle" class="mb-0">Dashboard</h5>
                <small class="text-muted">Welcome back, {{ auth()->user()->name ?? 'User' }}</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted me-2 d-none d-md-inline">Signed in as: <strong>{{ auth()->user()->name ?? 'Guest' }}</strong></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>

        <!-- Content area -->
        <div class="p-4">
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
        </div>
    </main>
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
