<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private $admin;

    /**
     * @test
     * @return void
     */
    public function shouldRenderSubscriptionIndexPage(): void
    {
        Subscription::factory()->count(3)
            ->state(new Sequence(
                ['subscription_email' => 'example@example.com'],
                ['subscription_email' => 'example1@example.com'],
                ['subscription_email' => 'example2@example.com'],
            ))->create();

        $response = $this->actingAs($this->admin)
            ->get(route('subscriptions.index'));

        $response
            ->assertInertia(fn (AssertableInertia $page) =>
            $page->component('Subscriptions')
                ->has('subscriptions.data', 3)
            );
    }

    /**
     * @test
     *
     * should softly delete subscription
     * @return void
     */
    public function shouldDeleteSubscription()
    {
        $this->actingAs($this->admin);
        $subscription = Subscription::factory()->create();
        $subscription->delete();
        $this->assertDatabaseCount('subscriptions', 1);
        $response = $this->delete('/subscriptions/' . 1);
        $response->assertRedirect();
        $this->assertSoftDeleted('subscriptions', [
            'id' => $subscription->id,
            'subscription_email' => $subscription->subscription_email
        ]);
    }

    /**
     * @test
     *
     * should prune old subscription
     * @return void
     */
    public function shouldPruneOldSubscription()
    {
        Subscription::factory()->toBeCompleted()->create();

        $this->assertDatabaseCount('subscriptions', 1);
        Carbon::setTestNow(now()->addDays(95));
        $this->assertDatabaseHas('subscriptions', ['customer_id' => null]);
        $this
            ->artisan('model:prune', ['--model' => Subscription::class])
            ->assertSuccessful()
            ->expectsOutputToContain("Pruning [App\Models\Subscription] records.");

        $this->assertDatabaseCount('subscriptions', 0);
    }

    /**
     * @test
     *
     * should prune old subscription
     * @return void
     */
    public function shouldPruneIncompleteSubscription()
    {
        Subscription::factory()->pending()->create();

        $this->assertDatabaseCount('subscriptions', 1);
        Carbon::setTestNow(now()->addDays(95));
        $this->assertDatabaseHas('subscriptions', ['customer_id' => null]);
        $this
            ->artisan('model:prune', ['--model' => Subscription::class])
            ->assertSuccessful()
            ->expectsOutputToContain("Pruning [App\Models\Subscription] records.");

        $this->assertDatabaseCount('subscriptions', 0);
    }

    /**
     * @test
     *
     * should NOT prune old subscription
     * @return void
     */
    public function shouldNotPruneOldSubscription()
    {
        Subscription::factory()->toBeCompleted()->create();

        $this->assertDatabaseCount('subscriptions', 1);
        Carbon::setTestNow(now()->addDays(29));
        $this->assertDatabaseHas('subscriptions', ['customer_id' => null]);
        $this
            ->artisan('model:prune', ['--model' => Subscription::class])
            ->assertSuccessful()
            ->doesntExpectOutput("1 [App\Models\Subscription] records have been pruned.");

        $this->assertDatabaseCount('subscriptions', 1);
    }

    /**
     * @test
     *
     * should NOT prune old subscription
     * @return void
     */
    public function shouldNotPruneValidSubscription()
    {
        $customer = Customer::factory()->create();
        Subscription::factory()->toBeConfirmed()->create(['customer_id' => $customer]);

        $this->assertDatabaseCount('subscriptions', 1);
        $this->assertDatabaseHas('subscriptions', ['customer_id' => $customer->id]);
        $this
            ->artisan('model:prune', ['--model' => Subscription::class])
            ->assertSuccessful()
            ->expectsOutputToContain("No prunable [App\Models\Subscription] records found.");

        $this->assertDatabaseCount('subscriptions', 1);
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreateNewSubscriptionOnRenew()
    {
        $oldSubscription = Subscription::factory()->expired()->create(
            [
                'year_from' => now()->subYear()->format('Y'),
                'year_to' => now()->year,
            ]
        );

        $newSubscription = new Subscription([
            'status' => Subscription::PENDING,
            'subscription_email' => $oldSubscription->subscription_email,
            'year_from' => now()->year,
            'year_to' => now()->addYear()->format('Y')
        ]);

        $newSubscription->save();

        //sub should be created
        $this->assertDatabaseCount('subscriptions', 2);
    }

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
        $this->admin = User::first();
    }
}
