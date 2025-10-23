@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Dashboard Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">📊 Admin Dashboard</h2>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-3d text-center">
                <div class="card-body">
                    <div class="text-success mb-2">
                        <i class="bi bi-airplane" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="fw-bold text-success">{{ $stats['total_flights'] }}</h3>
                    <p class="text-muted mb-0">Total Flights</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-3d text-center">
                <div class="card-body">
                    <div class="text-success mb-2">
                        <i class="bi bi-building" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="fw-bold text-success">{{ $stats['total_hotels'] }}</h3>
                    <p class="text-muted mb-0">Total Hotels</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-3d text-center">
                <div class="card-body">
                    <div class="text-success mb-2">
                        <i class="bi bi-bag" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="fw-bold text-success">{{ $stats['total_packages'] }}</h3>
                    <p class="text-muted mb-0">Tour Packages</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Bookings -->
        <div class="col-md-6">
            <div class="card border-0 shadow-3d">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold text-success mb-0">📋 Recent Bookings</h5>
                </div>
                <div class="card-body">
                    @if($recent_bookings->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recent_bookings as $booking)
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">
                                                @if($booking->type === 'flight')
                                                    ✈️ {{ $booking->details['airline'] ?? 'Flight' }}
                                                @elseif($booking->type === 'hotel')
                                                    🏨 {{ $booking->details['hotel'] ?? 'Hotel' }}
                                                @else
                                                    🎒 {{ $booking->details['tour'] ?? 'Tour' }}
                                                @endif
                                            </h6>
                                            <small class="text-muted">{{ $booking->user->name ?? 'Guest' }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success">৳{{ number_format($booking->amount) }}</div>
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                Confirmed
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-journal-text text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2 mb-0">No recent bookings</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="col-md-6">
            <div class="card border-0 shadow-3d">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold text-success mb-0">💳 Recent Payments</h5>
                </div>
                <div class="card-body">
                    @if($recent_payments->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recent_payments as $payment)
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $payment->user->name ?? 'Guest' }}</h6>
                                            <small class="text-muted">{{ $payment->transaction_id }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success">৳{{ number_format($payment->amount) }}</div>
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                Confirmed
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-credit-card text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2 mb-0">No recent payments</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================= STYLE ======================= -->
<style>
.shadow-3d {
    border-radius: 1rem;
    box-shadow: 0 8px 20px rgba(25, 135, 84, 0.15);
    transition: all 0.2s ease-in-out;
}
.shadow-3d:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(25, 135, 84, 0.25);
}
.badge {
    font-size: 0.95rem;
}
.text-success {
    color: #198754 !important;
}
</style>
@endsection
