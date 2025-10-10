<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'image', 'rating', 'reviews', 'price', 
        'amenities', 'category', 'description', 'featured'
    ];

    protected $casts = [
        'amenities' => 'array',
        'featured' => 'boolean',
    ];
}
