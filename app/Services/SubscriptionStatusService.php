<?php

namespace App\Services;

use App\Models\Subscription;

class SubscriptionStatusService
{
    /**
     * @param Subscription $subscription
     * @param int $status
     * @return bool
     */
    public static function isValidForUpdate(Subscription $subscription, int $status): bool
    {
        return
            $subscription->status !== $status &&
            in_array($status, [
                Subscription::ACTIVE,
                Subscription::EXPIRED,
                Subscription::INACTIVE
            ]);
    }
}
