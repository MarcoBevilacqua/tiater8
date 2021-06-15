<?php

namespace Tests\Feature;

use App\Models\Subscription;
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
            'status' => 0
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     *
     * the subscription resolve test
     * @return void
     */
    public function getFormSubscriptionTest()
    {
        $response = $this->post('/subscriptions/init', ['customer_email' => 'abc123']);

        $url = $response->getContent();

        $getFormResponse = $this->get($url);

        $getFormResponse->assertStatus(200);
    }
}
