<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Dhaka', 'code' => 'DAC', 'latitude' => 23.8103, 'longitude' => 90.4125],
            ['name' => 'Chittagong', 'code' => 'CGP', 'latitude' => 22.3569, 'longitude' => 91.7832],
            ['name' => 'Sylhet', 'code' => 'ZYL', 'latitude' => 24.9045, 'longitude' => 91.8611],
            ['name' => 'Jessore', 'code' => 'JSR', 'latitude' => 23.1688, 'longitude' => 89.2132],
            ['name' => 'Saidpur', 'code' => 'SPD', 'latitude' => 25.8007, 'longitude' => 88.9167],
            ['name' => 'Cox\'s Bazar', 'code' => 'CXB', 'latitude' => 21.4272, 'longitude' => 92.0058],
            ['name' => 'Rajshahi', 'code' => 'RJH', 'latitude' => 24.3745, 'longitude' => 88.6042],
            ['name' => 'Barisal', 'code' => 'BZL', 'latitude' => 22.7010, 'longitude' => 90.3535],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['code' => $city['code']],
                $city
            );
        }
    }
}