<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\City;
use App\Models\Airline;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_flights' => Flight::count(),
            'total_hotels' => Hotel::count(),
            'total_packages' => Package::count(),
            'total_bookings' => Booking::count(),
            'total_payments' => Payment::count(),
            'revenue' => Payment::where('status', 'success')->sum('amount'),
        ];

        $recent_bookings = Booking::with('user')->latest()->take(5)->get();
        $recent_payments = Payment::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'recent_payments'));
    }

    public function flights()
    {
        $flights = Flight::with(['airline', 'fromCity', 'toCity'])->paginate(10);
        $airlines = Airline::all();
        $cities = City::all();
        
        return view('admin.flights', compact('flights', 'airlines', 'cities'));
    }

    public function storeFlight(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'from_city_id' => 'required|exists:cities,id',
            'to_city_id' => 'required|exists:cities,id',
            'aircraft' => 'required|string',
            'departure' => 'required|date_format:H:i',
            'arrival' => 'required|date_format:H:i',
            'duration' => 'required|string',
            'price' => 'required|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'amenities' => 'nullable|array',
        ]);

        $data = $request->all();
        if ($request->has('amenities_text')) {
            $data['amenities'] = array_map('trim', explode(',', $request->amenities_text));
        }
        $flight = Flight::create($data);
        
        return redirect()->route('admin.flights')->with('success', 'Flight added successfully!');
    }

    public function updateFlight(Request $request, Flight $flight)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'from_city_id' => 'required|exists:cities,id',
            'to_city_id' => 'required|exists:cities,id',
            'aircraft' => 'required|string',
            'departure' => 'required|date_format:H:i',
            'arrival' => 'required|date_format:H:i',
            'duration' => 'required|string',
            'price' => 'required|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'amenities' => 'nullable|array',
        ]);

        $flight->update($request->all());
        
        return redirect()->route('admin.flights')->with('success', 'Flight updated successfully!');
    }

    public function deleteFlight(Flight $flight)
    {
        $flight->delete();
        
        return redirect()->route('admin.flights')->with('success', 'Flight deleted successfully!');
    }

    public function hotels()
    {
        $hotels = Hotel::paginate(10);
        $cities = City::all();
        
        return view('admin.hotels', compact('hotels', 'cities'));
    }

    public function storeHotel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:100',
            'image' => 'nullable|string|max:500',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'amenities' => 'nullable|array',
            'category' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'featured' => 'boolean',
        ]);

        Hotel::create($request->all());
        
        return redirect()->route('admin.hotels')->with('success', 'Hotel added successfully!');
    }

    public function updateHotel(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:100',
            'image' => 'nullable|string|max:500',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'amenities' => 'nullable|array',
            'category' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'featured' => 'boolean',
        ]);

        $hotel->update($request->all());
        
        return redirect()->route('admin.hotels')->with('success', 'Hotel updated successfully!');
    }

    public function deleteHotel(Hotel $hotel)
    {
        $hotel->delete();
        
        return redirect()->route('admin.hotels')->with('success', 'Hotel deleted successfully!');
    }

    public function packages()
    {
        $packages = Package::paginate(10);
        
        return view('admin.packages', compact('packages'));
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'highlights' => 'nullable|array',
            'includes' => 'nullable|array',
            'group_size' => 'nullable|string|max:50',
        ]);

        Package::create($request->all());
        
        return redirect()->route('admin.packages')->with('success', 'Package added successfully!');
    }

    public function updatePackage(Request $request, Package $package)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'highlights' => 'nullable|array',
            'includes' => 'nullable|array',
            'group_size' => 'nullable|string|max:50',
        ]);

        $package->update($request->all());
        
        return redirect()->route('admin.packages')->with('success', 'Package updated successfully!');
    }

    public function deletePackage(Package $package)
    {
        $package->delete();
        
        return redirect()->route('admin.packages')->with('success', 'Package deleted successfully!');
    }
}