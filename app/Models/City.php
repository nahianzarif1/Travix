<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'country', 'latitude', 'longitude', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function flightsFrom()
    {
        return $this->hasMany(Flight::class, 'from_city_id');
    }

    public function flightsTo()
    {
        return $this->hasMany(Flight::class, 'to_city_id');
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'city_id');
    }
}