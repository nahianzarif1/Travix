@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">✈️ Manage Flights</h2>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.flights') }}" class="btn btn-outline-success btn-3d">Flights</a>
            <a href="{{ route('admin.hotels') }}" class="btn btn-outline-success btn-3d">Hotels</a>
            <a href="{{ route('admin.packages') }}" class="btn btn-outline-success btn-3d">Packages</a>
            <button class="btn btn-primary btn-3d" data-bs-toggle="modal" data-bs-target="#addFlightModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Flight
            </button>
        </div>
    </div>

<!-- Edit Flight Modal -->
<div class="modal fade" id="editFlightModal" tabindex="-1" aria-labelledby="editFlightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFlightModalLabel">Edit Flight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFlightForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Airline</label>
                            <select name="airline_id" id="edit_airline_id" class="form-select" required>
                                <option value="">Select Airline</option>
                                @foreach($airlines as $airline)
                                    <option value="{{ $airline->id }}">{{ $airline->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Aircraft</label>
                            <input type="text" name="aircraft" id="edit_aircraft" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From City</label>
                            <select name="from_city_id" id="edit_from_city_id" class="form-select" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }} ({{ $city->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">To City</label>
                            <select name="to_city_id" id="edit_to_city_id" class="form-select" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }} ({{ $city->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Departure Time</label>
                            <input type="time" name="departure" id="edit_departure" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Arrival Time</label>
                            <input type="time" name="arrival" id="edit_arrival" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration" id="edit_duration" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price (৳)</label>
                            <input type="number" name="price" id="edit_price" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rating</label>
                            <input type="number" name="rating" id="edit_rating" class="form-control" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Available Seats</label>
                            <input type="number" name="available_seats" id="edit_available_seats" class="form-control" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Amenities (comma separated)</label>
                            <input type="text" name="amenities_text" id="edit_amenities_text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    
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
                                        @php($airlineRel = $flight->getRelation('airline'))
                                        @if($airlineRel && $airlineRel->logo)
                                            <img src="{{ $airlineRel->logo }}" alt="{{ $airlineRel->name }}" class="rounded me-2" style="width: 32px; height: 32px; object-fit: contain;">
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $flight->airline ?? ($airlineRel->name ?? 'N/A') }}</div>
                                            <small class="text-muted">{{ $airlineRel->code ?? '' }}</small>
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
                                        <button class="btn btn-outline-primary" 
                                                data-bs-toggle="modal" data-bs-target="#editFlightModal"
                                                data-id="{{ $flight->id }}"
                                                data-airline_id="{{ $flight->airline_id }}"
                                                data-aircraft="{{ $flight->aircraft }}"
                                                data-from_city_id="{{ $flight->from_city_id }}"
                                                data-to_city_id="{{ $flight->to_city_id }}"
                                                data-departure="{{ $flight->departure }}"
                                                data-arrival="{{ $flight->arrival }}"
                                                data-duration="{{ $flight->duration }}"
                                                data-price="{{ $flight->price }}"
                                                data-rating="{{ $flight->rating }}"
                                                data-available_seats="{{ $flight->available_seats }}"
                                                data-amenities="{{ is_array($flight->amenities) ? implode(',', $flight->amenities) : '' }}"
                                        >
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

const editFlightModal = document.getElementById('editFlightModal');
if (editFlightModal) {
    editFlightModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;
        const id = button.getAttribute('data-id');
        const action = `/admin/flights/${id}`;
        const form = document.getElementById('editFlightForm');
        form.setAttribute('action', action);
        document.getElementById('edit_airline_id').value = button.getAttribute('data-airline_id') || '';
        document.getElementById('edit_aircraft').value = button.getAttribute('data-aircraft') || '';
        document.getElementById('edit_from_city_id').value = button.getAttribute('data-from_city_id') || '';
        document.getElementById('edit_to_city_id').value = button.getAttribute('data-to_city_id') || '';
        // time inputs expect HH:MM
        const dep = (button.getAttribute('data-departure') || '').substring(0,5);
        const arr = (button.getAttribute('data-arrival') || '').substring(0,5);
        document.getElementById('edit_departure').value = dep;
        document.getElementById('edit_arrival').value = arr;
        document.getElementById('edit_duration').value = button.getAttribute('data-duration') || '';
        document.getElementById('edit_price').value = button.getAttribute('data-price') || '';
        document.getElementById('edit_rating').value = button.getAttribute('data-rating') || '';
        document.getElementById('edit_available_seats').value = button.getAttribute('data-available_seats') || '';
        document.getElementById('edit_amenities_text').value = button.getAttribute('data-amenities') || '';
    });
}
</script>
@endsection
