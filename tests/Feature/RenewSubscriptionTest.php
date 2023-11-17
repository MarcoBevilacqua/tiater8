<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RenewSubscriptionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sub_older_than_a_year_should_expire()
    {
        $customer = Customer::factory()->create();
        $oldSubscription = Subscription::factory()->toBeConfirmed()->create(
            ['customer_id' => $customer]
        );

        $this->assertDatabaseCount('subscriptions', 1);

        Carbon::setTestNow(now()->addYear()->addDay());

        $this->artisan('subscriptions:expire-old')
            ->assertSuccessful();

        $this->assertDatabaseHas('subscriptions', [
            'subscription_email' => $oldSubscription->subscription_email,
            'status' => Subscription::EXPIRED
        ]);
    }

    public function test_sub_younger_than_a_year_should_not_expire()
    {
        $customer = Customer::factory()->create();
        $oldSubscription = Subscription::factory()->toBeConfirmed()->create(
            ['customer_id' => $customer]
        );

        $anotherCustomer = Customer::factory()->create();
        $validSubscription = Subscription::factory()->toBeConfirmed()->make(
            [
                'subscription_email' => $anotherCustomer->email,
                'customer_id' => $anotherCustomer,
                'created_at' => now()->addDays(160)
            ]
        );

        //the second sub is younger
        $validSubscription->timestamps = false;
        $validSubscription->created_at = now()->addDays(90);
        $validSubscription->save();

        $this->assertDatabaseCount('subscriptions', 2);

        //let pass a year...
        Carbon::setTestNow(now()->addYear()->addDay());

        $this->artisan('subscriptions:expire-old')
            ->assertSuccessful()
            ->expectsOutput("1 sub(s) older than a year are now expired");

        $this->assertDatabaseHas('subscriptions', [
            'subscription_email' => $oldSubscription->subscription_email,
            'status' => Subscription::EXPIRED
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'subscription_email' => $validSubscription ->subscription_email,
            'status' => Subscription::TO_BE_CONFIRMED
        ]);
    }
}
