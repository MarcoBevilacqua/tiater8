<?php

namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionService
{
    private static $statusLabels = [
        Subscription::PENDING => 'In attesa di risposta',
        Subscription::TO_BE_COMPLETED => 'Da completare',
        Subscription::TO_BE_CONFIRMED => 'Da confermare',
        Subscription::ACTIVE => 'Attiva',
        Subscription::INACTIVE => 'Inattiva',
        Subscription::EXPIRED => 'Scaduta'
    ];

    public static function getAllSubFancyStatusLabel()
    {
        return self::$statusLabels;
    }

    public static function getSubFancyStatusLabel(string $status)
    {
        return self::$statusLabels[$status];
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
