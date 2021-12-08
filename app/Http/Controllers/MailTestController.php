<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionFilled;

class MailTestController extends Controller
{
    public function send()
    {
        Mail::to('dontstop.marco@gmail.com')
        ->send(new SubscriptionFilled());
    }
}
