<?php

namespace App\Services;

use App\Mail\SubscriptionToComplete;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class MailService
{
    /**
     *
     * @param string $customerEmail
     * @param string $token
     * @return void
     */
    public static function sendToCompleteSubscription(string $customerEmail, string $token): void
    {
        $mailFailure = Mail::to($customerEmail)
            ->send(new SubscriptionToComplete(
                URL::signedRoute('subscriptions.fill', ['token' => $token])
            ));

        if ($mailFailure) {
            Log::error("Cannot send email to {$customerEmail}");
        }
    }
}
