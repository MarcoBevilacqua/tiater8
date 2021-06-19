<?php

namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionService {

    public static function getSubscriptionByEmail(string $email) {

        return Subscription::where('subscription_email', '=', $email)
        ->where('status', '=', 0)
        ->count() > 0;
    }

    public static function subscriptionCanBeConfirmed(string $token) {
        $subscriptionByToken = Subscription::where('token', $token)
        ->first();

        if(!$subscriptionByToken) {
            return false;
        }

        return $subscriptionByToken->expires_at > Carbon::now() &&
            $subscriptionByToken->status === Subscription::TO_BE_COMPLETED;
    }

}