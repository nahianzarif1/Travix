<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-3d">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="mb-0 fw-bold">💳 Payment History</h5>
                            <small class="text-muted">Track all your payment transactions</small>
                        </div>
                        <a href="{{ route('home') }}#payments" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i>Back to Payments
                        </a>
                    </div>

                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
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
                                            <td>
                                                <code class="text-primary">{{ $payment->transaction_id }}</code>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">৳{{ number_format($payment->amount) }}</span>
                                            </td>
                                            <td>
                                                @if($payment->status === 'success')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Paid
                                                    </span>
                                                @elseif($payment->status === 'failed')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Failed
                                                    </span>
                                                @elseif($payment->status === 'cancelled')
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-x-circle me-1"></i>Cancelled
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $payment->payment_method }}</span>
                                            </td>
                                            <td>
                                                <div class="text-muted small">
                                                    {{ $payment->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ $payment->created_at->format('h:i A') }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ $payment->items->count() }} items
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-primary btn-sm" onclick="viewPaymentDetails({{ $payment->id }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-receipt text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="fw-bold text-muted">No Payment History</h5>
                            <p class="text-muted">You haven't made any payments yet.</p>
                            <a href="{{ route('home') }}#packages" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Start Booking
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewPaymentDetails(paymentId) {
    // This would open a modal with payment details
    alert('Payment details for ID: ' + paymentId);
}
</script>