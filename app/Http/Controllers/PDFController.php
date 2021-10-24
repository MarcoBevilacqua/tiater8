<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
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
            'year' => "2021/2022"])
            ->setOptions(['isHtml5ParserEnabled' => true, 'defaultFont' => 'Nunito']);
        return $pdf->stream();
    }
}
