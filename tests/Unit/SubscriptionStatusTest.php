<?php

namespace Tests\Unit;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionStatusTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    /**
     * @test
     * A basic unit test example.
     */
    public function shouldForbidStatusUpdateWithSameStatus(): void
    {
        $this->actingAs($this->admin);
        $toBeConfirmed = Subscription::factory()->toBeConfirmed()->create();

        $this
            ->patch('/subscriptions/' . $toBeConfirmed->id .
            '/status/' . Subscription::TO_BE_CONFIRMED)
            ->assertRedirect();

        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::TO_BE_CONFIRMED]);
    }

    /**
     * @test
     * @return void
     */
    public function shouldForbidStatusChangeWithForbiddenValue(): void
    {
        $this->actingAs($this->admin);
        $active = Subscription::factory()->create(
            ['status' => Subscription::ACTIVE]
        );

        $this
            ->patch('/subscriptions/' . $active->id .
                '/status/' . Subscription::TO_BE_CONFIRMED)
            ->assertRedirect();

        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::ACTIVE]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
        $this->admin = User::first();
    }
}
