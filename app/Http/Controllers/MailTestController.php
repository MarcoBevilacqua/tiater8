<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionFilled;
use App\Mail\SubscriptionToComplete;
use Illuminate\Support\Facades\URL;

class MailTestController extends Controller
{
    public function send()
    {
        $randomString = substr(str_shuffle(MD5(microtime())), 0, 22);

        Mail::to('juliamanocchio@gmail.com')
            ->send(
                new SubscriptionToComplete(
                URL::signedRoute('subscriptions.fill', [
                'token' => $randomString])
            )
            );

        return "OK";
    }
}
