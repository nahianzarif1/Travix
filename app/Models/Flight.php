<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline', 'aircraft', 'from_city', 'to_city', 'departure', 'arrival', 
        'duration', 'price', 'rating', 'amenities'
    ];

    protected $casts = [
        'amenities' => 'array',
        'departure' => 'datetime:H:i',
        'arrival' => 'datetime:H:i',
    ];
}
