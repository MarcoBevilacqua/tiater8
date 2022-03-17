<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use PDF;

class PDFController extends Controller
{
    public function subscriptionModule(int $subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscriptionContactType = ($subscription->contact_type == Subscription::NO_CONTACT) ?
        "" : SubscriptionService::getFancyContactLabel($subscription->contact_type);
        $subscriptionActity = $subscriptionContactType == "" ? "" : SubscriptionService::getFancyActivityLabel($subscription->activity);
        $pdf = PDF::loadView('subscriptions.module', [
            'subscriptionId' => $subscription->id,
            'customer' => $subscription->customer,
            'logo_url' => url('img/common/logo.jpg'),
            'now_date' => Carbon::now()->format('d/m/y'),
            'year' => $subscription->year_from . "/" . $subscription->year_to,
            'contact_type' => $subscriptionContactType,
            'activity' => $subscriptionActity
            ])
            ->setOptions(['isHtml5ParserEnabled' => true, 'defaultFont' => 'Nunito']);
        return $pdf->stream();
    }
}
