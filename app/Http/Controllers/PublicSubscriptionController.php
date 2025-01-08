<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionFilled;
use App\Mail\SubscriptionToComplete;
use App\Models\Customer;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Inertia\Response;

class PublicSubscriptionController extends Controller
{
    /**
     * PAIRINGS WITH SUBSCRIPTION CONTROLLER METHODS
     *
     * INDEX --> CONFIRMED
     * CREATE --> START
     * SHOW --> GENERATE
     * STORE --> INIT
     * EDIT --> FILL
     * UPDATE --> COMPLETE
     */

    /**
     * Renders "confirmed" page
     * @return Response
     */
    public function index(): Response
    {
        $cookie = Cookie::get('subscription-confirmed');
        if(!$cookie) {
            return Inertia::render('Public/SelfInvitation');
        }
        return Inertia::render('Public/Confirmed');
    }

    /**
     * render the view to generate invitation mail
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Public/SelfInvitation');
    }

    /**
     * render the view to generate invitation mail
     * @return Response
     */
    public function show(): Response
    {
        return Inertia::render('Subscription/GenerateSubscriptionLink');
    }

    /**
     * the subscription init (return the form url)
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_email' => 'required|email:filter'
        ]);

        //check if sub should be renewed
        $shouldRenew = SubscriptionService::subscriptionShouldBeRenewed($request->get('customer_email'));
        if($shouldRenew) {
            Log::info("Renewing subscription for {$request->get('customer_email')}...");
            return Redirect::to(URL::signedRoute('subscriptions.renew', [
                'customer_email' => $request->get('customer_email')]));
        } else {
            Log::info("New Subscription incoming...");
        }

        //the url to be returned
        $randomString = substr(str_shuffle(MD5(microtime())), 0, 22);

        //retrieve year_from and year_to
        $years = SubscriptionService::getSubscriptionYears();

        //create a to-be-confirmed subscription
        try {
            Subscription::create([
                'subscription_email' => $request->customer_email,
                'status' => Subscription::PENDING,
                'token' => $randomString,
                'customer_id' => null,
                'year_from' => $years['from'],
                'year_to' => $years['to'],
            ]);
        } catch (\Exception $exception) {
            Log::error("Cannot create pending subscription with email {$request->customer_email} and token {$randomString}: {$exception->getMessage()}");
            return Redirect::back()->with('error', "Indirizzo email non disponibile");
        }

        Log::info("Pending Subscription for email {$request->customer_email} has been created!", [__CLASS__, __FUNCTION__]);

        //if request is coming from the admin area, mail should be sent as invitation.
        //otherwise, just make the redirect to the subscription.fill route
        if (!$request->is('over/*')) {
            try {
                Mail::to($request->customer_email)
                    ->send(new SubscriptionToComplete(URL::signedRoute('subscriptions.fill', [
                        'token' => $randomString])));
            } catch (\Exception $exception) {
                Log::error("Cannot send Mail to {$request->customer_email}: " . $exception->getMessage());
            }
            if (Mail::failures()) {
                Log::error("Cannot send email!!!");
            } else {
                Log::info("Mail to {$request->customer_email} has been sent! Redirecting...", [__CLASS__, __FUNCTION__]);
            }
            return Redirect::route('subscriptions.index');
        }


        return Redirect::to(URL::signedRoute('subscriptions.fill', [
            'token' => $randomString]));
    }

    /**
     * check if subscription can be completed and redirect to the customer form
     *
     * @param string $token
     * @return Response
     */
    public function edit(string $token)
    {
        try {
            $subscriptionToFill = Subscription::where('token', '=', $token)
                ->where('status', Subscription::PENDING)
                ->firstOrFail();
        } catch (\Exception $modelNotFoundException) {
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

    /**
     * Completes the subscription and creates customer entry
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        /**
         * 1. check if subscription is valid
         * 2. create the customer
         * 3. complete the subscription (should be another status such as TO_BE_CONFIRMED)
         * 4. return the response
         */

        Log::info("Completing subscription...");
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'birth' => 'required',
            'resident' => 'required',
            'fiscal_code' => 'required|size:16'
        ]);

        Log::info("Request validated, proceeding...");


        //TODO: check if subscription is valid
        if (!$request->has('sub_token') || !$request->input('sub_token')) {
            Log::error("Cannot retrieve Token from request, aborting");
            abort(400);
        }

        //checking if data is correct
        $canHandleSubscription = SubscriptionService::subscriptionCanBeConfirmed($request->input('sub_token'));

        if (!$canHandleSubscription->count()) {
            Log::error("Cannot find subscription with token " . $request->input('sub_token'));
            abort(400);
        }

        //Create the customer
        try {
            $customer = Customer::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'city' => $request->input('city'),
                'email' => $canHandleSubscription->subscription_email, //should not be handled from the public form
                'phone' => $request->input('phone'),
                'birth' => $request->input('birth'),
                'province' => $request->input('province'),
                'resident' => $request->input('resident'),
                'address' => $request->input('address'),
                'postal_code' => $request->input('postal_code'),
                'fiscal_code' => $request->input('fiscal_code'),
            ]);
        } catch (\Exception $ex) {
            Log::error("Cannot create customer with data " . implode(",", $request->all()) . ": Error: {$ex->getMessage()}");
            return Redirect::back()->with('error', "Errore durante l'elaborazione della richiesta, si prega di riprovare.");
        }

        Log::info("Customer with ID {$customer->id} successfully created", [__CLASS__, __FUNCTION__]);
        //create cookie
        $cookie = Cookie::make('subscription-confirmed', true, 1);
        try {
            Mail::to($canHandleSubscription->subscription_email)->send(new SubscriptionFilled());
        } catch (\Exception $exception) {
            Log::error("Cannot send Mail to {$canHandleSubscription->subscription_email}: " . $exception->getMessage());
        }

        //complete the subscription
        Subscription::where('token', $request->input('sub_token'))
            ->first()->update([
                'customer_id' => $customer->id,
                'status' => Subscription::TO_BE_CONFIRMED,
                'contact_type' => $request->input('contact_type'),
                'activity' => $request->input('activity'),
            ]);

        Log::info("redirecting to subscriptions/confirmed");

        /** TODO: Redirect on public simple view */
        return Redirect::to('over/subscriptions')->cookie($cookie);
    }

    //TODO: CHECK EMAIL MATCH
    public function modify()
    {
        Log::info("Renew Form being displayed");
        return Inertia::render('Public/Renew');
    }

    public function renew(Request $request) {
        $sub = Subscription::where([
            ['subscription_email', '=', $request->get('customer_email')],
            ['status', '=', Subscription::EXPIRED]
        ])->firstOrFail();

        //retrieve year_from and year_to
        $years = SubscriptionService::getSubscriptionYears();

        $renewed = new Subscription([
            'year_from' => $years['from'],
            'year_to' => $years['to'],
            'subscription_email' => $request->get('customer_email'),
            'status' => Subscription::TO_BE_CONFIRMED,
            'customer_id' => $sub->customer_id,
            'contact_type' => $sub->contact_type,
            'activity' => $sub->activity,
        ]);

        $renewed->save();
    }
}
