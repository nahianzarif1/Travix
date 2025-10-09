@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4 mt-5 border-0 shadow-3d">
        <div class="text-center mb-3">
          <h3 class="mb-0">Travix Login</h3>
          <small class="text-muted">Sign in to manage bookings & events</small>
        </div>
        @if($errors->any())
          <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">@csrf
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button class="btn btn-success w-100 btn-3d">Login</button>
          <div class="text-center mt-3">Don't have an account? <a href="{{ route('register') }}">Register</a></div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
