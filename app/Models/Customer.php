<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'customer_id');
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'city',
        'phone',
        'birth',
        'province',
        'resident',
        'address',
        'postal_code',
        'fiscal_code',
    ];

    protected $hidden = [
        'password'
    ];

    //subscription relationship
    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) =>
                $attributes['first_name'] . " " . $attributes['last_name']
            );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth' => 'datetime:Y-m-d',
        ];
    }
}
