<?php

namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionService
{
    private static $statusLabels = [
        Subscription::PENDING => 'Invito inviato (in attesa di risposta)',
        Subscription::TO_BE_COMPLETED => 'Modulo online da completare',
        Subscription::TO_BE_CONFIRMED => 'Pagamento da confermare',
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
        return self::$contactLabels[$contact];
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

        return collect([$subscriptionByToken->expires_at > Carbon::now(), $subscriptionByToken->subscription_email]);
        //&& $subscriptionByToken->status === Subscription::TO_BE_COMPLETED;
    }

    /**
     * get year_from and year_to for subscription
     *
     * @return Collection
     */
    public static function getSubscriptionYears()
    {
        $expirationMonth = config('app.subscriptions.expiration_month');
        $renovationMonth = config('app.subscriptions.renovation_month');

        $year = (Carbon::now()->month > $expirationMonth &&
        Carbon::now()->month <= $renovationMonth) ?
        Carbon::now()->year + 1 :
        Carbon::now()->year;
         
        return collect(['from' => $year, 'to' => $year + 1]);
    }
}
