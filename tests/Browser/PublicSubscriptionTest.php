<?php

namespace Tests\Browser;

use App\Models\Subscription;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PublicSubscriptionTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {

        $sub = Subscription::factory()->toBeConfirmed()->create();

        $this->assertDatabaseHas('subscriptions', ['subscription_email' => $sub->subscription_email]);

        $this->browse(function (Browser $browser) use ($sub) {
            $browser->visit('/over/subscriptions/start')
                ->assertInputPresent('customer_email')
                ->type('customer_email', $sub->subscription_email)
                ->press('Conferma')
                ->waitForText('Indirizzo email non disponibile', 8)
                ->screenshot('sub');

        });
    }
}
