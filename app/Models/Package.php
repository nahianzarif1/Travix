<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','image','category','location','duration','rating','reviews','price','original_price','highlights','includes','group_size'
    ];

    protected $casts = [
        'highlights' => 'array',
        'includes' => 'array',
    ];
}


