<div class="card p-4">
  <h4 class="mb-3">Flight Booking</h4>
  <p class="text-muted">Search and create flight bookings (form UI only). Connect this form to your flight booking backend later.</p>

  <form>
    <div class="row gy-2">
      <div class="col-md-4">
        <label class="form-label">From</label>
        <input type="text" class="form-control" placeholder="City or airport">
      </div>
      <div class="col-md-4">
        <label class="form-label">To</label>
        <input type="text" class="form-control" placeholder="City or airport">
      </div>
      <div class="col-md-2">
        <label class="form-label">Depart</label>
        <input type="date" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label">Return</label>
        <input type="date" class="form-control">
      </div>

      <div class="col-12 mt-3">
        <button class="btn btn-primary">Search Flights</button>
        <small class="text-muted ms-3">* This is a UI; connect to APIs to perform search & booking.</small>
      </div>
    </div>
  </form>
</div>
