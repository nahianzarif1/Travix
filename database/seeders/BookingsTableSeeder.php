<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        $bookings = [
            [
                'user_id' => $user->id,
                'type' => 'flight',
                'reference' => 'FL12345',
                'details' => [
                    'airline' => 'Biman Bangladesh',
                    'from' => 'DAC',
                    'to' => 'CXB',
                    'date' => '2025-10-09',
                    'departure' => '08:30',
                    'arrival' => '09:45',
                    'passengers' => 2,
                    'pnr' => 'ABCD12'
                ],
                'status' => 'confirmed',
                'amount' => 17000,
            ],
            [
                'user_id' => $user->id,
                'type' => 'hotel',
                'reference' => 'HT6789',
                'details' => [
                    'hotel' => 'Pan Pacific Sonargaon',
                    'location' => 'Dhaka',
                    'checkIn' => '2025-10-20',
                    'checkOut' => '2025-10-22',
                    'guests' => 2,
                    'rooms' => 1,
                    'image' => 'https://images.unsplash.com/photo-1613508999265-2acab7209645?q=80&w=800'
                ],
                'status' => 'confirmed',
                'amount' => 30000,
            ],
            [
                'user_id' => $user->id,
                'type' => 'tour',
                'reference' => 'TR4455',
                'details' => [
                    'tour' => 'Cox\'s Bazar Beach Paradise',
                    'duration' => '3D2N',
                    'startDate' => '2025-11-01',
                    'endDate' => '2025-11-03',
                    'participants' => 4,
                    'image' => 'https://images.unsplash.com/photo-1658076798013-654fb97e3111?q=80&w=800'
                ],
                'status' => 'confirmed',
                'amount' => 60000,
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::updateOrCreate(
                ['reference' => $booking['reference']],
                $booking
            );
        }
    }
}
