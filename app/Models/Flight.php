<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline', 'aircraft', 'from_city', 'to_city', 'departure', 'arrival', 
        'duration', 'price', 'rating', 'amenities',
        'airline_id', 'from_city_id', 'to_city_id', 'is_active', 'available_seats'
    ];

    protected $casts = [
        'amenities' => 'array',
        'departure' => 'datetime:H:i',
        'arrival' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'flight_id');
    }
}
