<?php

namespace Database\Seeders;

use App\Models\Flight;
use Illuminate\Database\Seeder;

class FlightsTableSeeder extends Seeder
{
    public function run(): void
    {
        $flights = [
            [
                'airline' => 'Biman Bangladesh Airlines',
                'aircraft' => 'Boeing 737',
                'from_city' => 'DAC',
                'to_city' => 'CXB',
                'departure' => '08:30:00',
                'arrival' => '09:45:00',
                'duration' => '1h 15m',
                'price' => 8500.00,
                'rating' => 4.2,
                'amenities' => ['Wifi', 'Meal', 'Entertainment'],
            ],
            [
                'airline' => 'US-Bangla Airlines',
                'aircraft' => 'ATR 72',
                'from_city' => 'DAC',
                'to_city' => 'CXB',
                'departure' => '14:15:00',
                'arrival' => '15:30:00',
                'duration' => '1h 15m',
                'price' => 7800.00,
                'rating' => 4.0,
                'amenities' => ['Meal', 'Entertainment'],
            ],
            [
                'airline' => 'NovoAir',
                'aircraft' => 'Embraer E145',
                'from_city' => 'DAC',
                'to_city' => 'CXB',
                'departure' => '18:00:00',
                'arrival' => '19:15:00',
                'duration' => '1h 15m',
                'price' => 9200.00,
                'rating' => 4.4,
                'amenities' => ['Wifi', 'Meal', 'Priority Boarding'],
            ],
            [
                'airline' => 'Regent Airways',
                'aircraft' => 'Dash 8',
                'from_city' => 'DAC',
                'to_city' => 'CGP',
                'departure' => '12:30:00',
                'arrival' => '13:30:00',
                'duration' => '1h 00m',
                'price' => 6500.00,
                'rating' => 3.8,
                'amenities' => ['Meal'],
            ],
        ];

        foreach ($flights as $flight) {
            Flight::updateOrCreate(
                ['airline' => $flight['airline'], 'from_city' => $flight['from_city'], 'to_city' => $flight['to_city'], 'departure' => $flight['departure']],
                $flight
            );
        }
    }
}
