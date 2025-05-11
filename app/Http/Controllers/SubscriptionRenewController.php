<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionRenewController extends Controller
{

    //TODO: CHECK EMAIL MATCH
    public function index(): Response
    {
        Log::info("Renew Form being displayed");
        return Inertia::render('Public/Renew');
    }

    public function store(Request $request): RedirectResponse
    {
        $sub = Subscription::where([
            ['subscription_email', '=', $request->get('customer_email')],
            ['status', '=', Subscription::EXPIRED]
        ])->firstOrFail();

        //retrieve year_from and year_to
        $years = SubscriptionService::getSubscriptionYears();

        $renewed = new Subscription([
            'year_from' => $years['from'],
            'year_to' => $years['to'],
            'subscription_email' => $request->get('customer_email'),
            'status' => Subscription::TO_BE_CONFIRMED,
            'customer_id' => $sub->customer_id,
            'contact_type' => $sub->contact_type,
            'activity' => $sub->activity,
        ]);

        $renewed->save();

        return Redirect::back()->with('success', 'Tessera rinnovata correttamente');
    }
}
