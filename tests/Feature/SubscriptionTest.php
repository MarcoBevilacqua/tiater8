<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
        $this->admin = User::first();
    }

    /**
     * @test
     *
     * should soft delete subscription
     * @return void
     */
    public function shoulDeleteSubscription()
    {
        $this->actingAs($this->admin);
        $subscription = Subscription::factory()->create();

        $response = $this->delete('/subscriptions/'. $subscription->id);
        $response->assertRedirect();
        $this->assertDatabaseCount('subscriptions', 1);
        $this->assertSoftDeleted('subscriptions', [
            'id' => $subscription->id,
            'subscription_email' => $subscription->subscription_email
        ]);
    }
}
