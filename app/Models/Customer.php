<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function subscriptions() {
        return $this->hasMany(Subscription::class, 'customer_id');
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'city',
        'resident',
        'address',
        'postal_code',
        'contact_type',
        'activity'
    ];

    protected $hidden = [
        'password'
    ];

}
