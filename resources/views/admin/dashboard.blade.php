@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📊 Admin Dashboard</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.flights') }}" class="btn btn-primary btn-3d">
                <i class="bi bi-airplane me-2"></i>Manage Flights
            </a>
            <a href="{{ route('admin.hotels') }}" class="btn btn-success btn-3d">
                <i class="bi bi-building me-2"></i>Manage Hotels
            </a>
            <a href="{{ route('admin.packages') }}" class="btn btn-info btn-3d">
                <i class="bi bi-bag me-2"></i>Manage Packages
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-3d">
                <div class="card-body text-center">
                    <div class="text-primary mb-2">
                        <i class="bi bi-airplane" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="fw-bold text-primary">{{ $stats['total_flights'] }}</h3>
                    <p class="text-muted mb-0">Total Flights</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-3d">
                <div class="card-body text-center">
                    <div class="text-success mb-2">
                        <i class="bi bi-building" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="fw-bold text-success">{{ $stats['total_hotels'] }}</h3>
                    <p class="text-muted mb-0">Total Hotels</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-3d">
                <div class="card-body text-center">
                    <div class="text-info mb-2">
                        <i class="bi bi-bag" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="fw-bold text-info">{{ $stats['total_packages'] }}</h3>
                    <p class="text-muted mb-0">Tour Packages</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-3d">
                <div class="card-body text-center">
                    <div class="text-warning mb-2">
                        <i class="bi bi-currency-dollar" style="font-size: 2rem;"></i>
                    </div>
                    <h3 class="fw-bold text-warning">৳{{ number_format($stats['revenue']) }}</h3>
                    <p class="text-muted mb-0">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Bookings -->
        <div class="col-md-6">
            <div class="card border-0 shadow-3d">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">📋 Recent Bookings</h5>
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
                                            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'paid' ? 'primary' : 'warning') }}">
                                                {{ ucfirst($booking->status) }}
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
                    <h5 class="mb-0">💳 Recent Payments</h5>
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
                                            <span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($payment->status) }}
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
@endsection
