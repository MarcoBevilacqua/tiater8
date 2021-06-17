<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionService;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{

    /**
     * the subscription index
     * @return Inertia view
     */
    public function index()
    {
        return Inertia::render(
            'Subscriptions',
            ['subscriptions' => Subscription::all()->map(function (Subscription $subscription) {
                return [
                    'token' => $subscription->token,
                    'customer' => $subscription->customer_id,
                    'status' => $subscription->status
                ];
            })
        ]
        );
    }

    public function generate(Request $request)
    {
        return Inertia::render('Subscription/GenerateLink', []);
    }

    /**
     * the subscription init (return the form url)
     *
     * @param Request $request
     * @return string
     */
    public function init(Request $request)
    {
        if (!$request->has('customer_email') || !$request->customer_email) {
            //TODO: refactor the error management
            abort(400);
        }

        //check if email has already been taken
        $shouldBeBlocked = SubscriptionService::getSubscriptionByEmail($request->customer_email);
        if ($shouldBeBlocked) {
            abort(403);
        }

        //the url to be returned
        $randomString = substr(str_shuffle(MD5(microtime())), 0, 22);
        $formUrl = URL::to('/subscriptions') . "/" . $randomString;

        //create a to-be-confirmed subscription
        $pendingSub = Subscription::create([
            'subscription_email' => $request->customer_email,
            'status' => 0,
            'token' => $randomString,
            'customer_id' => null
        ]);

        if (!$pendingSub) {
            //TODO: refactor the error management
            abort(500);
        }

        return $formUrl;
    }

    public function fill(string $token)
    {
        Log::info("TOKEN {$token} is in use, setting expiration date to token");
        
        try {
            $subscriptionToFill = Subscription::where('token', '=', $token)
            ->where('status', '=', 0)
            ->firstOrFail();
        } catch (ModelNotFoundException $modelNotFoundException) {
            Log::error("Cannot Find Subscription to fill: {$modelNotFoundException->getCode()}");
            abort(404);
        }

        $subscriptionToFill->update([
            'expires_at' => Carbon::now()->addMinutes(10),
            'status' => 1
        ]);

        //should return form
        return Inertia::render('Subscription/CompleteSubscription', []);
    }

    public function complete(Request $request)
    {
        dd($request);
    }
}
