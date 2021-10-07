<?php

namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionService
{
    private static $statusLabels = [
        'PENDING' => 'In attesa di risposta',
        'TO_BE_COMPLETED' => 'Da completare',
        'TO_BE_CONFIRMED' => 'Da confermare',
        'ACTIVE' => 'Attiva',
        'INACTIVE' => 'Inattiva',
        'EXPIRED' => 'Scaduta'
    ];

    public static function getSubFancyStatusLabel(string $status)
    {
        return self::$statusLabels['ACTIVE'];
    }

    public static function getSubscriptionByEmail(string $email)
    {
        return Subscription::where('subscription_email', '=', $email)
        ->where('status', Subscription::PENDING)
        ->count() > 0;
    }

    public static function subscriptionCanBeConfirmed(string $token)
    {
        $subscriptionByToken = Subscription::where('token', $token)
        ->first();

        if (!$subscriptionByToken) {
            return false;
        }

        return $subscriptionByToken->expires_at > Carbon::now();
        //&& $subscriptionByToken->status === Subscription::TO_BE_COMPLETED;
    }
}
