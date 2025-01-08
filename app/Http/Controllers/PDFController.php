<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PDFController extends Controller
{
    public function subscriptionModule(int $subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscriptionContactType = ($subscription->contact_type == Subscription::NO_CONTACT) ?
        "" : SubscriptionService::getFancyContactLabel($subscription->contact_type);
        $pdf = PDF::loadView('subscriptions.module', [
                'subscriptionId' => $subscription->id,
                'customer' => $subscription->customer,
                'logo_url' => url('img/common/logo.jpg'),
                'now_date' => Carbon::now()->format('d/m/y'),
                'year' => $subscription->year_from . "/" . $subscription->year_to,
                'contact_type' => $subscriptionContactType,
                'activity' => SubscriptionService::getFancyActivityLabel($subscription->activity)
            ])
            ->setOptions(['isHtml5ParserEnabled' => true, 'defaultFont' => 'nunito']);
        return $pdf->stream();
    }
}
