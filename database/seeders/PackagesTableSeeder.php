<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'title' => "Cox's Bazar Beach Paradise",
                'location' => "Cox's Bazar",
                'duration' => '3 Days 2 Nights',
                'price' => 15000,
                'original_price' => 18000,
                'rating' => 4.7,
                'reviews' => 245,
                'image' => 'https://images.unsplash.com/photo-1658076798013-654fb97e3111?auto=format&fit=crop&w=1080&q=80',
                'category' => 'Beach',
                'highlights' => ['Longest Beach','Sunset Point','Marine Drive'],
                'includes' => ['Hotel','Meals','Transport','Guide'],
                'group_size' => '2-15 people',
            ],
            [
                'title' => 'Sylhet Tea Garden Retreat',
                'location' => 'Sylhet',
                'duration' => '2 Days 1 Night',
                'price' => 12000,
                'original_price' => 15000,
                'rating' => 4.5,
                'reviews' => 156,
                'image' => 'https://images.unsplash.com/photo-1667120205301-a2a3a886886e?auto=format&fit=crop&w=1080&q=80',
                'category' => 'Nature',
                'highlights' => ['Tea Gardens','Jaflong','Hill Views'],
                'includes' => ['Hotel','Breakfast','Transport','Tea Tasting'],
                'group_size' => '2-10 people',
            ],
        ];

        foreach ($data as $row) {
            Package::updateOrCreate(['title' => $row['title']], $row);
        }
    }
}


