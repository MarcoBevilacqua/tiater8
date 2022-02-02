<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionToComplete;
use App\Mail\SubscriptionFilled;
use App\Models\Customer;
use App\Services\SubscriptionService;
use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class SubscriptionController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'complete' => [
                'first_name' => 'required',
                'last_name' => 'required'
            ],
            'store' => [
                'customer_id' => 'exists:App\Models\Customer,id',
                'status' => 'required|numeric',
                'contact_type' => 'required|numeric',
                'activity' => 'required|numeric',
                'year_from' => 'required|numeric',
                'year_to' => 'required|numeric'
            ]
        ];
    }
    
    /**
     * the subscription index
     * @return Inertia view
     */
    public function index()
    {
        return Inertia::render(
            'Subscriptions',
            ['subscriptions' => Subscription::orderByDesc('id')
                ->get()
                ->map(function (Subscription $subscription) {
                    return [
                    'id' => $subscription->id,
                    'customer' => $subscription->subscription_email,
                    'created' => $subscription->created_at->format('d/m/Y'),
                    'status' => SubscriptionService::getSubFancyStatusLabel($subscription->status),
                    'edit' => URL::route('subscriptions.edit', $subscription)
                ];
                }),
            'createLink' => URL::route('subscriptions.create')
            ]
        );
    }

    /**
     * creation form
     */
    public function create()
    {
        return Inertia::render('Subscription/Create', [
            /**
             * TODO: make this query lighter or cache the results
             */
            'customers' => Customer::all()->map(function (Customer $customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->first_name . " " . $customer->last_name
                ];
            }),
            'av_statuses' => SubscriptionService::getAllSubFancyStatusLabel(),
            'activities' => SubscriptionService::getAllFancyActivityLabels(),
            'contacts' => SubscriptionService::getAllFancyContactLabels(),
            '_method'  => 'post',
        ]);
    }

    /**
     * creation from form
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules['store']);
        try {
            Subscription::create($validated + ['subscription_email' => Customer::findOrFail($validated['customer_id'])->email]);
        } catch (\Exception $exception) {
            Log::error("Cannot create subscription: {$exception->getMessage()}");
        }

        return Redirect::route('subscriptions.index');
    }

    /**
     * @param int $id
     * @return Inertia view
     */
    public function edit(int $id)
    {
        $subscription = Subscription::findOrFail($id)->toArray();
        
        return Inertia::render('Subscription/Form', [
            'subscription' => $subscription,
            'customers' => Customer::all()->map(function (Customer $customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->first_name . " " . $customer->last_name
                ];
            }),
            '_method'  => 'put',
            'av_statuses' => SubscriptionService::getAllSubFancyStatusLabel(),
            'activities' => SubscriptionService::getAllFancyActivityLabels(),
            'contacts' => SubscriptionService::getAllFancyContactLabels(),
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|numeric',
            'contact_type' => 'required|numeric',
            'activity' => 'required|numeric',
            'year_from' => 'required|numeric',
            'year_to' => 'required|numeric'
        ]);

        
        Log::info("Trying to set status = {$request->input('status')} on subsription");
        Subscription::updateOrCreate(
            ['id' => $request->id],
            [
            'status' => $request->input('status'),
            'subscription_email' => $request->input('subscription_email'),
        ]
        );

        return Redirect::route('subscriptions.index');
    }

    /**
     * render the view to generate invitation mail
     * @return Inertia view
     */
    public function generate()
    {
        return inertia('Subscription/GenerateSubscriptionLink');
    }

    /**
     * render the view to generate invitation mail
     * @return Inertia view
     */
    public function start()
    {
        return Inertia::render('Public/SelfInvitation');
    }

    /**
     * the subscription init (return the form url)
     *
     * @param Request $request
     * @return string
     */
    public function init(Request $request)
    {
        $request->validate([
            'customer_email' => 'required|email:filter|unique:subscriptions,subscription_email'
        ]);

        //check if email has already been taken
        $shouldBeBlocked = SubscriptionService::getSubscriptionByEmail($request->customer_email);
        if ($shouldBeBlocked) {
            Log::error("Subscription with email {$request->customer_email} has already been stored");
            return Inertia::render('Subscription/GenerateSubscriptionLink', ['errors.customer_email' => "Subscription with email {$request->customer_email} has already been stored"]);
        }

        //the url to be returned
        $randomString = substr(str_shuffle(MD5(microtime())), 0, 22);

        //create a to-be-confirmed subscription
        try {
            Subscription::create([
                'subscription_email' => $request->customer_email,
                'status' => Subscription::PENDING,
                'token' => $randomString,
                'customer_id' => null,
                'year_from' => Carbon::now()->year,
                'year_to' => Carbon::now()->year + 1,
            ]);
        } catch (Exception $exception) {
            Log::error("Cannot create pending subscription with email {$request->customer_email} and token {$randomString}: {$exception->getMessage()}");
            abort(500);
        }

        Log::info("Pending Subscription for email {$request->customer_email} has been created!", [__CLASS__, __FUNCTION__]);

        try {
            Mail::to($request->customer_email)
            ->send(new SubscriptionToComplete(URL::signedRoute('subscriptions.fill', [
                'token' => $randomString])));
        } catch (Exception $exception) {
            Log::error("Cannot send Mail to {$request->customer_email}: " . $exception->getMessage());
        }
        if (Mail::failures()) {
            Log::error("Cannot send email!!!");
        } else {
            Log::info("Mail to {$request->customer_email} has been sent! Redirecting...", [__CLASS__, __FUNCTION__]);
        }
        

        return Redirect::route('subscriptions.index');
    }

    /**
     * the subscription PUBLIC init
     *
     * @param Request $request
     * @return string
     */
    public function publicInit(Request $request)
    {
        $request->validate([
            'customer_email' => 'required|email:filter|unique:subscriptions,subscription_email'
        ]);

        //check if email has already been taken
        $shouldBeBlocked = SubscriptionService::getSubscriptionByEmail($request->customer_email);
        if ($shouldBeBlocked) {
            Log::error("Subscription with email {$request->customer_email} has already been stored");
            return Inertia::render('Public/SelfInvitation', ['errors.customer_email' => "Subscription with email {$request->customer_email} has already been stored"]);
        }

        //the url to be returned
        $randomString = substr(str_shuffle(MD5(microtime())), 0, 22);

        //create a to-be-confirmed subscription
        try {
            Subscription::create([
                'subscription_email' => $request->customer_email,
                'status' => Subscription::PENDING,
                'token' => $randomString,
                'customer_id' => null,
                'year_from' => Carbon::now()->year,
                'year_to' => Carbon::now()->year + 1,
            ]);
        } catch (Exception $exception) {
            Log::error("Cannot create pending subscription with email {$request->customer_email} and token {$randomString}: {$exception->getMessage()}");
            abort(500);
        }

        Log::info("Pending Subscription for email {$request->customer_email} has been created!", [__CLASS__, __FUNCTION__]);

        return Redirect::to(URL::signedRoute('subscriptions.fill', [
                'token' => $randomString]));
    }

    public function fill(string $token)
    {
        try {
            $subscriptionToFill = Subscription::where('token', '=', $token)
            ->where('status', Subscription::PENDING)
            ->firstOrFail();
        } catch (Exception $modelNotFoundException) {
            Log::error("Cannot Find pending Subscription to fill: " . $modelNotFoundException->getMessage());
            abort(401);
        }

        $subscriptionToFill->update([
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Log::info("Subscription can be completed!!!", [__CLASS__, __FUNCTION__]);

        //should return form
        return Inertia::render('Public/CompleteSubscription', [
            'sub_token' => $token,
            'activities' => SubscriptionService::getAllFancyActivityLabels(),
            'default_contact' => Subscription::NO_CONTACT,
            'contacts' => SubscriptionService::getAllFancyContactLabels(),
            'url' => route('subscriptions.complete')
        ]);
    }

    public function complete(Request $request)
    {
        /**
         * 1. check if subscription is valid
         * 2. create the customer
         * 3. complete the subscription (should be another status such as TO_BE_CONFIRMED)
         * 4. return the response
         */

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'birth' => 'required',
            'resident' => 'required',
         ]);

        //TODO: check if subscription is valid
        if (!$request->has('sub_token') || !$request->input('sub_token')) {
            Log::error("Cannot retrieve Token from request, aborting");
            abort(400);
        }

        //checking if data is correct
        $canHandleSubscription = SubscriptionService::subscriptionCanBeConfirmed($request->input('sub_token'));

        if (!$canHandleSubscription->first()) {
            Log::error("Cannot find subscription with token " . $request->input('sub_token'));
            abort(400);
        }
        
        //validate the request
        if (!$request->validate($this->rules['complete'])) {
            Log::info("Cannot validate Request");
            abort(400);
        }

        //Create the customer
        try {
            $customer = Customer::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'city' => $request->input('city'),
                'email' => $canHandleSubscription->last(), //should not be handled from the public form
                'phone' => $request->input('phone'),
                'birth' => $request->input('birth'),
                'province' => $request->input('province'),
                'resident' => $request->input('resident'),
                'address' => $request->input('address'),
                'postal_code' => $request->input('postal_code'),
            ]);
        } catch (\Exception $ex) {
            Log::error("Cannot create customer with data " . implode(",", $request->all()) . ": Error: {$ex->getMessage()}");
            return false;
        }

        Log::info("Customer with ID {$customer->id} successfully created", [__CLASS__, __FUNCTION__]);

        try {
            Mail::to($canHandleSubscription->last())->send(new SubscriptionFilled());
        } catch (Exception $exception) {
            Log::error("Cannot send Mail to {$canHandleSubscription->last()}: " . $exception->getMessage());
        }

        //retrieve year_from and year_to
        $years = SubscriptionService::getSubscriptionYears();
        Log::info("subscription years: " . implode(",", $years->toArray()));

        //complete the subscription
        Subscription::where('token', $request->input('sub_token'))
         ->first()->update([
             'customer_id' => $customer->id,
             'status' => Subscription::TO_BE_CONFIRMED,
             'contact_type' => $request->input('contact_type'),
             'activity' => $request->input('activity'),
             'year_from' => $years['from'],
             'year_to' => $years['to'],
         ]);

        Log::info("redirecting to subscriptions/" . $request->input('sub_token') . "/confirmed");
        
        /** TODO: Redirect on public simple view */
        return redirect()
            ->action(
                [SubscriptionController::class, 'confirmed'],
                ['email' => $request->input('email')]
            );
    }

    public function confirmed()
    {
        return Inertia::render('Subscription/Confirmed');
    }
}
