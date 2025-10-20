<div class="space-y-4 container-fluid py-2">
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <h5 class="mb-1 d-flex align-items-center gap-2">🏨 Find Hotels & Resorts</h5>
            <p class="text-muted mb-4">Discover comfortable accommodations across Bangladesh</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('hotels.search') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Location</label>
                    <select name="location" class="form-select form-control-soft">
                        <option value="">Select City</option>
                        <option value="Dhaka" {{ old('location') == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                        <option value="Cox's Bazar" {{ old('location') == "Cox's Bazar" ? 'selected' : '' }}>Cox's Bazar</option>
                        <option value="Chittagong" {{ old('location') == 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                        <option value="Sylhet" {{ old('location') == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                        <option value="Rangamati" {{ old('location') == 'Rangamati' ? 'selected' : '' }}>Rangamati</option>
                        <option value="Kuakata" {{ old('location') == 'Kuakata' ? 'selected' : '' }}>Kuakata</option>
                        <option value="Bandarban" {{ old('location') == 'Bandarban' ? 'selected' : '' }}>Bandarban</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Check-in</label>
                    <input type="date" name="check_in" class="form-control form-control-soft" value="{{ old('check_in') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Check-out</label>
                    <input type="date" name="check_out" class="form-control form-control-soft" value="{{ old('check_out') }}">
                </div>
                
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-search me-1"></i> Search</button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($hotelSearchResults))
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="mb-0 fw-bold">Available Hotels</h6>
                    <small class="text-muted">{{ $hotelSearchResults->count() }} hotels found for your search</small>
                </div>
            </div>
            <div class="vstack gap-4">
                @forelse($hotelSearchResults as $hotel)
                    <div class="border rounded-3 p-3 hover-bg-soft">
                        <div class="d-flex align-items-start gap-3 flex-wrap">
                            <div class="position-relative">
                                <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="rounded-3" style="width:180px;height:120px;object-fit:cover;">
                                <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 rounded-circle"><i class="bi bi-heart"></i></button>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-semibold mb-0">{{ $hotel->name }}</h6>
                                        <small class="text-muted d-flex align-items-center gap-2"><i class="bi bi-geo-alt"></i> {{ $hotel->location }} <span class="badge bg-light text-dark">{{ $hotel->category }}</span></small>
                                    </div>
                                    @php
                                        $checkInDate = \Carbon\Carbon::parse(old('check_in'));
                                        $checkOutDate = \Carbon\Carbon::parse(old('check_out'));
                                        $nights = $checkInDate->diffInDays($checkOutDate);
                                        $guests = old('guests', 1);
                                        // Simple price logic: price per night * number of nights. You can add guest/room logic here.
                                        $totalPrice = $hotel->price * $nights;
                                    @endphp
                                    <div class="text-end">
                                        <div class="fw-bold fs-5 text-success">৳{{ number_format($totalPrice) }}</div>
                                        <small class="text-muted">for {{ $nights }} {{ $nights > 1 ? 'nights' : 'night' }}</small>
                                    </div>
                                </div>
                                <p class="text-muted small mb-2">{{ $hotel->description }}</p>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    <span class="fw-medium">{{ $hotel->rating }}</span>
                                    <small class="text-muted ms-1">({{ $hotel->reviews }} reviews)</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="small text-muted d-flex flex-wrap gap-2">
                                        @foreach(array_slice($hotel->amenities, 0, 5) as $a)
                                            <span class="badge bg-light text-dark">{{ $a }}</span>
                                        @endforeach
                                        @if(count($hotel->amenities) > 5)
                                            <span class="text-muted small">+{{ count($hotel->amenities) - 5 }} more</span>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('bookings.hotel') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                        <input type="hidden" name="guests" value="{{ old('guests') }}">
                                        <input type="hidden" name="rooms" value="1"> <input type="hidden" name="check_in" value="{{ old('check_in') }}">
                                        <input type="hidden" name="check_out" value="{{ old('check_out') }}">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-building me-1"></i>Book Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted">No hotels found for your search criteria.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif
</div>