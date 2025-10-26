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
.login-background {
    background: url('{{ asset('images/login-image.jpg') }}') no-repeat center center;
    background-size: cover;
    height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Login card */
.login-card {
    background-color: rgba(255, 255, 255, 0.75); /* light semi-transparent card */
    border-radius: 15px;
    padding: 40px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Headings */
.login-card h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

/* Small text */
.login-card small {
    font-size: 0.95rem;
    color: #555;
}

/* Form controls */
.login-card .form-control {
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 15px;
    font-size: 1rem;
    border: 1px solid #ccc;
}

.login-card .form-control:focus {
    border-color: #198754;
    box-shadow: 0 0 5px rgba(17, 185, 135, 0.6);
}

/* Button */
.btn-login {
    background-color: #198754;
    color: #fff;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 8px;
    padding: 12px;
    transition: all 0.3s ease;
}

.btn-login:hover {
    background-color: #198754;
}

/* Links */
.login-card a {
    color: #198754;
    font-weight: 500;
}

.login-card a:hover {
    color: #198754;
}

/* Error alert */
.alert {
    font-size: 0.9rem;
}
</style>

<div class="login-background">
    <div class="login-card text-center">
        <h2>Travix Login</h2>
        <small>Sign in to manage bookings & events</small>

        @if($errors->any())
            <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-4">
            @csrf
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-login w-100 mt-2">Login</button>
        </form>

        <div class="mt-3 d-flex justify-content-between">
            <!--<a href="{{ route('password.request') }}">Forgot your password?</a>-->
            <span>Don't have an account? <a href="{{ route('register') }}">Register</a></span>
        </div>
    </div>
</div>
@endsection
