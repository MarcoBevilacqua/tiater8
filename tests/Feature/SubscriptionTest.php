<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->assertDatabaseHas('subscriptions', ['expires_at' => NULL]);
        //assert response        
        $getFormResponse = $this->get($response->getContent());
        $getFormResponse->assertStatus(200);
        //assert subscription has changed
        $this->assertDatabaseHas('subscriptions', [
            'expires_at' => Carbon::now()->addMinutes(10),
            'status' => 1
            ]);
    }
}
