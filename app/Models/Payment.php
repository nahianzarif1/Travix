<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'transaction_id', 'sslcommerz_sessionkey', 'sslcommerz_tran_id',
        'amount', 'currency', 'status', 'payment_method', 'mobile_number',
        'customer_info', 'sslcommerz_response', 'failure_reason', 'paid_at'
    ];

    protected $casts = [
        'customer_info' => 'array',
        'sslcommerz_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, PaymentItem::class, 'payment_id', 'id', 'id', 'booking_id');
    }
}
