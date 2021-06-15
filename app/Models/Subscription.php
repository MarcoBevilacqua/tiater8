<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'token',
        'status',
        'form_url'
    ];

    /**
     * the subscription statuses
     * 
     * Pending: a subscription that has to be confermed
     * Blocked: an expired subscription (user has not completed the subscription before the expiration)
     * Complete: a completed subscription
     */
    public const STATUSES = [
        0 => 'PENDING',
        1 => 'BLOCKED',
        2 => 'COMPLETE'
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
