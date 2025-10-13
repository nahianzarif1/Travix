@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">✈️ Manage Flights</h2>
        <button class="btn btn-primary btn-3d" data-bs-toggle="modal" data-bs-target="#addFlightModal">
            <i class="bi bi-plus-circle me-2"></i>Add New Flight
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Flights Table -->
    <div class="card border-0 shadow-3d">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Airline</th>
                            <th scope="col">Route</th>
                            <th scope="col">Aircraft</th>
                            <th scope="col">Time</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Price</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($flights as $flight)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($flight->airline && $flight->airline->logo)
                                            <img src="{{ $flight->airline->logo }}" alt="{{ $flight->airline->name }}" class="rounded me-2" style="width: 32px; height: 32px; object-fit: contain;">
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $flight->airline ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $flight->airline->code ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $flight->from_city }} → {{ $flight->to_city }}</div>
                                    <small class="text-muted">{{ $flight->fromCity->name ?? '' }} → {{ $flight->toCity->name ?? '' }}</small>
                                </td>
                                <td>{{ $flight->aircraft }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $flight->departure }} - {{ $flight->arrival }}</div>
                                </td>
                                <td>{{ $flight->duration }}</td>
                                <td class="fw-bold text-success">৳{{ number_format($flight->price) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-star-fill text-warning me-1"></i>
                                        {{ $flight->rating }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $flight->is_active ? 'success' : 'danger' }}">
                                        {{ $flight->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" onclick="editFlight({{ $flight->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deleteFlight({{ $flight->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $flights->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Flight Modal -->
<div class="modal fade" id="addFlightModal" tabindex="-1" aria-labelledby="addFlightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFlightModalLabel">Add New Flight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.flights.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Airline</label>
                            <select name="airline_id" class="form-select" required>
                                <option value="">Select Airline</option>
                                @foreach($airlines as $airline)
                                    <option value="{{ $airline->id }}">{{ $airline->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Aircraft</label>
                            <input type="text" name="aircraft" class="form-control" placeholder="Boeing 737" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From City</label>
                            <select name="from_city_id" class="form-select" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }} ({{ $city->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">To City</label>
                            <select name="to_city_id" class="form-select" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }} ({{ $city->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Departure Time</label>
                            <input type="time" name="departure" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Arrival Time</label>
                            <input type="time" name="arrival" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration" class="form-control" placeholder="1h 15m" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price (৳)</label>
                            <input type="number" name="price" class="form-control" placeholder="8500" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rating</label>
                            <input type="number" name="rating" class="form-control" placeholder="4.2" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Available Seats</label>
                            <input type="number" name="available_seats" class="form-control" placeholder="100" min="0" value="100">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Amenities (comma separated)</label>
                            <input type="text" name="amenities_text" class="form-control" placeholder="Wifi, Meal, Entertainment">
                            <small class="text-muted">Enter amenities separated by commas</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Flight</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editFlight(flightId) {
    // Implementation for editing flight
    alert('Edit flight functionality will be implemented here. Flight ID: ' + flightId);
}

function deleteFlight(flightId) {
    if (confirm('Are you sure you want to delete this flight?')) {
        fetch(`/admin/flights/${flightId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting flight: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting flight');
        });
    }
}
</script>
@endsection
