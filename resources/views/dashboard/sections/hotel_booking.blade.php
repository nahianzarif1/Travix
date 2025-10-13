<div class="space-y-4 container-fluid py-2">
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <h5 class="mb-1 d-flex align-items-center gap-2">🏨 Find Hotels & Resorts</h5>
            <p class="text-muted mb-4">Discover comfortable accommodations across Bangladesh</p>
            <form action="{{ route('hotels.search') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Location</label>
                    <select name="location" class="form-select form-control-soft">
                        <option value="">Select City</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Cox's Bazar">Cox's Bazar</option>
                        <option value="Chittagong">Chittagong</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Rangamati">Rangamati</option>
                        <option value="Kuakata">Kuakata</option>
                        <option value="Bandarban">Bandarban</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Check-in</label>
                    <input type="date" name="check_in" class="form-control form-control-soft">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Check-out</label>
                    <input type="date" name="check_out" class="form-control form-control-soft">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Guests</label>
                    <select name="guests" class="form-select form-control-soft">
                        <option value="1">1 Guest</option>
                        <option value="2" selected>2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                        <option value="5">5+ Guests</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-search me-1"></i> Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="mb-0 fw-bold">Featured Hotels</h6>
                    <small class="text-muted">Top-rated accommodations across Bangladesh</small>
                </div>
            </div>
            <div class="vstack gap-4">
                @php
                    $hotels = session('search_results') ?? \App\Models\Hotel::all();
                @endphp
                @foreach($hotels as $hotel)
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
                                    <div class="text-end">
                                        <div class="fw-bold fs-5 text-success">৳{{ number_format($hotel->price) }}</div>
                                        <small class="text-muted">per night</small>
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
                                        <input type="hidden" name="guests" value="{{ request('guests', 2) }}">
                                        <input type="hidden" name="rooms" value="1">
                                        <input type="hidden" name="check_in" value="{{ request('check_in', now()->addDays(7)->format('Y-m-d')) }}">
                                        <input type="hidden" name="check_out" value="{{ request('check_out', now()->addDays(9)->format('Y-m-d')) }}">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-building me-1"></i>Book Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">All Hotels</h6>
            <div class="row g-3">
                @foreach($hotels as $hotel)
                    <div class="col-md-4">
                        <div class="border rounded-3 overflow-hidden hover-bg-soft">
                            <div class="position-relative">
                                <img src="{{ $hotel->image }}" class="w-100" style="height:200px;object-fit:cover;" alt="{{ $hotel->name }}">
                                <span class="badge bg-light text-dark position-absolute top-0 start-0 m-2">{{ $hotel->category }}</span>
                            </div>
                            <div class="p-3">
                                <h6 class="fw-semibold mb-1">{{ $hotel->name }}</h6>
                                <div class="text-muted small mb-1"><i class="bi bi-geo-alt"></i> {{ $hotel->location }}</div>
                                <div class="text-warning small mb-2"><i class="bi bi-star-fill"></i> {{ $hotel->rating }} ({{ $hotel->reviews }})</div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold text-success">৳{{ number_format($hotel->price) }}</div>
                                        <small class="text-muted">per night</small>
                                    </div>
                                    <form method="POST" action="{{ route('bookings.hotel') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                        <input type="hidden" name="guests" value="{{ request('guests', 2) }}">
                                        <input type="hidden" name="rooms" value="1">
                                        <input type="hidden" name="check_in" value="{{ request('check_in', now()->addDays(7)->format('Y-m-d')) }}">
                                        <input type="hidden" name="check_out" value="{{ request('check_out', now()->addDays(9)->format('Y-m-d')) }}">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-building me-1"></i>Book
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">Browse by Category</h6>
            <div class="row g-3">
                @foreach([
                    ['name' => 'Luxury Hotels', 'count' => '25+', 'icon' => '🏨'],
                    ['name' => 'Beach Resorts', 'count' => '18+', 'icon' => '🏖️'],
                    ['name' => 'Hill Stations', 'count' => '12+', 'icon' => '⛰️'],
                    ['name' => 'Budget Hotels', 'count' => '45+', 'icon' => '🏠']
                ] as $category)
                    <div class="col-md-3 col-6">
                        <div class="border rounded-3 p-3 text-center hover-bg-soft">
                            <div class="fs-3">{{ $category['icon'] }}</div>
                            <div class="fw-semibold">{{ $category['name'] }}</div>
                            <small class="text-muted">{{ $category['count'] }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
