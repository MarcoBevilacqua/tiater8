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
        $pdf = PDF::loadView('subscriptions.module', [
            'subscriptionId' => $subscription->id,
            'customer' => $subscription->customer,
            'logo_url' => url('img/common/logo.jpg'),
            'now_date' => Carbon::now()->format('d/m/y'),
            'year' => $subscription->year_from . "/" . $subscription->year_to,
            'contact_type' => SubscriptionService::getFancyContactLabel($subscription->contact_type),
            'activity' => SubscriptionService::getFancyActivityLabel($subscription->activity)
            ])
            ->setOptions(['isHtml5ParserEnabled' => true, 'defaultFont' => 'Nunito']);
        return $pdf->stream();
    }
}