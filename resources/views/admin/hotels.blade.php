@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">🏨 Manage Hotels</h2>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.flights') }}" class="btn btn-outline-success btn-3d">Flights</a>
            <a href="{{ route('admin.hotels') }}" class="btn btn-outline-success btn-3d">Hotels</a>
            <a href="{{ route('admin.packages') }}" class="btn btn-outline-success btn-3d">Packages</a>
            <button class="btn btn-primary btn-3d" data-bs-toggle="modal" data-bs-target="#addHotelModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Hotel
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-3d">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotels as $hotel)
                            <tr>
                                <td class="d-flex align-items-center gap-2">
                                    @if($hotel->image)
                                        <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    @endif
                                    <span class="fw-semibold">{{ $hotel->name }}</span>
                                </td>
                                <td>{{ $hotel->location }}</td>
                                <td>{{ $hotel->category ?? '-' }}</td>
                                <td class="fw-bold text-success">৳{{ number_format($hotel->price) }}</td>
                                <td>
                                    <i class="bi bi-star-fill text-warning me-1"></i>{{ $hotel->rating }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $hotel->featured ? 'success' : 'secondary' }}">{{ $hotel->featured ? 'Yes' : 'No' }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary"
                                            data-bs-toggle="modal" data-bs-target="#editHotelModal"
                                            data-id="{{ $hotel->id }}"
                                            data-name="{{ $hotel->name }}"
                                            data-location="{{ $hotel->location }}"
                                            data-image="{{ $hotel->image }}"
                                            data-category="{{ $hotel->category }}"
                                            data-price="{{ $hotel->price }}"
                                            data-rating="{{ $hotel->rating }}"
                                            data-reviews="{{ $hotel->reviews }}"
                                            data-featured="{{ $hotel->featured ? 1 : 0 }}"
                                            data-amenities="{{ is_array($hotel->amenities) ? implode(',', $hotel->amenities) : '' }}"
                                            data-description="{{ $hotel->description }}"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deleteHotel({{ $hotel->id }})">
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
                {{ $hotels->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addHotelModal" tabindex="-1" aria-labelledby="addHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHotelModalLabel">Add New Hotel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.hotels.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image URL</label>
                            <input type="url" name="image" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" placeholder="Deluxe / Budget">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price (৳)</label>
                            <input type="number" name="price" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Rating</label>
                            <input type="number" name="rating" class="form-control" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reviews</label>
                            <input type="number" name="reviews" class="form-control" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Amenities (comma separated)</label>
                            <input type="text" name="amenities_text" class="form-control" placeholder="Wifi, Pool, Gym">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12 form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="featured" name="featured">
                            <label class="form-check-label" for="featured">
                                Featured
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Hotel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteHotel(id) {
    if (confirm('Are you sure you want to delete this hotel?')) {
        fetch(`/admin/hotels/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting hotel: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(() => alert('Error deleting hotel'));
    }
}

const editHotelModal = document.getElementById('editHotelModal');
if (editHotelModal) {
    editHotelModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;
        const id = button.getAttribute('data-id');
        const form = document.getElementById('editHotelForm');
        form.setAttribute('action', `/admin/hotels/${id}`);
        document.getElementById('edit_name').value = button.getAttribute('data-name') || '';
        document.getElementById('edit_location').value = button.getAttribute('data-location') || '';
        document.getElementById('edit_image').value = button.getAttribute('data-image') || '';
        document.getElementById('edit_category').value = button.getAttribute('data-category') || '';
        document.getElementById('edit_price').value = button.getAttribute('data-price') || '';
        document.getElementById('edit_rating').value = button.getAttribute('data-rating') || '';
        document.getElementById('edit_reviews').value = button.getAttribute('data-reviews') || '';
        document.getElementById('edit_amenities_text').value = button.getAttribute('data-amenities') || '';
        document.getElementById('edit_description').value = button.getAttribute('data-description') || '';
        document.getElementById('edit_featured').checked = (button.getAttribute('data-featured') === '1');
    });
}
</script>
@endsection

<!-- Edit Hotel Modal -->
<div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHotelModalLabel">Edit Hotel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editHotelForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" id="edit_location" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image URL</label>
                            <input type="url" name="image" id="edit_image" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" id="edit_category" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price (৳)</label>
                            <input type="number" name="price" id="edit_price" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Rating</label>
                            <input type="number" name="rating" id="edit_rating" class="form-control" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reviews</label>
                            <input type="number" name="reviews" id="edit_reviews" class="form-control" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Amenities (comma separated)</label>
                            <input type="text" name="amenities_text" id="edit_amenities_text" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12 form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="edit_featured" name="featured">
                            <label class="form-check-label" for="edit_featured">Featured</label>
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
