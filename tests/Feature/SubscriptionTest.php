<?php

namespace Tests\Feature;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    /**
     * @test
     *
     * the subscription init test
     * @return void
     */
    public function initSubscriptionTest()
    {
        $response = $this->post('/subscriptions/init', ['customer_email' => 'abc123']);

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
        $this->post('/subscriptions/init', ['customer_email' => 'abc123']);
        $sub = Subscription::where('subscription_email', 'abc123')->first();
        $this->assertDatabaseHas('subscriptions', ['token' => $sub->token, 'status' => $sub->status]);
        $url = URL::to('/subscriptions') . '/' . $sub->token;
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
        $this->post('/subscriptions/init', ['customer_email' => 'abc123@gmail.com']);
        $this->assertDatabaseCount('subscriptions', 1);
        $this->assertDatabaseHas('subscriptions', ['expires_at' => null]);
        //assert response
        $getFormResponse = $this->get(URL::to('/subscriptions') . '/' . Subscription::all()->first()->token);
        $getFormResponse->assertStatus(200);
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

        $response = $this->post('subscriptions/complete', $subscriptionData);

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
