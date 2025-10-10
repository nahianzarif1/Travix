<div class="container-fluid">
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-3d">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">💳 Payment History</h5>
                        <a href="{{ route('payment') }}" class="btn btn-success btn-3d">
                            <i class="bi bi-plus-circle me-2"></i>
                            New Payment
                        </a>
                    </div>

                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payment Method</th>
                                        <th>Items</th>
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
                                                <div>{{ $payment->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">৳{{ number_format($payment->amount) }}</div>
                                                <small class="text-muted">{{ $payment->currency }}</small>
                                            </td>
                                            <td>
                                                @if($payment->status === 'success')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Success
                                                    </span>
                                                @elseif($payment->status === 'pending')
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock me-1"></i>
                                                        Pending
                                                    </span>
                                                @elseif($payment->status === 'failed')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>
                                                        Failed
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-dash-circle me-1"></i>
                                                        Cancelled
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $payment->payment_method ?? 'N/A' }}</div>
                                                @if($payment->mobile_number)
                                                    <small class="text-muted">{{ $payment->mobile_number }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($payment->items as $item)
                                                        <span class="badge bg-light text-dark">
                                                            @if($item->item_type === 'flight')
                                                                ✈️
                                                            @elseif($item->item_type === 'hotel')
                                                                🏨
                                                            @else
                                                                🎒
                                                            @endif
                                                            {{ ucfirst($item->item_type) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" onclick="viewPaymentDetails({{ $payment->id }})">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    @if($payment->status === 'success')
                                                        <a href="#" class="btn btn-outline-success">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    @endif
                                                </div>
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
                            <a href="{{ route('home') }}#packages" class="btn btn-success btn-3d">
                                <i class="bi bi-plus-circle me-2"></i>
                                Start Booking
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="paymentDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function viewPaymentDetails(paymentId) {
    // This would typically make an AJAX call to get payment details
    // For now, we'll show a simple message
    document.getElementById('paymentDetailsContent').innerHTML = `
        <div class="text-center py-3">
            <i class="bi bi-info-circle text-primary" style="font-size: 2rem;"></i>
            <p class="mt-2">Payment details for transaction #${paymentId}</p>
            <p class="text-muted small">Detailed payment information would be displayed here.</p>
        </div>
    `;
    
    new bootstrap.Modal(document.getElementById('paymentDetailsModal')).show();
}
</script>
