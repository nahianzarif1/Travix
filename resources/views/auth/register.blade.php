@extends('layouts.app')
@section('content')
<style>
/* Full-page background */
body, html {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Background image */
.register-background {
    background: url('{{ asset('images/register-image.jpg') }}') no-repeat center center;
    background-size: cover;
    height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Register card */
.register-card {
    background-color: rgba(255, 255, 255, 0.55); /* light semi-transparent card */
    border-radius: 15px;
    padding: 40px;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Headings */
.register-card h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
}

/* Small text */
.register-card small {
    font-size: 0.95rem;
    color: #555;
}

/* Form controls */
.register-card .form-control {
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 15px;
    font-size: 1rem;
    border: 1px solid #ccc;
}

.register-card .form-control:focus {
    border-color: #198754;
    box-shadow: 0 0 5px rgba(13, 144, 96, 0.5);
}

/* Button */
.btn-register {
    background-color: #198754;
    color: #fff;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 8px;
    padding: 12px;
    transition: all 0.3s ease;
}

.btn-register:hover {
    background-color: #198754;
}

/* Links */
.register-card a {
    color: #198754;
    font-weight: 500;
}

.register-card a:hover {
    color: #198754;
}

/* Error alert */
.alert {
    font-size: 0.9rem;
}
</style>

<div class="register-background">
    <div class="register-card text-center">
        <h3>Create your Travix account</h3>
        <small>Join to manage tours, bookings & events</small>

        @if($errors->any())
            <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="mt-4">
            @csrf
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Full Name" required>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-register w-100 mt-2">Register</button>
        </form>

        <div class="mt-3">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>
@endsection
