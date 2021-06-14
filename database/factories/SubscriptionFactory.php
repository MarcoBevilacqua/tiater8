<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Subscription;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customer = Customer::factory()->create();
        return [
            'status' => 'PENDING',
            'token' => Hash::make($customer->email . '|' . time())                  
        ];
    }

    /**
     * An expired subscription
     *
     * @return array
     */
    public function expired()
    {
        $customer = Customer::all()->random(1);
        return [
            'customer_id' => $customer->id,
            'token' => Hash::make($customer->email . '|' . time()),
            'expires_at' => Carbon::now()->subDay(),
            'status' => Subscription::getStatusID('BLOCKED'),
        ];
    }
}
