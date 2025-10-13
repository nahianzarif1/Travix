<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\PackagesTableSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'mobile_number' => '+8801712345678',
                'address' => '123 Main Street, Dhaka, Bangladesh',
            ]
        );

        $this->call([
            CitiesTableSeeder::class,
            AirlinesTableSeeder::class,
            PackagesTableSeeder::class,
            FlightsTableSeeder::class,
            HotelsTableSeeder::class,
            BookingsTableSeeder::class,
        ]);
    }
}
