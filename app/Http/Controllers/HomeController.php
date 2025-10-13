<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get all data for dashboard sections
        $flights = Flight::all();
        $hotels = Hotel::all();
        $packages = Package::all();

        // Pass them to the view
        return view('home', compact('flights', 'hotels', 'packages'));
    }
}
