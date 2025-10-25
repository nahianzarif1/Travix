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
    :root {
        --primary-1: #0b74ff;
        --primary-2: #00b4ff;
        --primary-3: #003973;
        --surface-1: #ffffff;
        --surface-2: #f6f9ff;
        --shadow-color: 12, 38, 80;
        --glass: #ffffff40;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: radial-gradient(1200px 600px at -10% -10%, #eaf3ff 0%, transparent 40%),
                    radial-gradient(1000px 500px at 110% 10%, #e6fbff 0%, transparent 40%),
                    linear-gradient(180deg, #f7fbff, #eef7ff);
        min-height: 100vh;
    }
    /* ================= Custom 3D Button for Search Flight ================= */
.btn-3d {
    border-radius: 30px;
    padding: 12px 28px;
    box-shadow: 0 8px 15px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.5);
    transition: all 0.2s ease-in-out;
    font-weight: 500;
    border: none;
}

.btn-3d:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.5);
}

.btn-custom {
    background-color: #198754; /* green color */
    color: #fff; /* white text */
}

.btn-custom:hover {
    background-color: #157347; /* darker green on hover */
    color: #fff;
}


    /* ✅ Navbar customization */
    .navbar {
        background-color: #198754 !important; /* solid green background */
        box-shadow: 0 10px 25px rgba(var(--shadow-color), .18);
    }

    .navbar .navbar-brand,
    .navbar .nav-link {
        color: #fff !important; /* white text */
        font-weight: 600;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.9%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .card {
        border-radius: 1rem;
        border: 1px solid #e9eef9;
        box-shadow: 0 18px 45px rgba(var(--shadow-color), .12), inset 0 1px 0 rgba(255, 255, 255, .8);
        background: linear-gradient(180deg, #ffffff, #fbfdff);
    }

    .btn-primary {
        background: linear-gradient(180deg, var(--primary-1), #0862da);
        border: 0;
        border-radius: 30px;
        padding: 10px 22px;
        box-shadow: 0 8px 20px rgba(11, 116, 255, .35), inset 0 1px 0 rgba(255, 255, 255, .5);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        filter: brightness(1.02);
        box-shadow: 0 10px 24px rgba(11, 116, 255, .42), inset 0 1px 0 rgba(255, 255, 255, .6);
    }

    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(var(--shadow-color), .15);
    }

    .navbar .dropdown-menu {
        right: 0 !important;
        left: auto !important;
        transform: none !important;
        margin-top: 10px;
        position: absolute !important;
        z-index: 1050;
    }

    @media (max-width: 992px) {
        .navbar .dropdown-menu {
            right: 10px !important;
            left: auto !important;
        }
    }
</style>

</head>

<body>
    {{-- ✅ Hide top navbar for both user and admin dashboards --}}
    @if (!Request::is('dashboard*') && !Request::is('home*') && !Request::is('admin/dashboard*'))
        <nav class="navbar navbar-expand-md">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Travix') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent"
                    aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            @if (Auth::user()->is_admin)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                                       id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('payment.history') }}">Payment History</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="#"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            @endif
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    <main class>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
