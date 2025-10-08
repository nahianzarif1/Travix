@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card p-4 mt-4">
        <h4>Welcome, {{ auth()->user()->name }}</h4>
        <p class="text-muted">This is your Travix dashboard. From here you can manage bookings, clients, and events.</p>
        <div class="row">
          <div class="col-md-4">
            <div class="p-3 bg-white rounded shadow-sm">
              <h5>Bookings</h5><p class="mb-0">View and manage bookings.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 bg-white rounded shadow-sm">
              <h5>Packages</h5><p class="mb-0">Create and edit travel packages.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 bg-white rounded shadow-sm">
              <h5>Clients</h5><p class="mb-0">Client database & contacts.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
