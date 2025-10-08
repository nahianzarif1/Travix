<div class="row gy-4">
  <div class="col-12">
    <div class="card p-4">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-0">Dashboard Overview</h4>
          <small class="text-muted">Quick summary of your Travix account</small>
        </div>
        <div class="text-end">
          <small class="text-muted">Welcome, {{ auth()->user()->name ?? 'User' }}</small>
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
          $totalBookings = \Illuminate\Support\Facades\Schema::hasTable('bookings') ? \DB::table('bookings')->count() : 0;
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
          $myBookings = \Illuminate\Support\Facades\Schema::hasTable('bookings') && auth()->check()
                        ? \DB::table('bookings')->where('user_id', auth()->id())->count()
                        : 0;
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
          $packagesCount = \Illuminate\Support\Facades\Schema::hasTable('packages') ? \DB::table('packages')->count() : 0;
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
      <h5 class="mb-1">Recent activity</h5>
      <p class="text-muted mb-0">No recent activity data available — integrate bookings/transactions to populate this area.</p>
    </div>
  </div>
</div>
