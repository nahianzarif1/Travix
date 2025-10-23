<div class="container-fluid">
    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-3d">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">💳 Secure Payment</h5>
                        <span class="badge bg-gradient-primary">SSLCommerz</span>
                    </div>

                    @php
                        $user = auth()->user();
                    @endphp

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($pendingBookings->count() > 0)
                        <!-- Booking Management Section -->
                        <div class="card border-0 shadow-3d mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">📋 Selected Bookings</h6>
                                <div class="row g-3">
                                    @foreach($pendingBookings as $booking)
                                        <div class="col-md-6">
                                            <div class="border rounded-3 p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">
                                                            @if($booking->type === 'flight')
                                                                ✈️ {{ $booking->details['airline'] }}
                                                            @elseif($booking->type === 'hotel')
                                                                🏨 {{ $booking->details['hotel'] }}
                                                            @else
                                                                🎒 {{ $booking->details['tour'] }}
                                                            @endif
                                                        </h6>
                                                        <small class="text-muted">
                                                            @if($booking->type === 'flight')
                                                                {{ $booking->details['from'] ?? 'N/A' }} → {{ $booking->details['to'] ?? 'N/A' }}
                                                            @elseif($booking->type === 'hotel')
                                                                {{ $booking->details['location'] ?? $booking->details['hotel'] ?? 'N/A' }}
                                                            @else
                                                                {{ $booking->details['location'] ?? $booking->details['tour'] ?? 'N/A' }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold text-success">৳{{ number_format($booking->amount) }}</div>
                        <button class="btn btn-outline-danger btn-sm" onclick="removeBooking({{ $booking->id }})" title="Remove booking">
                            <i class="bi bi-trash"></i>
                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('payment.initiate') }}" id="paymentForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Cardholder Name</label>
                                    <input type="text" name="cardholder_name" class="form-control form-control-soft" placeholder="John Doe" value="{{ $user->name }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">bKash Mobile Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-soft">📱</span>
                                        <input type="tel" name="mobile_number" class="form-control form-control-soft" placeholder="01XXXXXXXXX" value="{{ $user->mobile_number ?? '' }}" required>
                                    </div>
                                    <small class="text-muted">Enter your bKash registered mobile number</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">bKash PIN</label>
                                    <input type="password" name="bkash_pin" class="form-control form-control-soft" placeholder="Enter your bKash PIN" required>
                                    <small class="text-muted">You will be redirected to bKash for PIN verification</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Billing Address</label>
                                    <textarea name="address" class="form-control form-control-soft" rows="2" placeholder="Street, City, Country" required>{{ $user->address ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="savePayment" name="save_payment">
                                    <label class="form-check-label" for="savePayment">Save payment method for future use</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-credit-card me-2"></i>
                                    Pay with bKash ৳{{ number_format($grandTotal + ($grandTotal * 0.02)) }}
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="fw-bold text-muted">No Pending Payments</h5>
                            <p class="text-muted">You don't have any confirmed bookings that require payment.</p>
                            <div class="text-center py-4">
    <i class="bi bi-emoji-smile text-success" style="font-size: 3rem;"></i>
    <h5 class="fw-bold text-muted mt-2 mb-1">Thank you for your booking!</h5>
    <p class="text-muted mb-0">Explore more packages to plan your next adventure ✈️🏨🎒</p>
</div>

                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-3d">
                <div class="card-body p-4">
                    <h6 class="mb-3">Payment Summary</h6>
                    
                    @if($pendingBookings->count() > 0)
                        @if($flightTotal > 0)
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>✈️ Flights ({{ $pendingBookings->where('type', 'flight')->count() }})</span>
                            <span>৳{{ number_format($flightTotal) }}</span>
                        </div>
                        @endif
                        
                        @if($hotelTotal > 0)
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>🏨 Hotels ({{ $pendingBookings->where('type', 'hotel')->count() }})</span>
                            <span>৳{{ number_format($hotelTotal) }}</span>
                        </div>
                        @endif
                        
                        @if($tourTotal > 0)
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>🎒 Tours ({{ $pendingBookings->where('type', 'tour')->count() }})</span>
                            <span>৳{{ number_format($tourTotal) }}</span>
                        </div>
                        @endif
                        
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Processing Fee</span>
                            <span>৳{{ number_format($grandTotal * 0.02) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong>Total</strong>
                            <strong class="text-success">৳{{ number_format($grandTotal + ($grandTotal * 0.02)) }}</strong>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-receipt text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">No pending payments</p>
                        </div>
                    @endif

                    <div class="d-flex gap-2 mt-3">
                        <span class="badge bg-success">bKash</span>
                        <span class="text-muted small">Secure Mobile Payment</span>
                    </div>
                </div>
            </div>

            <div class="card mt-4 border-0 glass-3d">
                <div class="card-body p-4">
                    <h6 class="mb-2">Payment Security</h6>
                    <p class="text-muted small mb-0">Your payment is secured by SSLCommerz with 256-bit SSL encryption. We never store your card details.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function removeBooking(bookingId) {
    if (confirm('Are you sure you want to remove this booking?')) {
        // Send AJAX request to remove booking
        fetch(`/bookings/${bookingId}`, {
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
                alert('Error removing booking: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing booking');
        });
    }
}
</script>

