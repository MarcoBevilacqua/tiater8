<?php

namespace Tests\Feature\Mail;

use App\Mail\SubscriptionFilled;
use App\Mail\SubscriptionToComplete;
use App\Models\Subscription;
use App\Services\MailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PublicSubscription extends TestCase
{

    use RefreshDatabase;

    private $subscriptionData = [
        'first_name' => 'Marco',
        'last_name' => 'Bevilacqua',
        'city' => 'my City',
        'province' => 'FG',
        'resident' => 'aaaa',
        'birth' => '1982-07-20',
        'phone' => 3333333,
        'address' => 'Fake address',
        'postal_code' => 989797,
        'fiscal_code' => 'HKUIDIUHAISUFYIH'
    ];

    /**
     * @test
     * @return void
     */
    public function shouldSendMailAfterSubscriptionInit()
    {
        Mail::fake();

        $this->actingAs($this->admin);
        $this->post('/subscriptions/init', ['customer_email' => 'abc123@mail.com']);

        Mail::assertSent(SubscriptionToComplete::class);
    }

    /**
     * @test
     * @return void
     */
    public function shouldSendMailAfterSubscriptionComplete()
    {
        Mail::fake();

        /** @var Subscription $subToComplete */
        $subToComplete = Subscription::factory()
            ->toBeCompleted()->create();

        //user fills the form and hit "submit"
        $this->post('/over/subscriptions/complete', $this->subscriptionData +
            ['email' => $subToComplete->subscription_email,
                'sub_token' => $subToComplete->token]);

        Mail::assertSent(SubscriptionFilled::class);
    }

    /**
     * should throw exception if email is not sent
     * @test
     * @return void
     */
    public function shouldThrowExceptionIfMailIsNotSent(): void
    {
        Mail::fake();
        $this->expectException(\Exception::class);

        /** @var Subscription $subToComplete */
        $subToComplete = Subscription::factory()
            ->toBeCompleted()->create();

        MailService::sendToCompleteSubscription("aaa123", $subToComplete->token);

        Mail::assertSent(SubscriptionFilled::class);
    }
}
