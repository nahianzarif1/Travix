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
            $flightBookings = [
              ['id'=> 'FL12345','pnr'=>'ABCD12','airline'=>'Biman Bangladesh','from'=>'DAC','to'=>'CXB','date'=>'2025-10-09','departure'=>'08:30','arrival'=>'09:45','passengers'=>2,'status'=>'confirmed','amount'=>17000],
              ['id'=> 'FL12346','pnr'=>'EFGH34','airline'=>'US-Bangla','from'=>'DAC','to'=>'ZYL','date'=>'2025-10-12','departure'=>'14:15','arrival'=>'15:25','passengers'=>1,'status'=>'pending','amount'=>7800],
            ];
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
                      <div class="fw-semibold">{{ $booking['airline'] }}</div>
                      <div class="text-muted small">Booking ID: {{ $booking['id'] }} • PNR: {{ $booking['pnr'] }}</div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    @if($booking['status'] === 'confirmed')
                      <span class="badge bg-success">Confirmed</span>
                    @elseif($booking['status'] === 'pending')
                      <span class="badge bg-warning text-dark">Pending</span>
                    @else
                      <span class="badge bg-secondary">{{ ucfirst($booking['status']) }}</span>
                    @endif
                  </div>
                </div>
                <div class="row g-3 mt-2">
                  <div class="col-md-4">
                    <div class="fw-medium mb-1">Flight Details</div>
                    <div class="text-muted small">From → To: {{ $booking['from'] }} → {{ $booking['to'] }}</div>
                    <div class="text-muted small">Date: {{ $booking['date'] }}</div>
                    <div class="text-muted small">Time: {{ $booking['departure'] }} - {{ $booking['arrival'] }}</div>
                    <div class="text-muted small">Passengers: {{ $booking['passengers'] }}</div>
                  </div>
                  <div class="col-md-4">
                    <div class="fw-medium mb-1">Booking Info</div>
                    <div class="text-muted small">Total Amount: <span class="fw-semibold text-success">৳{{ number_format($booking['amount']) }}</span></div>
                  </div>
                  <div class="col-md-4 d-flex flex-column gap-2">
                    <button class="btn btn-light btn-sm">Download Ticket</button>
                    @if($booking['status'] === 'confirmed')
                      <button class="btn btn-outline-secondary btn-sm">Modify Booking</button>
                    @elseif($booking['status'] === 'pending')
                      <button class="btn btn-danger btn-sm">Cancel Booking</button>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="tab-pane fade" id="tab-hotels" role="tabpanel">
          @php
            $hotelBookings = [
              ['id'=>'HT6789','hotel'=>'Pan Pacific Sonargaon','image'=>'https://images.unsplash.com/photo-1613508999265-2acab7209645?q=80&w=800','location'=>'Dhaka','checkIn'=>'2025-10-20','checkOut'=>'2025-10-22','guests'=>2,'rooms'=>1,'status'=>'confirmed','amount'=>30000],
            ];
          @endphp
          <div class="vstack gap-3">
            @foreach ($hotelBookings as $booking)
              <div class="border rounded-3 p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                  <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:#eaf7ea;">🏨</div>
                    <div>
                      <div class="fw-semibold">{{ $booking['hotel'] }}</div>
                      <div class="text-muted small">Booking ID: {{ $booking['id'] }}</div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">Confirmed</span>
                  </div>
                </div>
                <div class="row g-3 mt-2 align-items-center">
                  <div class="col-md-3"><img src="{{ $booking['image'] }}" class="w-100 rounded-3" style="height:80px;object-fit:cover;" alt="{{ $booking['hotel'] }}"></div>
                  <div class="col-md-3">
                    <div class="fw-medium mb-1">Stay Details</div>
                    <div class="text-muted small">{{ $booking['location'] }}</div>
                    <div class="text-muted small">{{ $booking['checkIn'] }} - {{ $booking['checkOut'] }}</div>
                    <div class="text-muted small">{{ $booking['guests'] }} Guests, {{ $booking['rooms'] }} Rooms</div>
                  </div>
                  <div class="col-md-3">
                    <div class="fw-medium mb-1">Booking Info</div>
                    <div class="text-muted small">Total Amount: <span class="fw-semibold text-success">৳{{ number_format($booking['amount']) }}</span></div>
                  </div>
                  <div class="col-md-3 d-flex flex-column gap-2">
                    <button class="btn btn-light btn-sm">Download Voucher</button>
                    <button class="btn btn-outline-secondary btn-sm">Modify Booking</button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="tab-pane fade" id="tab-tours" role="tabpanel">
          @php
            $tourBookings = [
              ['id'=>'TR4455','tour'=>'Cox\'s Bazar Beach Paradise','image'=>'https://images.unsplash.com/photo-1658076798013-654fb97e3111?q=80&w=800','duration'=>'3D2N','startDate'=>'2025-11-01','endDate'=>'2025-11-03','participants'=>4,'status'=>'confirmed','amount'=>60000],
            ];
          @endphp
          <div class="vstack gap-3">
            @foreach ($tourBookings as $booking)
              <div class="border rounded-3 p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                  <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:#fff3e6;">🎒</div>
                    <div>
                      <div class="fw-semibold">{{ $booking['tour'] }}</div>
                      <div class="text-muted small">Booking ID: {{ $booking['id'] }}</div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success">Confirmed</span>
                  </div>
                </div>
                <div class="row g-3 mt-2 align-items-center">
                  <div class="col-md-3"><img src="{{ $booking['image'] }}" class="w-100 rounded-3" style="height:80px;object-fit:cover;" alt="{{ $booking['tour'] }}"></div>
                  <div class="col-md-3">
                    <div class="fw-medium mb-1">Tour Details</div>
                    <div class="text-muted small">Duration: {{ $booking['duration'] }}</div>
                    <div class="text-muted small">{{ $booking['startDate'] }} - {{ $booking['endDate'] }}</div>
                    <div class="text-muted small">{{ $booking['participants'] }} Participants</div>
                  </div>
                  <div class="col-md-3">
                    <div class="fw-medium mb-1">Booking Info</div>
                    <div class="text-muted small">Total Amount: <span class="fw-semibold text-success">৳{{ number_format($booking['amount']) }}</span></div>
                  </div>
                  <div class="col-md-3 d-flex flex-column gap-2">
                    <button class="btn btn-light btn-sm">Download Voucher</button>
                    <button class="btn btn-outline-secondary btn-sm">View Itinerary</button>
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
