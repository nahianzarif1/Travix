<div class="space-y-4">
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <h5 class="mb-1 d-flex align-items-center gap-2">✈️ Book Domestic Flights</h5>
            <p class="text-muted mb-4">Find and book flights across Bangladesh with the best airlines</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('flights.search') }}" method="GET" id="flightSearchForm">
                <div class="d-flex gap-4 mb-3">
                    <label class="d-flex align-items-center gap-2">
                        <input type="radio" name="tripType" value="round-trip" {{ old('tripType', 'round-trip') == 'round-trip' ? 'checked' : '' }}>
                        <span>Round Trip</span>
                    </label>
                    <label class="d-flex align-items-center gap-2">
                        <input type="radio" name="tripType" value="one-way" {{ old('tripType') == 'one-way' ? 'checked' : '' }}>
                        <span>One Way</span>
                    </label>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label">From</label>
                        <select name="from" class="form-select form-control-soft">
                            <option value="">Select departure city</option>
                            <option value="DAC" {{ old('from') == 'DAC' ? 'selected' : '' }}>Dhaka (DAC)</option>
                            <option value="CGP" {{ old('from') == 'CGP' ? 'selected' : '' }}>Chittagong (CGP)</option>
                            <option value="ZYL" {{ old('from') == 'ZYL' ? 'selected' : '' }}>Sylhet (ZYL)</option>
                            <option value="JSR" {{ old('from') == 'JSR' ? 'selected' : '' }}>Jessore (JSR)</option>
                         
                            <option value="CXB" {{ old('from') == 'CXB' ? 'selected' : '' }}>Cox's Bazar (CXB)</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label">To</label>
                        <select name="to" class="form-select form-control-soft">
                            <option value="">Select destination city</option>
                            <option value="DAC" {{ old('to') == 'DAC' ? 'selected' : '' }}>Dhaka (DAC)</option>
                            <option value="CGP" {{ old('to') == 'CGP' ? 'selected' : '' }}>Chittagong (CGP)</option>
                            <option value="ZYL" {{ old('to') == 'ZYL' ? 'selected' : '' }}>Sylhet (ZYL)</option>
                            <option value="JSR" {{ old('to') == 'JSR' ? 'selected' : '' }}>Jessore (JSR)</option>
                            <option value="SPD" {{ old('to') == 'SPD' ? 'selected' : '' }}>Saidpur (SPD)</option>
                            <option value="CXB" {{ old('to') == 'CXB' ? 'selected' : '' }}>Cox's Bazar (CXB)</option>
                        </select>
                    </div>
                    <div class="col-6 col-lg-3">
                        <label class="form-label">Departure</label>
                        <input type="date" name="departure" class="form-control form-control-soft" value="{{ old('departure') }}">
                    </div>
                    <div class="col-6 col-lg-3">
                        <label class="form-label">Return</label>
                        <input type="date" name="return" class="form-control form-control-soft" value="{{ old('return') }}" {{ old('tripType') == 'one-way' ? 'disabled' : '' }}>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label class="form-label">Passengers</label>
                        <select name="passengers" class="form-select form-control-soft">
                            <option value="1" {{ old('passengers') == 1 ? 'selected' : '' }}>1 Passenger</option>
                            <option value="2" {{ old('passengers') == 2 ? 'selected' : '' }}>2 Passengers</option>
                            <option value="3" {{ old('passengers') == 3 ? 'selected' : '' }}>3 Passengers</option>
                            <option value="4" {{ old('passengers') == 4 ? 'selected' : '' }}>4 Passengers</option>
                            <option value="5" {{ old('passengers') == 5 ? 'selected' : '' }}>5+ Passengers</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom mt-3 btn-3d">
    <span class="me-1">✈️</span> Search Flight
</button>

            </form>
        </div>
    </div>

    @if(isset($flightSearchResults))
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h6 class="mb-0 fw-bold">Available Flights</h6>
                    <small class="text-muted">{{ $flightSearchResults->count() }} flights found</small>
                </div>
            </div>

            <div class="vstack gap-3">
            @forelse($flightSearchResults as $flight)
                <div class="border rounded-3 p-3 hover-bg-soft">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:48px;height:48px;background:#e9f3ff;">✈️</div>
                            <div>
                                <div class="fw-semibold">{{ $flight->airline }}</div>
                                <div class="text-muted small">{{ $flight->aircraft }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4 flex-grow-1 justify-content-center">
                            <div class="text-center">
                                <div class="fw-medium">{{ \Carbon\Carbon::parse($flight->departure)->format('h:i A') }}</div>
                                <div class="text-muted small">{{ $flight->from_city }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-muted small">{{ $flight->duration }}</div>
                                <div class="my-1 border-top" style="border-style:dashed !important;"></div>
                                <div class="text-muted small">Non-stop</div>
                            </div>
                            <div class="text-center">
                                <div class="fw-medium">{{ \Carbon\Carbon::parse($flight->arrival)->format('h:i A') }}</div>
                                <div class="text-muted small">{{ $flight->to_city }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            @php
                                $passengers = old('passengers', 1);
                                $tripMultiplier = old('tripType') == 'round-trip' ? 2 : 1;
                                $totalPrice = $flight->price * $passengers * $tripMultiplier;
                            @endphp
                            <div class="fs-5 fw-bold text-success">৳{{ number_format($totalPrice) }}</div>
                            <div class="text-muted small mb-2">for {{ $passengers }} {{ $passengers > 1 ? 'passengers' : 'passenger' }}</div>
                            <form method="POST" action="{{ route('bookings.flight') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="flight_id" value="{{ $flight->id }}">
                                <input type="hidden" name="passengers" value="{{ $passengers }}">
                                <input type="hidden" name="date" value="{{ old('departure') }}">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-airplane me-1"></i>Book Now
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <p class="text-muted">No flights found for your search criteria.</p>
                </div>
            @endforelse
            </div>
        </div>
    </div>
    @else
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h6 class="mb-0 fw-bold">All Flights</h6>
                    <small class="text-muted">{{ isset($flights) ? $flights->count() : 0 }} flights available</small>
                </div>
            </div>
            <div class="vstack gap-3">
                @foreach(($flights ?? []) as $flight)
                    <div class="border rounded-3 p-3 hover-bg-soft">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3" style="width:48px;height:48px;background:#e9f3ff;">✈️</div>
                                <div>
                                    <div class="fw-semibold">{{ $flight->airline }}</div>
                                    <div class="text-muted small">{{ $flight->aircraft }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-4 flex-grow-1 justify-content-center">
                                <div class="text-center">
                                    <div class="fw-medium">{{ \Carbon\Carbon::parse($flight->departure)->format('h:i A') }}</div>
                                    <div class="text-muted small">{{ $flight->from_city }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-muted small">{{ $flight->duration }}</div>
                                    <div class="my-1 border-top" style="border-style:dashed !important;"></div>
                                    <div class="text-muted small">Non-stop</div>
                                </div>
                                <div class="text-center">
                                    <div class="fw-medium">{{ \Carbon\Carbon::parse($flight->arrival)->format('h:i A') }}</div>
                                    <div class="text-muted small">{{ $flight->to_city }}</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fs-5 fw-bold text-success">৳{{ number_format($flight->price) }}</div>
                                <form method="POST" action="{{ route('bookings.flight') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="flight_id" value="{{ $flight->id }}">
                                    <input type="hidden" name="passengers" value="1">
                                    <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-airplane me-1"></i>Book Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tripTypeRadios = document.querySelectorAll('input[name="tripType"]');
    const returnDateInput = document.querySelector('input[name="return"]');

    function toggleReturnDate() {
        if (document.querySelector('input[name="tripType"]:checked').value === 'one-way') {
            returnDateInput.disabled = true;
            returnDateInput.value = '';
        } else {
            returnDateInput.disabled = false;
        }
    }

    tripTypeRadios.forEach(radio => radio.addEventListener('change', toggleReturnDate));

    // Run on page load
    toggleReturnDate();
});
</script>