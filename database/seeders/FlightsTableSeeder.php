<?php

namespace Database\Seeders;

use App\Models\Flight;
use Illuminate\Database\Seeder;

class FlightsTableSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = \App\Models\Airline::all();
        $cities = \App\Models\City::all();
        
        $flights = [
            [
                'airline_code' => 'BG',
                'aircraft' => 'Boeing 737',
                'from_city_code' => 'DAC',
                'to_city_code' => 'CXB',
                'departure' => '08:30:00',
                'arrival' => '09:45:00',
                'duration' => '1h 15m',
                'price' => 8500.00,
                'rating' => 4.2,
                'amenities' => ['Wifi', 'Meal', 'Entertainment'],
            ],
            [
                'airline_code' => 'BS',
                'aircraft' => 'ATR 72',
                'from_city_code' => 'DAC',
                'to_city_code' => 'CXB',
                'departure' => '14:15:00',
                'arrival' => '15:30:00',
                'duration' => '1h 15m',
                'price' => 7800.00,
                'rating' => 4.0,
                'amenities' => ['Meal', 'Entertainment'],
            ],
            [
                'airline_code' => 'VQ',
                'aircraft' => 'Embraer E145',
                'from_city_code' => 'DAC',
                'to_city_code' => 'CXB',
                'departure' => '18:00:00',
                'arrival' => '19:15:00',
                'duration' => '1h 15m',
                'price' => 9200.00,
                'rating' => 4.4,
                'amenities' => ['Wifi', 'Meal', 'Priority Boarding'],
            ],
            [
                'airline_code' => 'RX',
                'aircraft' => 'Dash 8',
                'from_city_code' => 'DAC',
                'to_city_code' => 'CGP',
                'departure' => '12:30:00',
                'arrival' => '13:30:00',
                'duration' => '1h 00m',
                'price' => 6500.00,
                'rating' => 3.8,
                'amenities' => ['Meal'],
            ],
        ];

        foreach ($flights as $flightData) {
            $airline = $airlines->where('code', $flightData['airline_code'])->first();
            $fromCity = $cities->where('code', $flightData['from_city_code'])->first();
            $toCity = $cities->where('code', $flightData['to_city_code'])->first();
            
            if ($airline && $fromCity && $toCity) {
                Flight::updateOrCreate(
                    [
                        'airline' => $airline->name,
                        'from_city' => $flightData['from_city_code'],
                        'to_city' => $flightData['to_city_code'],
                        'departure' => $flightData['departure']
                    ],
                    [
                        'airline' => $airline->name,
                        'aircraft' => $flightData['aircraft'],
                        'from_city' => $flightData['from_city_code'],
                        'to_city' => $flightData['to_city_code'],
                        'departure' => $flightData['departure'],
                        'arrival' => $flightData['arrival'],
                        'duration' => $flightData['duration'],
                        'price' => $flightData['price'],
                        'rating' => $flightData['rating'],
                        'amenities' => $flightData['amenities'],
                        'airline_id' => $airline->id,
                        'from_city_id' => $fromCity->id,
                        'to_city_id' => $toCity->id,
                    ]
                );
            }
        }
    }
}
