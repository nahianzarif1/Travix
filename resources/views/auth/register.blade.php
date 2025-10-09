@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card p-4 mt-5 border-0 shadow-3d">
        <div class="text-center mb-3">
          <h3 class="mb-0">Create your Travix account</h3>
          <small class="text-muted">Join to manage tours, bookings & events</small>
        </div>
        @if($errors->any())
          <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('register') }}">@csrf
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>
          </div>
          <button class="btn btn-success w-100 btn-3d">Register</button>
          <div class="text-center mt-3">Already have an account? <a href="{{ route('login') }}">Login</a></div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
