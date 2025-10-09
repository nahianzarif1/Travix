<div class="container-fluid">
    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-3d">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Payments</h5>
                        <span class="badge bg-gradient-primary">Secure</span>
                    </div>

                    <form>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Cardholder Name</label>
                                <input type="text" class="form-control form-control-soft" placeholder="John Doe">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Card Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-soft">💳</span>
                                    <input type="text" class="form-control form-control-soft" placeholder="1234 5678 9012 3456">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Expiry</label>
                                <input type="text" class="form-control form-control-soft" placeholder="MM/YY">
                            </div>
                            <div class="col-6">
                                <label class="form-label">CVC</label>
                                <input type="password" class="form-control form-control-soft" placeholder="***">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Billing Address</label>
                                <input type="text" class="form-control form-control-soft" placeholder="Street, City, Country">
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="saveCard">
                                <label class="form-check-label" for="saveCard">Save card for future payments</label>
                            </div>
                            <button type="button" class="btn btn-primary btn-3d">Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-3d">
                <div class="card-body p-4">
                    <h6 class="mb-3">Payment Summary</h6>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Subtotal</span>
                        <span>$820.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Taxes</span>
                        <span>$65.60</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Fees</span>
                        <span>$12.40</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong>Total</strong>
                        <strong>$898.00</strong>
                    </div>

                    <div class="d-flex gap-2">
                        <span class="badge bg-soft">Visa</span>
                        <span class="badge bg-soft">Mastercard</span>
                        <span class="badge bg-soft">AmEx</span>
                        <span class="badge bg-soft">bKash</span>
                    </div>
                </div>
            </div>

            <div class="card mt-4 border-0 glass-3d">
                <div class="card-body p-4">
                    <h6 class="mb-2">Tips</h6>
                    <p class="text-muted small mb-0">Ensure your billing address matches your card’s address to avoid declines.</p>
                </div>
            </div>
        </div>
    </div>
</div>

