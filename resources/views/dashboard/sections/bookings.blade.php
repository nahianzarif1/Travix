<div class="card p-4">
  <h4 class="mb-3">My Bookings</h4>

  @php
    $hasBookingsTable = \Illuminate\Support\Facades\Schema::hasTable('bookings');
  @endphp

  @if($hasBookingsTable && auth()->check())
    @php
      $userBookings = \DB::table('bookings')->where('user_id', auth()->id())->orderBy('created_at','desc')->limit(20)->get();
    @endphp

    @if($userBookings->count() === 0)
      <div class="alert alert-info">You have no bookings yet.</div>
    @else
      <div class="table-responsive">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>Booking ID</th>
              <th>Type</th>
              <th>Details</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($userBookings as $b)
              <tr>
                <td>{{ $b->id }}</td>
                <td>{{ $b->type ?? '—' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($b->details ?? '—', 60) }}</td>
                <td>{{ $b->created_at }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  @else
    <div class="alert alert-secondary">
      No bookings table detected or you're not logged in. To show real bookings, add a `bookings` table with `user_id` and `details`, or run the migrations that create it.
    </div>
  @endif
</div>
