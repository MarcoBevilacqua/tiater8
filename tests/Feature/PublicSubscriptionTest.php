<?php

namespace Tests\Feature;

use App\Mail\SubscriptionFilled;
use App\Mail\SubscriptionToComplete;
use App\Models\Subscription;
use App\Models\User;
use App\Services\MailService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PublicSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

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
        $url = URL::signedRoute('subscriptions.fill', ['token' => $sub->token]);
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
            URL::signedRoute('subscriptions.fill', ['token' => Subscription::first()->token])
        )->assertStatus(200);

        //assert subscription has changed
        $this->assertEquals(
            Carbon::now()->addMinutes(10)->format('Y-m-d H:i'),
            Carbon::createFromDate(Subscription::first()->expires_at)->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     * @return void
     */
    public function cannotUseSameEmailForSubscription()
    {
        $subToComplete = Subscription::factory()
            ->toBeCompleted()->create();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::TO_BE_COMPLETED]);

        //user fills the form and hit "submit"
        $response = $this->post(
            '/over/subscriptions/init',
            ['customer_email' => $subToComplete->subscription_email]
        );

        $response->assertStatus(Response::HTTP_FOUND);

        //sub should not be permitted
        $this->assertDatabaseCount('subscriptions', 1);
    }

    /**
     * @test
     * @return void
     */
    public function shouldRedirectOnConfirmFormOnRenew()
    {
        $subToComplete = Subscription::factory()->expired()->create();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::EXPIRED]);

        //user fills the form and hit "submit"
        $response = $this->post(
            '/over/subscriptions/init',
            ['customer_email' => $subToComplete->subscription_email]
        );

        $response->assertRedirect(URL::signedRoute('subscriptions.renew', ['customer_email' => $subToComplete->subscription_email]));
    }


    /**
     * @test
     * @return void
     */
    public function canRenewSubscriptionIfOldIsExpired()
    {
        $expiredSub = Subscription::factory()->expired()->create();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::EXPIRED]);

        //user fills the form and hit "submit"
        $this->post(
            '/over/subscriptions/init',
            ['customer_email' => $expiredSub->subscription_email]
        );

        //user confirms subscription email
        $this->post('/over/subscriptions/renew', ['customer_email' => $expiredSub->subscription_email]);

        //sub should be permitted
        $this->assertDatabaseCount('subscriptions', 2);
    }

    /**
     * @test
     * @return void
     */
    public function shouldRenewOverSeveralOldSubscriptions()
    {
        $oldSubscription = Subscription::factory()->expired()->create();
        $olderSubscription = Subscription::factory()->expired()->make();

        $olderSubscription->decrement('year_from');
        $olderSubscription->decrement('year_to');

        $olderSubscription->save();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::EXPIRED]);
        $this->assertDatabaseCount('subscriptions', 2);

        //user fills the form and hit "submit"
        $this->post(
            '/over/subscriptions/init',
            ['customer_email' => $oldSubscription->subscription_email]
        );

        //user renews subscription
        $this->post('/over/subscriptions/renew', ['customer_email' => $oldSubscription->subscription_email]);

        //sub should be permitted
        $this->assertDatabaseCount('subscriptions', 3);
    }

    /**
     * @test
     *
     * @return void
     */
    public function subscriptionUpdateShouldHaveFirstName(): void
    {
        $subToComplete = Subscription::factory()->toBeCompleted()->create();
        $wrongData = $this->subscriptionData;
        unset($wrongData['first_name']);

        //user fills the form and hit "submit"
        $this->post('/over/subscriptions/complete', $wrongData +
            ['sub_token' => $subToComplete->token])->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseEmpty('customers');
    }

    /**
     * @test
     *
     * @return void
     */
    public function subscriptionUpdateShouldHaveToken(): void
    {
        //user fills the form and hit "submit"
        $this->post('/over/subscriptions/complete', $this->subscriptionData)->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseEmpty('customers');
    }

    /**
     * @test
     * @return void
     */
    public function subscriptionSubmitShouldUpdateStatus()
    {
        $subToComplete = Subscription::factory()->toBeCompleted()->create();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::TO_BE_COMPLETED]);

        //user fills the form and hit "submit"
        $this->post('/over/subscriptions/complete', $this->subscriptionData +
            ['email' => $subToComplete->subscription_email,
                'sub_token' => $subToComplete->token]);

        $this->assertDatabaseHas('customers', [
            'email' => $subToComplete->subscription_email,
            'first_name' => 'Marco',
            'last_name' => 'Bevilacqua',
            'password' => null,
            'province' => $this->subscriptionData['province']
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
    public function subscriptionMadeAfterJuneShouldHaveProperYears()
    {
        //set test time to after june
        Carbon::setTestNow(Carbon::createFromDate(date('Y'), 7, 22));

        $subToComplete = Subscription::factory()->toBeCompleted()->create();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::TO_BE_COMPLETED]);

        //set token and email
        $this->subscriptionData['token'] = $subToComplete->token;
        $this->subscriptionData['email'] = $subToComplete->subscription_email;

        //complete subscription
        $this->post('/over/subscriptions/complete', $this->subscriptionData + [
                'sub_token' => $subToComplete->token,
                'email' => $subToComplete->email
            ]);

        $this->assertDatabaseHas('subscriptions', [
            'subscription_email' => $subToComplete->subscription_email,
            'year_from' => Carbon::now()->year,
            'year_to' => Carbon::now()->year + 1
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function subscriptionMadeInJuneShouldHaveProperYears()
    {
        Carbon::setTestNow(Carbon::createFromDate(Carbon::now()->year, 5, 22));

        $subToComplete = Subscription::factory()->toBeConfirmed()->create();

        //subscription has to be confirmed, user should fill the form
        $this->assertDatabaseHas('subscriptions', ['status' => Subscription::TO_BE_CONFIRMED]);

        //create subscription
        $this->post('/over/subscriptions/complete', $this->subscriptionData + [
                'sub_token' => $subToComplete->token,
                'email' => $subToComplete->email
            ]);

        $this->assertDatabaseHas('subscriptions', [
            'subscription_email' => $subToComplete->subscription_email,
            'year_from' => Carbon::now()->year - 1,
            'year_to' => Carbon::now()->year
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
        $this->admin = User::first();
    }
}
