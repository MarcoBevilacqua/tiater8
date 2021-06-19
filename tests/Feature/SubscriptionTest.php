<?php

namespace Tests\Feature;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\NullableType;
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
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * get the subscription form
     * @return void
     */
    public function getFormSubscriptionTest()
    {
        $response = $this->post('/subscriptions/init', ['customer_email' => 'abc123']);
        $url = $response->getContent();
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
        $response = $this->post('/subscriptions/init', ['customer_email' => 'abc123@gmail.com']);
        $this->assertDatabaseHas('subscriptions', ['expires_at' => null]);
        //assert response
        $getFormResponse = $this->get($response->getContent());
        $getFormResponse->assertStatus(200);
        //assert subscription has changed
        $this->assertDatabaseHas('subscriptions', [
            'expires_at' => Carbon::now()->addMinutes(10),
            'status' => 1
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
            'customer_email' => 'example@mail.com',
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
