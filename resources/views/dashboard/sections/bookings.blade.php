<div class="container-fluid">
  <div class="card border-0 shadow-3d">
    <div class="card-body p-4">
      <h5 class="mb-1">My Bookings</h5>
      <small class="text-muted">Manage and track all your travel bookings</small>

      <ul class="nav nav-tabs mt-3" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-flights" type="button" role="tab">Flights</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-hotels" type="button" role="tab">Hotels</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-tours" type="button" role="tab">Tours</button>
        </li>
      </ul>

      <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="tab-flights" role="tabpanel">
          @php
            $flightBookings = \App\Models\Booking::where('type', 'flight')->where('user_id', auth()->id())->get();
          @endphp
          <div class="vstack gap-3">
            @foreach ($flightBookings as $booking)
              <div class="border rounded-3 p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                  <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:#e9f3ff;">
                      ✈️
                    </div>
                    <div>
                      <div class="fw-semibold">{{ $booking->details['airline'] }}</div>
                      <div class="text-muted small">Booking ID: {{ $booking->reference }} • PNR: {{ $booking->details['pnr'] }}</div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    @if($booking->status === 'confirmed')
                      <span class="badge bg-success">Confirmed</span>
                    @elseif($booking->status === 'pending')
                      <span class="badge bg-warning text-dark">Pending</span>
                    @else
                      <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                    @endif
                  </div>
                </div>
                <div class="row g-3 mt-2">
                  <div class="col-md-4">
                    <div class="fw-medium mb-1">Flight Details</div>
                    <div class="text-muted small">From → To: {{ $booking->details['from'] }} → {{ $booking->details['to'] }}</div>
                    <div class="text-muted small">Date: {{ $booking->details['date'] }}</div>
                    <div class="text-muted small">Time: {{ $booking->details['departure'] }} - {{ $booking->details['arrival'] }}</div>
                    <div class="text-muted small">Passengers: {{ $booking->details['passengers'] }}</div>
                  </div>
                  <div class="col-md-4">
                    <div class="fw-medium mb-1">Booking Info</div>
                    <div class="text-muted small">Total Amount: <span class="fw-semibold text-success">৳{{ number_format($booking->amount) }}</span></div>
                  </div>
                  <div class="col-md-4 d-flex flex-column gap-2">
                   
        
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="tab-pane fade" id="tab-hotels" role="tabpanel">
          @php
            $hotelBookings = \App\Models\Booking::where('type', 'hotel')->where('user_id', auth()->id())->get();
          @endphp
          <div class="vstack gap-3">
            @foreach ($hotelBookings as $booking)
              <div class="border rounded-3 p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                  <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:#eaf7ea;">🏨</div>
                    <div>
                      <div class="fw-semibold">{{ $booking->details['hotel'] }}</div>
                      <div class="text-muted small">Booking ID: {{ $booking->reference }}</div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">Confirmed</span>
                  </div>
                </div>
                <div class="row g-3 mt-2 align-items-center">
                  <div class="col-md-3"><img src="{{ $booking->details['image'] }}" class="w-100 rounded-3" style="height:80px;object-fit:cover;" alt="{{ $booking->details['hotel'] }}"></div>
                  <div class="col-md-3">
                    <div class="fw-medium mb-1">Stay Details</div>
                    <div class="text-muted small">{{ $booking->details['location'] }}</div>
                    <div class="text-muted small">{{ $booking->details['checkIn'] }} - {{ $booking->details['checkOut'] }}</div>
                    <div class="text-muted small">{{ $booking->details['guests'] }} Guests, {{ $booking->details['rooms'] }} Rooms</div>
                  </div>
                  <div class="col-md-3">
                    <div class="fw-medium mb-1">Booking Info</div>
                    <div class="text-muted small">Total Amount: <span class="fw-semibold text-success">৳{{ number_format($booking->amount) }}</span></div>
                  </div>
                  <div class="col-md-3 d-flex flex-column gap-2">
                   
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="tab-pane fade" id="tab-tours" role="tabpanel">
          @php
            $tourBookings = \App\Models\Booking::where('type', 'tour')->where('user_id', auth()->id())->get();
          @endphp
          <div class="vstack gap-3">
            @foreach ($tourBookings as $booking)
              <div class="border rounded-3 p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                  <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:#fff3e6;">🎒</div>
                    <div>
                      <div class="fw-semibold">{{ $booking->details['tour'] }}</div>
                      <div class="text-muted small">Booking ID: {{ $booking->reference }}</div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">Confirmed</span>
                  </div>
                </div>
                <div class="row g-3 mt-2 align-items-center">
                  <div class="col-md-3"><img src="{{ $booking->details['image'] }}" class="w-100 rounded-3" style="height:80px;object-fit:cover;" alt="{{ $booking->details['tour'] }}"></div>
                  <div class="col-md-3">
                    <div class="fw-medium mb-1">Tour Details</div>
                    <div class="text-muted small">Duration: {{ $booking->details['duration'] }}</div>
                    <div class="text-muted small">{{ $booking->details['startDate'] }} - {{ $booking->details['endDate'] }}</div>
                    <div class="text-muted small">{{ $booking->details['participants'] }} Participants</div>
                  </div>
                  <div class="col-md-3">
                    <div class="fw-medium mb-1">Booking Info</div>
                    <div class="text-muted small">Total Amount: <span class="fw-semibold text-success">৳{{ number_format($booking->amount) }}</span></div>
                  </div>
                  <div class="col-md-3 d-flex flex-column gap-2">
                    
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
