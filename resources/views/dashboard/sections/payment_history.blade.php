<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">
            <div class="card border-0 shadow-lg" style="max-width: 1400px; margin: auto;">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <h2 class="fw-bold display-5">💳 Payment History</h2>
                            <p class="text-muted fs-5">Track all your payment transactions in one place</p>
                        </div>
                        <a href="{{ route('home') }}#payments" class="btn btn-primary btn-3d btn-lg fs-5">
                            <i class="bi bi-arrow-left me-2"></i>Back to Payments
                        </a>
                    </div>

                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-striped fs-5">
                                <thead class="table-gradient text-white fs-5">
                                    <tr>
                                        <th class="text-start">Transaction ID</th>
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
                                            <td><code class="text-primary fs-5">{{ $payment->transaction_id }}</code></td>
                                            <td><span class="fw-bold text-success fs-5">৳{{ number_format($payment->amount) }}</span></td>
                                            <td>
                                                @if($payment->status === 'success')
                                                    <span class="badge bg-success rounded-pill fs-5">
                                                        <i class="bi bi-check-circle me-1"></i>Paid
                                                    </span>
                                                @elseif($payment->status === 'failed')
                                                    <span class="badge bg-danger rounded-pill fs-5">
                                                        <i class="bi bi-x-circle me-1"></i>Failed
                                                    </span>
                                                @elseif($payment->status === 'cancelled')
                                                    <span class="badge bg-warning rounded-pill text-dark fs-5">
                                                        <i class="bi bi-x-circle me-1"></i>Cancelled
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary rounded-pill fs-5">
                                                        <i class="bi bi-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info text-dark rounded-pill fs-5">{{ $payment->payment_method }}</span>
                                            </td>
                                            <td>
                                                <div class="text-muted fs-6">{{ $payment->created_at->format('M d, Y') }}</div>
                                                <div class="text-muted fs-6">{{ $payment->created_at->format('h:i A') }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark rounded-pill fs-5">{{ $payment->items->count() }} items</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-primary btn-3d btn-lg fs-5" onclick="viewPaymentDetails({{ $payment->id }})">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-5">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-receipt text-muted" style="font-size: 6rem;"></i>
                            </div>
                            <h3 class="fw-bold text-muted mb-3">No Payment History</h3>
                            <p class="text-muted fs-5 mb-4">You haven't made any payments yet.</p>
                            <a href="{{ route('home') }}#packages" class="btn btn-primary btn-3d btn-lg fs-5">
                                <i class="bi bi-plus-circle me-2"></i>Start Booking
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Gradient Table Header */
.table-gradient {
    background: linear-gradient(135deg, #0b74ff, #00b4ff);
    border-radius: 0.75rem 0.75rem 0 0;
}

/* Table hover effect */
.table-hover tbody tr:hover {
    background-color: rgba(11, 116, 255, 0.08);
    transform: translateY(-2px);
    transition: all 0.2s ease-in-out;
}

/* 3D Buttons */
.btn-3d {
    border-radius: 30px;
    padding: 12px 28px;
    box-shadow: 0 8px 15px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.5);
    transition: all 0.2s ease-in-out;
}

.btn-3d:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.5);
}

/* Rounded Badges */
.badge {
    font-size: 1rem;
    padding: 0.5em 0.75em;
}

/* Card styling */
.card {
    border-radius: 1rem;
}

/* Table text */
table {
    font-size: 1.2rem;
}

/* Headings */
h2, h3 {
    line-height: 1.3;
}

/* Responsive Table for smaller screens */
@media (max-width: 1200px) {
    .table-responsive {
        overflow-x: auto;
    }
}
</style>

<script>
function viewPaymentDetails(paymentId) {
    alert('Payment details for ID: ' + paymentId);
}
</script>
