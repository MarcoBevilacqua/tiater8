<?php

namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;

class PublicSubscriptionService
{

    /**
     * create a to-be-confirmed subscription
     *
     * @param string $customerEmail
     * @param string $token
     * @return void
     */
    public static function createToBeConfirmed(string $customerEmail, string $token): void
    {
        // retrieve year_from and year_to
        $years = SubscriptionService::getSubscriptionYears();

        // create sub
        Subscription::create([
            'subscription_email' => $customerEmail,
            'status' => Subscription::PENDING,
            'token' => $token,
            'customer_id' => null,
            'year_from' => $years['from'],
            'year_to' => $years['to'],
        ]);
    }

    /**
     * update pendig subscription expire time
     * @param string $token
     * @return void
     */
    public static function updatePendingSubscription(string $token): void
    {
        Subscription::where('token', '=', $token)
                ->where('status', Subscription::PENDING)
                ->update(['expires_at' => Carbon::now()->addMinutes(10)]);
    }
}
