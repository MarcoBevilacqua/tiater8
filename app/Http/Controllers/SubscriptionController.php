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
use Illuminate\Support\Facades\Redirect;

class SubscriptionController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = ['complete' => [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
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
                    'email' => $subscription->subscription_email,
                    'created' => $subscription->created_at->format('d/m/Y'),
                    'status' => $subscription->status,
                    'edit' => URL::route('subscriptions.edit', $subscription)
                ];
            }),
            'generateLink' => URL::route('subscriptions.generate')
        ]
        );
    }

    public function edit(int $id)
    {
        $subscription = Subscription::find($id)->firstOrFail();
        return Inertia::render('Subscriptions/Form', $subscription);
    }

    public function generate()
    {
        return Inertia::render('Subscription/GenerateSubscriptionLink', []);
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
            Log::error("Subscription with email {$request->customer_email} has already been stored");
            abort(403);
        }

        //the url to be returned
        $randomString = substr(str_shuffle(MD5(microtime())), 0, 22);        

        //create a to-be-confirmed subscription
        $pendingSub = Subscription::create([
            'subscription_email' => $request->customer_email,
            'status' => Subscription::PENDING,
            'token' => $randomString,
            'customer_id' => null
        ]);

        if (!$pendingSub) {
            //TODO: refactor the error management
            Log::error("Cannot create pending subscription with email {$request->customer_email} and token {$randomString}");
            abort(500);
        }

        Log::info("Pending Subscription for email {$request->customer_email} has been created!", [__CLASS__, __FUNCTION__]);
        return Redirect::route('subscriptions.index');
    }

    public function fill(string $token)
    { 

        try {
            $subscriptionToFill = Subscription::where('token', '=', $token)
            ->where('status', Subscription::getStatusID('PENDING'))
            ->firstOrFail();
        } catch (Exception $modelNotFoundException) {
            Log::error("Cannot Find pending Subscription to fill");
            abort(403);
        }

        $subscriptionToFill->update([
            'expires_at' => Carbon::now()->addMinutes(10),            
        ]);

        Log::info("Can Complete Subscription!!!", [__CLASS__, __FUNCTION__]);

        //should return form
        return Inertia::render('Public/CompleteSubscription', ['sub_token' => $token]);
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
             'email' => $request->input('email'),
         ]);

         if(!$customer){
             Log::error("Cannot create customer");
         }

         Log::info("Customer with ID {$customer->id} successfully created", [__CLASS__, __FUNCTION__]);

        //complete the subscription
        $subToBeCompleted = Subscription::where('token', $request->input('sub_token'))
         ->first()->update([
             'customer' => $customer->id,
             'status' => Subscription::TO_BE_CONFIRMED,
         ]);

        return redirect('/subscriptions');

    }
}
