<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'subscription_email',
        'status',
        'token',
        'expires_at',
        'contact_type',
        'activity'
    ];

    /**
     * the subscription statuses
     *
     * Pending: link to the subscription form has been generated and sent to the customer
     * To Be Completed: a subscription that has to be filled by the customer
     * To Be Confiermed: a subscription that has to be confirmed by the backoffice
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
    const PHONE_CONTACT = 0;
    const WHATSAPP_CONTACT = 1;

    /**
     * subscription/customer relationshib
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
