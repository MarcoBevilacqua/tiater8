<?php

namespace Tests\Feature;

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
        $response->assertStatus(200);
    }
}
