<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'show_event_id',
        'booking_code',
        'number_of_places',
        'place_number',
        'row_letter'
    ];

    public function getFullPlaceAttribute(): string
    {
        return "{$this->row_letter}{$this->place_number}";
    }

    /**
     * @return BelongsTo
     */
    public function showEvent(): BelongsTo
    {
        return $this->belongsTo(ShowEvent::class);
    }

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
