@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">🎒 Manage Packages</h2>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.flights') }}" class="btn btn-outline-success btn-3d">Flights</a>
            <a href="{{ route('admin.hotels') }}" class="btn btn-outline-success btn-3d">Hotels</a>
            <a href="{{ route('admin.packages') }}" class="btn btn-outline-success btn-3d">Packages</a>
            <button class="btn btn-primary btn-3d" data-bs-toggle="modal" data-bs-target="#addPackageModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Package
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
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Location</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Price</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                            <tr>
                                <td class="d-flex align-items-center gap-2">
                                    @if($package->image)
                                        <img src="{{ $package->image }}" alt="{{ $package->title }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    @endif
                                    <span class="fw-semibold">{{ $package->title }}</span>
                                </td>
                                <td>{{ $package->category ?? '-' }}</td>
                                <td>{{ $package->location ?? '-' }}</td>
                                <td>{{ $package->duration ?? '-' }}</td>
                                <td class="fw-bold text-success">৳{{ number_format($package->price) }}</td>
                                <td><i class="bi bi-star-fill text-warning me-1"></i>{{ $package->rating }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" onclick="editPackage({{ $package->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deletePackage({{ $package->id }})">
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
                {{ $packages->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPackageModal" tabindex="-1" aria-labelledby="addPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPackageModalLabel">Add New Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.packages.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image URL</label>
                            <input type="url" name="image" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" placeholder="Adventure / Family">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Cox's Bazar">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration" class="form-control" placeholder="3 Days 2 Nights">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price (৳)</label>
                            <input type="number" name="price" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Original Price (৳)</label>
                            <input type="number" name="original_price" class="form-control" min="0" step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Rating</label>
                            <input type="number" name="rating" class="form-control" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Highlights (one per line)</label>
                            <textarea name="highlights_text" class="form-control" rows="4" placeholder="Beach visit\nBreakfast included\nGuided tour"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Includes (one per line)</label>
                            <textarea name="includes_text" class="form-control" rows="4" placeholder="Hotel\nTransport\nMeals"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Group Size</label>
                            <input type="text" name="group_size" class="form-control" placeholder="Up to 10">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Package</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editPackage(id) {
    alert('Edit package functionality will be implemented here. Package ID: ' + id);
}

function deletePackage(id) {
    if (confirm('Are you sure you want to delete this package?')) {
        fetch(`/admin/packages/${id}`, {
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
                alert('Error deleting package: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(() => alert('Error deleting package'));
    }
}
</script>
@endsection
