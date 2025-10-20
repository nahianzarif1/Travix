<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchFlightRequest;
use App\Http\Requests\SearchHotelRequest;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $flights = Flight::all();
        $hotels = Hotel::all();
        $packages = Package::all();
        $flightSearchResults = session('flight_search_results');
        $hotelSearchResults = session('hotel_search_results');

        return view('home', compact('flights', 'hotels', 'packages', 'flightSearchResults', 'hotelSearchResults'));
    }

    public function searchFlights(SearchFlightRequest $request)
    {
        // Validation is now handled by SearchFlightRequest

        $query = Flight::query();

        if ($request->filled('from')) {
            $query->where('from_city', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('to_city', $request->to);
        }

        $flights = $query->get();

        return redirect()->route('home')
            ->with('flight_search_results', $flights)
            ->withInput()
            ->withFragment('flights');
    }

    public function searchHotels(SearchHotelRequest $request)
    {
        // Validation is now handled by SearchHotelRequest

        $query = Hotel::query();

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $hotels = $query->get();

        return redirect()->route('home')
            ->with('hotel_search_results', $hotels)
            ->withInput()
            ->withFragment('hotels');
    }
}