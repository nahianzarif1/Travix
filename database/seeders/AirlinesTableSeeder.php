<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Seeder;

class AirlinesTableSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            [
                'name' => 'Biman Bangladesh Airlines',
                'code' => 'BG',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/Biman_Bangladesh_Airlines_logo.svg/200px-Biman_Bangladesh_Airlines_logo.svg.png',
                'description' => 'National flag carrier of Bangladesh',
                'rating' => 4.2,
            ],
            [
                'name' => 'US-Bangla Airlines',
                'code' => 'BS',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/US-Bangla_Airlines_logo.svg/200px-US-Bangla_Airlines_logo.svg.png',
                'description' => 'Private airline of Bangladesh',
                'rating' => 4.0,
            ],
            [
                'name' => 'NovoAir',
                'code' => 'VQ',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/NovoAir_logo.svg/200px-NovoAir_logo.svg.png',
                'description' => 'Private airline based in Bangladesh',
                'rating' => 4.4,
            ],
            [
                'name' => 'Regent Airways',
                'code' => 'RX',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Regent_Airways_logo.svg/200px-Regent_Airways_logo.svg.png',
                'description' => 'Private airline of Bangladesh',
                'rating' => 3.8,
            ],
        ];

        foreach ($airlines as $airline) {
            Airline::updateOrCreate(
                ['code' => $airline['code']],
                $airline
            );
        }
    }
}