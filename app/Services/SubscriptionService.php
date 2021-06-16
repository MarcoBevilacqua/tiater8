<?php

namespace App\Services;

use App\Models\Subscription;

class SubscriptionService {

    public static function getSubscriptionByEmail(string $email) {

        return Subscription::where('subscription_email', '=', $email)
        ->where('status', '=', 0)
        ->count() > 0;
    }

}