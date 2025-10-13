<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travix') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --primary-1:#0b74ff; /* base blue */
            --primary-2:#00b4ff; /* accent cyan */
            --primary-3:#003973; /* deep navy */
            --surface-1:#ffffff; /* card/base */
            --surface-2:#f6f9ff; /* soft bg */
            --shadow-color:12,38,80; /* for rgba */
            --glass:#ffffff40;
        }

        body{ font-family: 'Poppins', sans-serif; background: radial-gradient(1200px 600px at -10% -10%, #eaf3ff 0%, transparent 40%), radial-gradient(1000px 500px at 110% 10%, #e6fbff 0%, transparent 40%), linear-gradient(180deg,#f7fbff,#eef7ff); min-height:100vh;}
        .navbar{ background: linear-gradient(90deg,var(--primary-3),var(--primary-1),var(--primary-2)); box-shadow: 0 10px 25px rgba(var(--shadow-color),.18); }
        .navbar .navbar-brand, .navbar .nav-link{ color: #fff !important; font-weight:600;}

        /* Dashboard topbar navigation */
        .topbar .nav-link{ color: #344767 !important; font-weight:600; }
        .topbar .nav-link.active{ color: var(--primary-1) !important; }
        .topbar .nav-link:hover{ color: var(--primary-2) !important; }

        .card{ border-radius:1rem; border: 1px solid #e9eef9; box-shadow:0 18px 45px rgba(var(--shadow-color),.12), inset 0 1px 0 rgba(255,255,255,.8); background:linear-gradient(180deg,#ffffff, #fbfdff);}
        .shadow-3d{ box-shadow: 0 24px 50px rgba(var(--shadow-color),.18), 0 8px 18px rgba(var(--shadow-color),.08); }
        .glass-3d{ backdrop-filter: blur(8px); background: var(--glass); border: 1px solid #ffffff80; box-shadow: 0 20px 40px rgba(var(--shadow-color),.12); }

        .hero-gradient{ background: radial-gradient(800px 400px at 20% -10%, rgba(11,116,255,.10), transparent 60%), radial-gradient(800px 400px at 80% -20%, rgba(0,180,255,.08), transparent 60%); padding:40px 0; }

        .btn-primary{ background: linear-gradient(180deg,var(--primary-1),#0862da); border: 0; border-radius:30px; padding:10px 22px; box-shadow: 0 8px 20px rgba(11,116,255,.35), inset 0 1px 0 rgba(255,255,255,.5);}        
        .btn-primary:hover{ transform: translateY(-1px); filter: brightness(1.02); box-shadow: 0 10px 24px rgba(11,116,255,.42), inset 0 1px 0 rgba(255,255,255,.6);}        

        .bg-gradient-primary{ background: linear-gradient(180deg,var(--primary-1),var(--primary-2)); }
        .bg-soft{ background: #f0f6ff; color: var(--primary-3); border: 1px solid #e0ecff; }
        .form-control-soft{ background: #f9fbff; border: 1px solid #e3ecfb; }
        .input-group-text.bg-soft{ border-color:#e3ecfb; }
        .btn-3d{ box-shadow: 0 10px 20px rgba(11,116,255,.25); }
        .hover-bg-soft:hover{ background:#f7faff; }
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
