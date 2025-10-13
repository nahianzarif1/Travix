<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','type','reference','status','details','amount','booking_date','travel_date','check_in_date','check_out_date'
    ];

    protected $casts = [
        'details' => 'array',
        'booking_date' => 'date',
        'travel_date' => 'date',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class);
    }
}


