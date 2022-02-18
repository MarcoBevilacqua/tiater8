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

    /**
     * @test
     *
     * the subscription init test
     * @return void
     */
    public function initSubscriptionTest()
    {
        $this->actingAs($this->admin);
        $response = $this->post('/subscriptions/init', ['customer_email' => 'abc123@mail.com']);
        /** database assertions */
        $this->assertDatabaseCount('subscriptions', 1);
        $this->assertDatabaseHas('subscriptions', [
            'customer_id' => null,
            'status' => 0,
            'subscription_email' => 'abc123@mail.com'

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
        $url = URL::signedRoute('subscriptions.fill', ['token' =>  $sub->token]);
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
        $this->get(
            URL::signedRoute('subscriptions.fill', ['token' =>  Subscription::first()->token])
        )->assertStatus(200);
        //assert subscription has changed
        $this->assertDatabaseHas('subscriptions', [
            'expires_at' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s')
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
            'email' => $subscriptionToBeCompleted->subscription_email,
            'sub_token' => $subscriptionToBeCompleted->token,
            'city' => 'my City',
            'province' => 'FG',
            'resident' => 'aaaa',
            'birth' => '1982-07-20',
            'phone' => 3333333,
            'address' => 'Fake address',
            'postal_code' => 989797,
            'fiscal_code' => 'ABCUIO678TYHGC67'
        ];

        $this->post('/over/subscriptions/complete', $subscriptionData);

        $this->assertDatabaseHas('customers', [
            'email' => $subscriptionToBeCompleted->subscription_email,
            'first_name' => 'Marco',
            'last_name' => 'Bevilacqua',
            'password' => null,
            
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'status' => Subscription::TO_BE_CONFIRMED
        ]);
    }

    /**
     * @test
     *
     *
     * @return void
     */
    public function subscriptionFromPublicRouteShouldHaveProperYears()
    {
        $subscriptionToBeCompleted = Subscription::factory()->toBeCompleted()->create();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => 1]);
        //user fills the form and hit "submit"
        $subscriptionData = [
            'first_name' => 'Marco',
            'last_name' => 'Bevilacqua',
            'email' => $subscriptionToBeCompleted->subscription_email,
            'sub_token' => $subscriptionToBeCompleted->token,
            'city' => 'my City',
            'province' => 'FG',
            'resident' => 'aaaa',
            'birth' => '1982-07-20',
            'phone' => 3333333,
            'address' => 'Fake address',
            'postal_code' => 989797,
            'fiscal_code' => 'HKUIDIUHAISUFYIH'
        ];

        //create subscription
        $this->post('/over/subscriptions/complete', $subscriptionData);

        $this->assertDatabaseHas('subscriptions', [
            'subscription_email' => $subscriptionToBeCompleted->subscription_email,
            'year_from' => Carbon::now()->year,
            'year_to' => Carbon::now()->year + 1
        ]);
    }
}
