<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1️⃣ Root route: redirect to login if guest, else dashboard
Route::get('/', function () {
    return auth()->check() ? redirect()->route('login') : redirect()->route('login');
});

// 2️⃣ Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// 3️⃣ Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// 4️⃣ Dashboard route (protected by auth)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home'); // this is your dashboard Blade
    })->name('home');
});
