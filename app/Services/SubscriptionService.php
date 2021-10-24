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

    private static $activityLabels = [

        Subscription::ACTIVITY_CHILD => 'Attività bambini',
        Subscription::ACTIVITY_ADULT => 'Attività adulti',
        Subscription::ACTIVITY_BOTH => 'Tutte le attività'
    ];

    private static $contactLabels = [
        Subscription::PHONE_CONTACT => 'via telefono',
        Subscription::WHATSAPP_CONTACT => 'via whatsapp',
    ];

    public static function getAllSubFancyStatusLabel()
    {
        return self::$statusLabels;
    }
    
    public static function getAllFancyActivityLabels()
    {
        return self::$activityLabels;
    }

    public static function getAllFancyContactLabels()
    {
        return self::$contactLabels;
    }

    public static function getSubFancyStatusLabel(int $status)
    {
        return self::$statusLabels[$status];
    }

    public static function getFancyActivityLabel(int $activity)
    {
        return self::$activityLabels[$activity];
    }

    public static function getFancyContactLabel(int $contact)
    {
        return self::$contactLabels[$status];
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
