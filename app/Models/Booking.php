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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function showEvent()
    {
        return $this->hasOne(ShowEvent::class);
    }

    /**
     * @return HasOne
     */
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
