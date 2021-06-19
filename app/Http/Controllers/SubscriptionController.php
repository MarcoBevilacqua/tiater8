<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\SubscriptionService;
use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = ['complete' => [
            'first_name' => 'required',
            'last_name' => 'required',
            'customer_email' => 'required|email',
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
        try {
            $subscriptionToFill = Subscription::where('token', '=', $token)
            ->where('status', '=', 0)
            ->firstOrFail();
        } catch (Exception $modelNotFoundException) {
            Log::error("Cannot Find Subscription to fill: {$modelNotFoundException->getCode()}");
            abort(403);
        }

        $subscriptionToFill->update([
            'expires_at' => Carbon::now()->addMinutes(10),
            'status' => Subscription::TO_BE_COMPLETED
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
        if (!$request->has('sub_token') || !$request->input('sub_token')) {
            Log::error("Cannot retrieve Token from request, aborting");
            abort(400);
        }
        $canHandleSubscription = SubscriptionService::subscriptionCanBeConfirmed($request->input('sub_token'));

        if (!$canHandleSubscription) {
            Log::error("Cannot find subscription with token " . $request->input('sub_token'));
            abort(400);
        }
        
        //validate the request
        if (!$request->validate($this->rules['complete'])) {
            Log::info("Cannot validate Request");
            abort(400);
        }

        //Create the customer
        $customer = Customer::create([
             'first_name' => $request->input('first_name'),
             'last_name' => $request->input('last_name'),
             'email' => $request->input('customer_email'),
         ]);

         if(!$customer){
             Log::error("Cannot create customer");
         }

        //complete the subscription
        $subToBeCompleted = Subscription::where('token', $request->input('sub_token'))
         ->first()->update([
             'customer' => $customer->id,
             'status' => Subscription::TO_BE_CONFIRMED,
         ]);

        return Inertia::render('Subscriptions', ['subs' => Subscription::all()->map(function (Subscription $sub) {
            return [
                 'email' => $sub->customer_email,
                 'status' => $sub->status
             ];
        })
         ]);
    }
}
