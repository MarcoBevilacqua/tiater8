<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

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
     * the subscription init test
     * @return void
     */
    public function initSubscriptionTest()
    {
        $this->actingAs($this->admin);
        $response = $this->post('/subscriptions/init', ['customer_email' => 'abc123']);
        /** database assertions */
        $this->assertDatabaseCount('subscriptions', 1);
        $this->assertDatabaseHas('subscriptions', [
            'customer_id' => null,
            'status' => 0,
            'subscription_email' => 'abc123'

        ]);
        $response->assertStatus(302);
    }

    /**
     * @test
     *
     * get the subscription form
     * @return void
     */
    public function getFormSubscriptionTest()
    {
        $this->actingAs($this->admin);
        $this->post('/subscriptions/init', ['customer_email' => 'prova@prova.com']);
        $this->assertDatabaseCount('subscriptions', 1);
        $sub = Subscription::where('subscription_email', 'prova@prova.com')->first();
        $this->assertDatabaseHas('subscriptions', ['token' => $sub->token, 'status' => 0]);
        $url = URL::to('/public/subscriptions') . '/' . $sub->token;
        $getFormResponse = $this->get($url);
        $getFormResponse->assertStatus(200);
    }

    /**
     * @test
     *
     *
     * @return void
     */
    public function shouldUpdateSubscriptionWhenPageIsReached()
    {
        $this->actingAs($this->admin);
        $this->post('/subscriptions/init', ['customer_email' => 'abc123@gmail.com']);
        $this->assertDatabaseCount('subscriptions', 1);
        $this->assertDatabaseHas('subscriptions', ['expires_at' => null]);
        //assert response
        $this->get(URL::to('/public/subscriptions') . '/' . 
        Subscription::first()->token)->assertStatus(200);
        //assert subscription has changed
        $this->assertDatabaseHas('subscriptions', [
            'expires_at' => Carbon::now()->addMinutes(10)
            ]);
    }

    /**
     * @test
     *
     *
     * @return void
     */
    public function subscriptionSubmitShouldUpdateStatus()
    {
        $subscriptionToBeCompleted = Subscription::factory()->toBeCompleted()->create();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => 1]);
        //user fills the form and hit "submit"
        $subscriptionData = [
            'first_name' => 'Marco',
            'last_name' => 'Bevilacqua',
            'email' => 'example@mail.com',
            'sub_token' => $subscriptionToBeCompleted->token
        ];

        $response = $this->post('/public/subscriptions/complete', $subscriptionData);

        $this->assertDatabaseHas('customers', [
            'email' => 'example@mail.com',
            'first_name' => 'Marco',
            'last_name' => 'Bevilacqua',
            'password' => NULL
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'status' => Subscription::getStatusId(Subscription::TO_BE_CONFIRMED)
        ]);
    }
}
