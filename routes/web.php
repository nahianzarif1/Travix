<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Booking;

// Root route: redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Dashboard using HomeController
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Flight search
    Route::get('/flights/search', [HomeController::class, 'searchFlights'])->name('flights.search');

    // Hotel search
    // Hotel search
    Route::get('/hotels/search', [HomeController::class, 'searchHotels'])->name('hotels.search');

    // Flight booking
    Route::post('/bookings/flight', function (Request $request) {
        $flight = Flight::findOrFail($request->flight_id);
        $passengers = $request->passengers ?? 1;
        $totalAmount = $flight->price * $passengers;
        $travelDate = $request->date ?? now()->addDays(7)->format('Y-m-d');

        Booking::create([
            'user_id' => auth()->id(),
            'type' => 'flight',
            'reference' => 'FL' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'status' => 'confirmed',
            'booking_date' => now()->format('Y-m-d'),
            'travel_date' => $travelDate,
            'details' => [
                'airline' => $flight->airline,
                'aircraft' => $flight->aircraft,
                'from' => $flight->from_city,
                'to' => $flight->to_city,
                'date' => $travelDate,
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

    // Hotel booking
    Route::post('/bookings/hotel', function (Request $request) {
        $hotel = Hotel::findOrFail($request->hotel_id);
        $rooms = $request->rooms ?? 1;
        $nights = 2;
        $totalAmount = $hotel->price * $rooms * $nights;
        $checkIn = $request->check_in ?? now()->addDays(7)->format('Y-m-d');
        $checkOut = $request->check_out ?? now()->addDays(9)->format('Y-m-d');

        Booking::create([
            'user_id' => auth()->id(),
            'type' => 'hotel',
            'reference' => 'HT' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'status' => 'confirmed',
            'booking_date' => now()->format('Y-m-d'),
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'details' => [
                'hotel' => $hotel->name,
                'location' => $hotel->location,
                'category' => $hotel->category,
                'checkIn' => $checkIn,
                'checkOut' => $checkOut,
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

    // Package booking
    Route::post('/bookings/package', function (Request $request) {
        $package = Package::findOrFail($request->package_id);
        $participants = $request->participants ?? 2;
        $totalAmount = $package->price * $participants;
        $startDate = $request->start_date ?? now()->addDays(14)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->addDays(17)->format('Y-m-d');

        Booking::create([
            'user_id' => auth()->id(),
            'type' => 'tour',
            'reference' => 'TR' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'status' => 'confirmed',
            'booking_date' => now()->format('Y-m-d'),
            'travel_date' => $startDate,
            'details' => [
                'tour' => $package->title,
                'location' => $package->location,
                'duration' => $package->duration,
                'category' => $package->category,
                'startDate' => $startDate,
                'endDate' => $endDate,
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

    // Delete booking
    Route::delete('/bookings/{booking}', function (Booking $booking) {
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        if ($booking->status === 'paid') {
            return response()->json(['success' => false, 'message' => 'Cannot delete paid bookings'], 400);
        }
        $booking->delete();
        return response()->json(['success' => true, 'message' => 'Booking removed successfully']);
    })->name('bookings.delete');

    // Payment routes
    Route::get('/payment', [PaymentController::class, 'checkout'])->name('payment');
    Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::post('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
    Route::post('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');

    // Flights
    Route::get('/flights', [\App\Http\Controllers\AdminController::class, 'flights'])->name('flights');
    Route::post('/flights', [\App\Http\Controllers\AdminController::class, 'storeFlight'])->name('flights.store');
    Route::put('/flights/{flight}', [\App\Http\Controllers\AdminController::class, 'updateFlight'])->name('flights.update');
    Route::delete('/flights/{flight}', [\App\Http\Controllers\AdminController::class, 'deleteFlight'])->name('flights.delete');

    // Hotels
    Route::get('/hotels', [\App\Http\Controllers\AdminController::class, 'hotels'])->name('hotels');
    Route::post('/hotels', [\App\Http\Controllers\AdminController::class, 'storeHotel'])->name('hotels.store');
    Route::put('/hotels/{hotel}', [\App\Http\Controllers\AdminController::class, 'updateHotel'])->name('hotels.update');
    Route::delete('/hotels/{hotel}', [\App\Http\Controllers\AdminController::class, 'deleteHotel'])->name('hotels.delete');

    // Packages
    Route::get('/packages', [\App\Http\Controllers\AdminController::class, 'packages'])->name('packages');
    Route::post('/packages', [\App\Http\Controllers\AdminController::class, 'storePackage'])->name('packages.store');
    Route::put('/packages/{package}', [\App\Http\Controllers\AdminController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/packages/{package}', [\App\Http\Controllers\AdminController::class, 'deletePackage'])->name('packages.delete');
});