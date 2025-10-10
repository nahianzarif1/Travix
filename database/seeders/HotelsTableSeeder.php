<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelsTableSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Pan Pacific Sonargaon Dhaka',
                'location' => 'Dhaka',
                'image' => 'https://images.unsplash.com/photo-1613508999265-2acab7209645?q=80&w=1080',
                'rating' => 4.8,
                'reviews' => 2340,
                'price' => 15000.00,
                'amenities' => ['Wifi', 'Pool', 'Spa', 'Restaurant', 'Gym', 'Parking'],
                'category' => '5-Star',
                'description' => 'Luxury hotel in the heart of Dhaka with world-class amenities',
                'featured' => true,
            ],
            [
                'name' => 'Sea Palace Hotel & Resort',
                'location' => 'Cox\'s Bazar',
                'image' => 'https://images.unsplash.com/photo-1658076798013-654fb97e3111?q=80&w=1080',
                'rating' => 4.6,
                'reviews' => 1820,
                'price' => 8500.00,
                'amenities' => ['Wifi', 'Beach Access', 'Restaurant', 'Spa', 'Pool'],
                'category' => '4-Star',
                'description' => 'Beachfront resort with stunning ocean views',
                'featured' => true,
            ],
            [
                'name' => 'Sylhet Grand Hotel',
                'location' => 'Sylhet',
                'image' => 'https://images.unsplash.com/photo-1667120205301-a2a3a886886e?q=80&w=1080',
                'rating' => 4.3,
                'reviews' => 890,
                'price' => 6500.00,
                'amenities' => ['Wifi', 'Restaurant', 'Gym', 'Parking'],
                'category' => '3-Star',
                'description' => 'Comfortable hotel in the heart of Sylhet city',
                'featured' => false,
            ],
        ];

        foreach ($hotels as $hotel) {
            Hotel::updateOrCreate(
                ['name' => $hotel['name'], 'location' => $hotel['location']],
                $hotel
            );
        }
    }
}
