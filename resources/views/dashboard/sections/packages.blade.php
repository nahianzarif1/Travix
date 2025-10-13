<div class="container py-4">
    <div class="text-center mb-4">
        <h5 class="fw-bold mb-2">Tour Packages</h5>
        <p class="text-muted">Discover Bangladesh with our carefully curated tour packages</p>
    </div>

    <div class="card border-0 shadow-3d mb-4">
        <div class="card-body pt-3">
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                @php
                    $categories = ['All Packages','Beach Tours','Wildlife Safari','Nature Tours','Adventure','Cultural Tours'];
                @endphp
                @foreach($categories as $category)
                    <button class="btn btn-outline-success btn-sm">{{ $category }}</button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-3d mb-4">
        <div class="card-body p-4">
            <h6 class="mb-1 fw-semibold">Featured Packages</h6>
            <small class="text-muted">Most popular and highly rated tour packages</small>
            <div class="row g-4 mt-1">
                <div class="col-12 col-lg-6">
                    <div class="border rounded-3 p-4 hover-bg-soft">
                        <div class="d-flex gap-3">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1658076798013-654fb97e3111?auto=format&fit=crop&w=400&q=80" class="rounded-3" style="width:128px;height:96px;object-fit:cover;" alt="Cox's Bazar">
                                <span class="badge bg-danger position-absolute top-0 end-0">Featured</span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold mb-1">Cox's Bazar Beach Paradise</div>
                                <div class="text-muted small d-flex align-items-center gap-2 mb-1"><i class="bi bi-geo-alt"></i> Cox's Bazar <i class="bi bi-clock ms-2"></i> 3 Days 2 Nights</div>
                                <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-star-fill text-warning"></i> 4.7 <span class="text-muted small">(245 reviews)</span> <span class="badge bg-light text-dark ms-auto">Beach</span></div>
                                <p class="text-muted small mb-2">Experience the world’s longest natural beach with crystal clear waters and golden sand.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-bold text-success">৳15,000</span>
                                        <span class="text-muted text-decoration-line-through small">৳18,000</span>
                                        <div class="text-muted small">per person</div>
                                    </div>
                                    <button class="btn btn-success btn-sm">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="border rounded-3 p-4 hover-bg-soft">
                        <div class="d-flex gap-3">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1746959197922-3c097c0a4e6e?auto=format&fit=crop&w=400&q=80" class="rounded-3" style="width:128px;height:96px;object-fit:cover;" alt="Sundarbans">
                                <span class="badge bg-danger position-absolute top-0 end-0">Featured</span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold mb-1">Sundarbans Wildlife Safari</div>
                                <div class="text-muted small d-flex align-items-center gap-2 mb-1"><i class="bi bi-geo-alt"></i> Sundarbans <i class="bi bi-clock ms-2"></i> 4 Days 3 Nights</div>
                                <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-star-fill text-warning"></i> 4.8 <span class="text-muted small">(189 reviews)</span> <span class="badge bg-light text-dark ms-auto">Wildlife</span></div>
                                <p class="text-muted small mb-2">Explore the UNESCO World Heritage mangrove forest and spot the legendary Royal Bengal Tigers.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-bold text-success">৳25,000</span>
                                        <span class="text-muted text-decoration-line-through small">৳30,000</span>
                                        <div class="text-muted small">per person</div>
                                    </div>
                                    <button class="btn btn-success btn-sm">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-3d mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h6 class="mb-0 fw-semibold">All Packages</h6>
                    <small class="text-muted">{{ $packages->count() }} packages available</small>
                </div>
            </div>

            <div class="row g-4">
                @php
                    $packages = \App\Models\Package::all();
                @endphp

                @foreach ($packages as $pkg)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="border rounded-3 overflow-hidden hover-bg-soft">
                        <div class="position-relative">
                            <img src="{{ $pkg->image }}" alt="{{ $pkg->title }}" class="w-100" style="height:190px;object-fit:cover;">
                            <span class="badge bg-secondary position-absolute top-0 start-0 m-2">{{ $pkg->category }}</span>
                        </div>
                        <div class="p-3">
                            <div class="fw-semibold mb-1">{{ $pkg->title }}</div>
                            <div class="d-flex align-items-center gap-3 text-muted small mb-2">
                                <span class="d-flex align-items-center gap-1"><i class="bi bi-geo-alt"></i> {{ $pkg->location }}</span>
                                <span class="d-flex align-items-center gap-1"><i class="bi bi-clock"></i> {{ $pkg->duration }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-star-fill text-warning"></i> {{ $pkg->rating }} <span class="text-muted small">({{ $pkg->reviews }})</span></div>
                            <div class="mb-2">
                                <strong class="small">Highlights:</strong>
                                @foreach($pkg->highlights as $h)
                                    <span class="badge bg-light text-dark border me-1">{{ $h }}</span>
                                @endforeach
                            </div>
                            <div class="mb-2">
                                <strong class="small">Includes:</strong>
                                @foreach($pkg->includes as $i)
                                    <span class="badge bg-success-subtle text-success-emphasis me-1">{{ $i }}</span>
                                @endforeach
                            </div>
                            <div class="text-muted small mb-2"><i class="bi bi-people"></i> {{ $pkg->group_size }}</div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-bold text-success">৳{{ number_format($pkg->price) }}</span>
                                    @if($pkg->original_price)
                                        <span class="text-muted text-decoration-line-through small">৳{{ number_format($pkg->original_price) }}</span>
                                    @endif
                                </div>
                                <form method="POST" action="{{ route('bookings.package') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $pkg->id }}">
                                    <input type="hidden" name="participants" value="{{ request('participants', 2) }}">
                                    <input type="hidden" name="start_date" value="{{ request('start_date', now()->addDays(14)->format('Y-m-d')) }}">
                                    <input type="hidden" name="end_date" value="{{ request('end_date', now()->addDays(17)->format('Y-m-d')) }}">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-bag me-1"></i>Book
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
            <h6 class="fw-semibold">Why Choose Our Packages?</h6>
            <small class="text-muted">Experience Bangladesh like never before</small>
            <div class="row g-4 mt-1 text-center">
                <div class="col-md-4">
                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-3" style="width:48px;height:48px;background:#e9f7ef;">
                        <i class="bi bi-people text-success fs-5"></i>
                    </div>
                    <div class="fw-medium mb-1">Expert Local Guides</div>
                    <div class="text-muted small">Experienced guides who know Bangladesh inside out</div>
                </div>
                <div class="col-md-4">
                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-3" style="width:48px;height:48px;background:#e9f2ff;">
                        <i class="bi bi-box-seam text-primary fs-5"></i>
                    </div>
                    <div class="fw-medium mb-1">All-Inclusive Packages</div>
                    <div class="text-muted small">Accommodation, meals, transport, and activities included</div>
                </div>
                <div class="col-md-4">
                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-3" style="width:48px;height:48px;background:#f3e9ff;">
                        <i class="bi bi-star text-purple fs-5"></i>
                    </div>
                    <div class="fw-medium mb-1">Highly Rated</div>
                    <div class="text-muted small">4.5+ star rating from thousands of travelers</div>
                </div>
            </div>
        </div>
    </div>
</div>
