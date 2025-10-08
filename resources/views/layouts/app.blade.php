<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travix') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body{ font-family: 'Poppins', sans-serif; background: linear-gradient(180deg,#f6fbff,#eaf6ff); min-height:100vh;}
        .navbar{ background: linear-gradient(90deg,#0b74ff,#00b4ff); }
        .navbar-brand, .nav-link{ color: #fff !important; font-weight:600;}
        .card{ border-radius:1rem; box-shadow:0 12px 30px rgba(12,38,80,.12); }
        .hero-gradient{ background: linear-gradient(180deg, rgba(11,116,255,0.06), rgba(0,180,255,0.02)); padding:40px 0; }
        .btn-primary{ background:#0b74ff; border-color:#0b74ff; border-radius:30px; padding:10px 22px;}
        .btn-primary:hover{ background:#065fcc; border-color:#065fcc;}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Travix') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto">
                @guest
                    @if(Route::has('login'))<li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>@endif
                    @if(Route::has('register'))<li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>@endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('home') }}">Dashboard</a>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
