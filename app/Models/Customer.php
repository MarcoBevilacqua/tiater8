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
        'name',
        'last_name',
        'email',
        'password'
    ];

}
