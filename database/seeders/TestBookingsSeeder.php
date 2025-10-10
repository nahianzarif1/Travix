<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use Illuminate\Database\Seeder;

class TestBookingsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'mobile_number' => '+8801712345678',
                'address' => '123 Main Street, Dhaka, Bangladesh',
            ]);
        }

        // Get some flights, hotels, and packages
        $flight = Flight::first();
        $hotel = Hotel::first();
        $package = Package::first();

        if ($flight) {
            Booking::create([
                'user_id' => $user->id,
                'type' => 'flight',
                'reference' => 'FL' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
                'status' => 'confirmed',
                'details' => [
                    'airline' => $flight->airline,
                    'aircraft' => $flight->aircraft,
                    'from' => $flight->from_city,
                    'to' => $flight->to_city,
                    'departure' => $flight->departure,
                    'arrival' => $flight->arrival,
                    'duration' => $flight->duration,
                    'passengers' => 2,
                    'pnr' => 'PNR' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'base_price' => $flight->price,
                    'total_price' => $flight->price * 2,
                ],
                'amount' => $flight->price * 2,
            ]);
        }

        if ($hotel) {
            Booking::create([
                'user_id' => $user->id,
                'type' => 'hotel',
                'reference' => 'HT' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
                'status' => 'confirmed',
                'details' => [
                    'hotel' => $hotel->name,
                    'location' => $hotel->location,
                    'category' => $hotel->category,
                    'checkIn' => now()->addDays(7)->format('Y-m-d'),
                    'checkOut' => now()->addDays(9)->format('Y-m-d'),
                    'guests' => 2,
                    'rooms' => 1,
                    'nights' => 2,
                    'image' => $hotel->image,
                    'base_price' => $hotel->price,
                    'total_price' => $hotel->price * 2,
                ],
                'amount' => $hotel->price * 2,
            ]);
        }

        if ($package) {
            Booking::create([
                'user_id' => $user->id,
                'type' => 'tour',
                'reference' => 'TR' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
                'status' => 'confirmed',
                'details' => [
                    'tour' => $package->title,
                    'location' => $package->location,
                    'duration' => $package->duration,
                    'category' => $package->category,
                    'startDate' => now()->addDays(14)->format('Y-m-d'),
                    'endDate' => now()->addDays(17)->format('Y-m-d'),
                    'participants' => 2,
                    'image' => $package->image,
                    'base_price' => $package->price,
                    'total_price' => $package->price * 2,
                ],
                'amount' => $package->price * 2,
            ]);
        }
    }
}
