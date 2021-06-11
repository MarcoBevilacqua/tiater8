<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    /**
     * the subscription statuses
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
        $statusId = $this->getStatusAttribute($value);
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
