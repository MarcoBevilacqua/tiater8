<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'show_event_id',
        'booking_code'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function showEvent()
    {
        return $this->belongsTo(ShowEvent::class);
    }

    /**
     * @return HasOne
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
