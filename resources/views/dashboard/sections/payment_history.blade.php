@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="min-height: 100vh; background-color: #f8f9fa;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card shadow-lg border-0" style="border-radius: 1.5rem;">
                <div class="card-body p-5">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                        <div>
                            <h2 class="fw-bold display-6 text-success mb-2">
                                💳 Payment History
                            </h2>
                            <p class="text-muted fs-5 mb-0">Track all your payment transactions easily</p>
                        </div>

                        <a href="{{ route('home') }}#payments" class="btn btn-success btn-3d btn-lg fs-5">
                            <i class="bi bi-arrow-left me-2"></i>Back to Payments
                        </a>
                    </div>

                    <!-- Payment Table -->
                    @if($payments->count() > 0)
                        <div class="table-responsive text-center">
                            <table class="table table-hover align-middle table-striped fs-5 shadow-sm mx-auto" style="width: 95%; border-radius: 1rem; overflow: hidden;">
                                <thead class="table-success text-white fs-5">
                                    <tr class="bg-success text-white">
                                        <th>Transaction ID</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Method</th>
                                        <th>Date</th>
                                        <th>Bookings</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td><code class="text-success fw-bold fs-5">{{ $payment->transaction_id }}</code></td>
                                            <td><span class="fw-bold text-success fs-5">৳{{ number_format($payment->amount) }}</span></td>
                                            <td>
                                                @if($payment->status === 'success')
                                                    <span class="badge bg-success rounded-pill fs-6 px-3 py-2">
                                                        <i class="bi bi-check-circle me-1"></i>Paid
                                                    </span>
                                                @elseif($payment->status === 'failed')
                                                    <span class="badge bg-danger rounded-pill fs-6 px-3 py-2">
                                                        <i class="bi bi-x-circle me-1"></i>Failed
                                                    </span>
                                                @elseif($payment->status === 'cancelled')
                                                    <span class="badge bg-warning text-dark rounded-pill fs-6 px-3 py-2">
                                                        <i class="bi bi-x-circle me-1"></i>Cancelled
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary rounded-pill fs-6 px-3 py-2">
                                                        <i class="bi bi-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-success border border-success rounded-pill fs-6 px-3 py-2">
                                                    {{ ucfirst($payment->payment_method) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="text-muted fs-6">{{ $payment->created_at->format('M d, Y') }}</div>
                                                <div class="text-muted fs-6">{{ $payment->created_at->format('h:i A') }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-white text-success border border-success rounded-pill fs-6 px-3 py-2">
                                                    {{ $payment->items->count() }} items
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-success btn-3d btn-lg fs-6 px-4" onclick="viewPaymentDetails({{ $payment->id }})">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-receipt text-success mb-4" style="font-size: 6rem;"></i>
                            <h3 class="fw-bold text-dark mb-3">No Payment History</h3>
                            <p class="text-muted fs-5 mb-4">You haven't made any payments yet.</p>
                            <a href="{{ route('home') }}#packages" class="btn btn-success btn-3d btn-lg fs-5">
                                <i class="bi bi-plus-circle me-2"></i>Start Booking
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================= STYLE ======================= -->
<style>
/* Green Table Header */
.table-success {
    background-color: #198754 !important;
}

/* 3D Buttons */
.btn-3d {
    border-radius: 30px;
    padding: 10px 26px;
    box-shadow: 0 6px 15px rgba(25, 135, 84, 0.3);
    transition: all 0.2s ease-in-out;
}

.btn-3d:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(25, 135, 84, 0.4);
}

/* Hover effect for rows */
.table-hover tbody tr:hover {
    background-color: rgba(25, 135, 84, 0.08);
    transform: scale(1.01);
    transition: 0.2s ease-in-out;
}

/* Center table content */
.table th, .table td {
    vertical-align: middle;
    text-align: center;
}

/* Card */
.card {
    border-radius: 1.5rem;
}

/* Responsive */
@media (max-width: 992px) {
    .card-body {
        padding: 2rem;
    }
    .fs-5 {
        font-size: 1rem;
    }
}
</style>

<!-- ======================= SCRIPT ======================= -->
<script>
function viewPaymentDetails(paymentId) {
    alert('Payment details for ID: ' + paymentId);
}
</script>
@endsection
