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

    // Flights search: filter flights based on criteria
    Route::get('/flights/search', function (Request $request) {
        $query = \App\Models\Flight::query();
        
        if ($request->filled('from')) {
            $query->where('from_city', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('to_city', $request->to);
        }
        
        $flights = $query->get();
        
        return redirect()->route('home', $request->all())
            ->with('search_results', $flights)
            ->withFragment('flights');
    })->name('flights.search');

    // Hotels search: filter hotels based on criteria
    Route::get('/hotels/search', function (Request $request) {
        $query = \App\Models\Hotel::query();
        
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        $hotels = $query->get();
        
        return redirect()->route('home', $request->all())
            ->with('search_results', $hotels)
            ->withFragment('hotels');
    })->name('hotels.search');

    // Booking routes
    Route::post('/bookings/flight', function (Request $request) {
        $flight = \App\Models\Flight::findOrFail($request->flight_id);
        $passengers = $request->passengers ?? 1;
        $totalAmount = $flight->price * $passengers;
        
        $booking = \App\Models\Booking::create([
            'user_id' => auth()->id(),
            'type' => 'flight',
            'reference' => 'FL' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'status' => 'confirmed',
            'details' => [
                'airline' => $flight->airline,
                'aircraft' => $flight->aircraft,
                'from' => $flight->from_city,
                'to' => $flight->to_city,
                'date' => $request->date ?? now()->addDays(7)->format('Y-m-d'),
                'departure' => $flight->departure,
                'arrival' => $flight->arrival,
                'duration' => $flight->duration,
                'passengers' => $passengers,
                'pnr' => 'PNR' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'base_price' => $flight->price,
                'total_price' => $totalAmount,
            ],
            'amount' => $totalAmount,
        ]);
        
        return redirect()->route('home')->withFragment('bookings')
            ->with('success', 'Flight booked successfully!');
    })->name('bookings.flight');

    Route::post('/bookings/hotel', function (Request $request) {
        $hotel = \App\Models\Hotel::findOrFail($request->hotel_id);
        $rooms = $request->rooms ?? 1;
        $nights = 2; // Default 2 nights
        $totalAmount = $hotel->price * $rooms * $nights;
        
        $booking = \App\Models\Booking::create([
            'user_id' => auth()->id(),
            'type' => 'hotel',
            'reference' => 'HT' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'status' => 'confirmed',
            'details' => [
                'hotel' => $hotel->name,
                'location' => $hotel->location,
                'category' => $hotel->category,
                'checkIn' => $request->check_in ?? now()->addDays(7)->format('Y-m-d'),
                'checkOut' => $request->check_out ?? now()->addDays(9)->format('Y-m-d'),
                'guests' => $request->guests ?? 2,
                'rooms' => $rooms,
                'nights' => $nights,
                'image' => $hotel->image,
                'base_price' => $hotel->price,
                'total_price' => $totalAmount,
            ],
            'amount' => $totalAmount,
        ]);
        
        return redirect()->route('home')->withFragment('bookings')
            ->with('success', 'Hotel booked successfully!');
    })->name('bookings.hotel');

    Route::post('/bookings/package', function (Request $request) {
        $package = \App\Models\Package::findOrFail($request->package_id);
        $participants = $request->participants ?? 2;
        $totalAmount = $package->price * $participants;
        
        $booking = \App\Models\Booking::create([
            'user_id' => auth()->id(),
            'type' => 'tour',
            'reference' => 'TR' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'status' => 'confirmed',
            'details' => [
                'tour' => $package->title,
                'location' => $package->location,
                'duration' => $package->duration,
                'category' => $package->category,
                'startDate' => $request->start_date ?? now()->addDays(14)->format('Y-m-d'),
                'endDate' => $request->end_date ?? now()->addDays(17)->format('Y-m-d'),
                'participants' => $participants,
                'image' => $package->image,
                'base_price' => $package->price,
                'total_price' => $totalAmount,
            ],
            'amount' => $totalAmount,
        ]);
        
        return redirect()->route('home')->withFragment('bookings')
            ->with('success', 'Tour package booked successfully!');
    })->name('bookings.package');

    // Payment routes
    Route::get('/payment', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
    Route::post('/payment/initiate', [\App\Http\Controllers\PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/fail', [\App\Http\Controllers\PaymentController::class, 'fail'])->name('payment.fail');
    Route::get('/payment/cancel', [\App\Http\Controllers\PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::get('/payment/history', [\App\Http\Controllers\PaymentController::class, 'history'])->name('payment.history');
});
