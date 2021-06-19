<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\SubscriptionService;
use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    private $rules;

    public function __construct()
    {
        $rules = ['complete' => [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_address' => 'required|email',
        ]];
    }
    
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
            'status' => Subscription::PENDING,
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
        } catch (Exception $modelNotFoundException) {
            Log::error("Cannot Find Subscription to fill: {$modelNotFoundException->getCode()}");
            abort(404);
        }

        $subscriptionToFill->update([
            'expires_at' => Carbon::now()->addMinutes(10),
            //'status' => Subscription::TO_BE_COMPLETED
        ]);

        //should return form
        return Inertia::render('Subscription/CompleteSubscription', ['sub_token' => $token]);
    }

    public function complete(Request $request)
    {
        /**
         * 1. check if subscription is valid
         * 2. create the customer
         * 3. complete the subscription (should be another status such as TO_BE_CONFIRMED)
         * 4. return the response
         */

         //TODO: check if subscription is valid

         //Create the customer
         if(!$request->validate($this->rules['complete'])){
             abort(400);
         }

         $customer = Customer::create([
             'first_name' => $request->first_name,
             'last_name' => $request->last_name,
             'email' => $request->email_address,
         ]);

         //complete the subscription


    }
}
