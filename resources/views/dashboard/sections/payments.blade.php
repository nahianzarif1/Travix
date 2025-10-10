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
                        <form method="POST" action="{{ route('payment.initiate') }}" id="paymentForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Cardholder Name</label>
                                    <input type="text" name="cardholder_name" class="form-control form-control-soft" placeholder="John Doe" value="{{ $user->name }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Card Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-soft">💳</span>
                                        <input type="text" name="card_number" class="form-control form-control-soft" placeholder="1234 5678 9012 3456" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Expiry Month</label>
                                    <select name="expiry_month" class="form-select form-control-soft" required>
                                        <option value="">Month</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Expiry Year</label>
                                    <select name="expiry_year" class="form-select form-control-soft" required>
                                        <option value="">Year</option>
                                        @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">CVC</label>
                                    <input type="password" name="cvv" class="form-control form-control-soft" placeholder="***" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="tel" name="mobile_number" class="form-control form-control-soft" placeholder="+880 1XXX XXXXXX" value="{{ $user->mobile_number ?? '' }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Billing Address</label>
                                    <textarea name="address" class="form-control form-control-soft" rows="2" placeholder="Street, City, Country" required>{{ $user->address ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="saveCard" name="save_card">
                                    <label class="form-check-label" for="saveCard">Save card for future payments</label>
                                </div>
                                <button type="submit" class="btn btn-success btn-3d">
                                    <i class="bi bi-credit-card me-2"></i>
                                    Pay ৳{{ number_format($grandTotal) }} Now
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
                            <a href="{{ route('home') }}#packages" class="btn btn-success btn-3d">
                                <i class="bi bi-plus-circle me-2"></i>
                                Book Something New
                            </a>
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
                        <span class="badge bg-soft">Visa</span>
                        <span class="badge bg-soft">Mastercard</span>
                        <span class="badge bg-soft">bKash</span>
                        <span class="badge bg-soft">Rocket</span>
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

