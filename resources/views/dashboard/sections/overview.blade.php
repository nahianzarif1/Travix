
<div class="container-fluid">
  <div class="row gy-4">
    <div class="col-12">
      <div class="card border-0 shadow-3d">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-0">Dashboard</h5>
            <small class="text-muted">Welcome, {{ auth()->user()->name ?? 'User' }}</small>
          </div>
          <div class="d-flex gap-2">
            <a href="#" class="btn btn-light btn-sm sidebar-link" data-view="flights">Flights</a>
            <a href="#" class="btn btn-light btn-sm sidebar-link" data-view="hotels">Hotels</a>
            <a href="#" class="btn btn-light btn-sm sidebar-link" data-view="packages">Packages</a>
            <a href="#" class="btn btn-light btn-sm sidebar-link" data-view="map">Map</a>
            <a href="#" class="btn btn-light btn-sm sidebar-link" data-view="bookings">Bookings</a>
            <a href="#" class="btn btn-light btn-sm sidebar-link" data-view="payments">Payments</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="col-md-3">
      <div class="card p-3">
        <small class="text-muted">Total Bookings</small>
        <div class="h3 fw-bold mt-2">
          @php
            $totalBookings = \App\Models\Booking::count();
          @endphp
          {{ $totalBookings }}
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <small class="text-muted">My Bookings</small>
        <div class="h3 fw-bold mt-2">
          @php
            $myBookings = \App\Models\Booking::where('user_id', auth()->id())->count();
          @endphp
          {{ $myBookings }}
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <small class="text-muted">Packages</small>
        <div class="h3 fw-bold mt-2">
          @php
            $packagesCount = \App\Models\Package::count();
          @endphp
          {{ $packagesCount }}
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <small class="text-muted">Pending Requests</small>
        <div class="h3 fw-bold mt-2">—</div>
      </div>
    </div>

    <div class="col-12">
      <div class="card p-3">
        <h6 class="mb-1">Recent activity</h6>
        <p class="text-muted mb-0">No recent activity data available — integrate bookings/transactions to populate this area.</p>
      </div>
    </div>
  </div>
</div>
