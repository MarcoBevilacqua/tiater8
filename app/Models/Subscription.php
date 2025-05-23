<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;
    use Prunable;

    /**
     * the subscription statuses
     *
     * Pending: link to the subscription form has been generated and sent to the customer
     * To Be Completed: a subscription that has to be filled by the customer
     * To Be Confirmed: a subscription that has to be confirmed by the backoffice
     * Active: a completed subscription
     * Inactive: a cancelled subscription
     * Expired: an expired subscription (user has not completed the subscription before the expiration)
     */

    const PENDING = 0;
    const TO_BE_COMPLETED = 1;
    const TO_BE_CONFIRMED = 2;
    const ACTIVE = 3;
    const INACTIVE = 4;
    const EXPIRED = 5;
    /**
     * the activity constants
     */
    const ACTIVITY_CHILD = 0;
    const ACTIVITY_ADULT = 1;
    const ACTIVITY_BOTH = 2;
    /**
     * the contact options
     */
    const NO_CONTACT = 2;
    const PHONE_CONTACT = 0;
    const WHATSAPP_CONTACT = 1;

    protected $fillable = [
        'customer_id',
        'subscription_email',
        'status',
        'token',
        'expires_at',
        'contact_type',
        'activity',
        'year_from',
        'year_to'
    ];

    /**
     * Get the prunable model query.
     *
     * @return Builder
     */
    public function prunable()
    {
        return static::whereDate('created_at', '<', now()->subMonths(3)->format('Y-m-d'))
            ->whereNull(['customer_id']);
    }

    /**
     * subscription/customer relationship
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    //add active scope
    public function scopeActive($query)
    {
        return $query->where('status', '!=', self::EXPIRED);
    }

    public function getCreatedAtAttribute($createdAt)
    {
        return Carbon::parse($createdAt)->format('d/m/Y');
    }
}
