<?php

namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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
        Subscription::NO_CONTACT => 'nessun contatto',
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

    public static function getFancyActivityLabel(int $activity = null)
    {
        if (is_null($activity) || !in_array($activity, array_keys(self::$activityLabels))) {
            return "";
        }
        return self::$activityLabels[$activity];
    }

    public static function getFancyContactLabel(int $contact = null)
    {
        if (is_null($contact) || !in_array($contact, array_keys(self::$contactLabels))) {
            return "";
        }
        return self::$contactLabels[$contact];
    }

    public static function getSubscriptionByEmail(string $email)
    {
        return Subscription::where('subscription_email', '=', $email)
                ->where('status', '!=', Subscription::PENDING)
                ->count() > 0;
    }

    /**
     * Check if subscription can be confirmed
     * @param string $token
     *
     * @return Subscription
     */
    public static function subscriptionCanBeConfirmed(string $token): Subscription
    {
        return Subscription::select('subscription_email')
            ->where([['token', '=', $token], [
                'expires_at', '>', Carbon::now()]
            ])->first();
    }

    /**
     * Check if subscription should be renewed
     *
     * @param string $customerEmail
     * @return bool
     */
    public static function subscriptionShouldBeRenewed(string $customerEmail): bool
    {
        //get last subscription in time order
        $sub = Subscription::where('subscription_email', '=', $customerEmail)
            ->orderBy('year_from', 'desc')
            ->first();

        return $sub && $sub->exists() && $sub->getRawOriginal('status') === Subscription::EXPIRED;
    }

    /**
     * get year_from and year_to for subscription
     *
     * @return Collection
     */
    public static function getSubscriptionYears()
    {
        $expirationMonth = config('app.subscriptions.expiration_month');

        $year = (Carbon::now()->month > $expirationMonth) ? Carbon::now()->year : Carbon::now()->year - 1;

        return collect(['from' => $year, 'to' => $year + 1]);
    }
}
