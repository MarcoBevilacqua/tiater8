<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\SubscriptionStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SubscriptionStatusController extends Controller
{
    /**
     * update status (uses PATCH)
     * @param Subscription $subscription
     * @param int $status
     * @return RedirectResponse
     */
    public function update(Subscription $subscription, int $status): RedirectResponse
    {
        // check if status is valid
        if (!SubscriptionStatusService::isValidForUpdate($subscription, $status)) {
            Log::info("Cannot change status to {$status}");
            return Redirect::to('subscriptions')
                ->with('error', 'Impossibile modificare lo status della sottoscrizione');
        }

        $subscription->update(['status' => $status]);
        return Redirect::to('subscriptions')->with('success', 'Sottoscrizione aggiornata correttamente');
    }
}
