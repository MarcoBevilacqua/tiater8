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
        'expires_at'
    ];

    const PENDING = 'PENDING';
    const TO_BE_COMPLETED = 'TO_BE_COMPLETED';
    const TO_BE_CONFIRMED = 'TO_BE_CONFIRMED';
    const ACTIVE = 'ACTIVE';
    const INACTIVE = 'INACTIVE';
    const EXPIRED = 'EXPIRED';

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
    public const STATUSES = [
        0 => self::PENDING,
        1 => self::TO_BE_COMPLETED,
        2 => self::TO_BE_CONFIRMED,
        3 => self::ACTIVE,
        4 => self::INACTIVE,
        5 => self::EXPIRED
    ];

    /**
     * returns the id of a status
     *
     * @param string $status the subscription status
     * @return int statusID
     */
    public static function getStatusID($status)
    {
        return array_search($status, self::STATUSES);
    }
   
    /**
    * get subscription status
    */
    public function getStatusAttribute()
    {
        return self::STATUSES[ $this->attributes['status'] ];
    }

    /**
      * set subscription status
      */
    public function setStatusAttribute($value)
    {
        $statusId = $this->getStatusID($value);
        if ($statusId) {
            $this->attributes['status'] = $statusId;
        }
    }

    /**
     * subscription/customer relationshib
     */
    public function customer(){
        return $this->hasOne(Customer::class);
    }
}
