<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;

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

    // Flights search (UI stub): persists query then returns to flights section
    Route::get('/flights/search', function (Request $request) {
        // In a real app, call service/API and pass results to view.
        // For now, just redirect to the flights section keeping the hash.
        return redirect()->route('home', $request->all())->with('search', $request->all())->withFragment('flights');
    })->name('flights.search');

    // Hotels search (UI stub): persists query then returns to hotels section
    Route::get('/hotels/search', function (Request $request) {
        return redirect()->route('home', $request->all())->with('search', $request->all())->withFragment('hotels');
    })->name('hotels.search');
});
