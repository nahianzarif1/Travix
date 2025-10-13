<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'logo', 'description', 'rating', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'decimal:1',
    ];

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}