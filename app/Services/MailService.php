<?php

namespace App\Services;

use App\Mail\SubscriptionToComplete;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class MailService
{
    /**
     *
     * @param string $customerEmail
     * @param string $token
     * @throws \Exception
     * @return void
     */
    public static function sendToCompleteSubscription(string $customerEmail, string $token): void
    {
        /** @var SentMessage $mailFailure */
        $sentMessage = Mail::to($customerEmail)
            ->send(new SubscriptionToComplete(
                URL::signedRoute('subscriptions.fill', ['token' => $token])
            ));

        if (!$sentMessage) {
            Log::error("Cannot send email to {$customerEmail}");
            throw new \Exception("Cannot send email to {$customerEmail}");
        }
    }
}
