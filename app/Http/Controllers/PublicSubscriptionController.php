<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePublicSubscriptionRequest;
use App\Mail\SubscriptionFilled;
use App\Models\Customer;
use App\Models\Subscription;
use App\Services\MailService;
use App\Services\PublicSubscriptionService;
use App\Services\SubscriptionService;
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

        // create token
        $token = substr(str_shuffle(MD5(microtime())), 0, 22);

        // If sub should be renewed redirect to renew form
        $shouldRenew = SubscriptionService::subscriptionShouldBeRenewed($request->get('customer_email'));

        // redirect
        if($shouldRenew) {
            Log::info("Renewing subscription for {$request->get('customer_email')}...");
            return Redirect::to(URL::signedRoute('subscriptions.renew', [
                'customer_email' => $request->get('customer_email')]));
        } else {
            Log::info("New Subscription incoming...");
        }

        //create a to-be-confirmed subscription
        try {
            PublicSubscriptionService::createToBeConfirmed($request->customer_email, $token);
        } catch (\Exception $exception) {
            Log::error("Cannot create pending subscription with email {$request->customer_email} and token {$token}: {$exception->getMessage()}");
            return Redirect::back()->with('error', "Indirizzo email non disponibile");
        }

        /**
         * if request is coming from the admin area, mail should be sent as invitation.
         * otherwise, just make the redirect to the subscription.fill route
         */
        if (!$request->is('over/*')) {
            // send email notification
            MailService::sendToCompleteSubscription($request->customer_email, $token);
            // return to internal subscription
            return Redirect::route('subscriptions.index');
        }
        return Redirect::to(URL::signedRoute('subscriptions.fill', ['token' => $token]));
    }

    /**
     * check if subscription can be completed and redirect to the customer form
     *
     * @param string $token
     * @return Response
     */
    public function edit(string $token): Response
    {
        try {
            PublicSubscriptionService::updatePendingSubscription($token);
        } catch (\Exception $ex) {
            Log::error("Cannot update pending Subscription: " . $ex->getMessage());
            return \response()->abort(\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);
        }

        Log::info("Subscription can be completed, redirecting...", [__CLASS__, __FUNCTION__]);

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
     * @param UpdatePublicSubscriptionRequest $request
     * @return RedirectResponse
     */
    public function update(UpdatePublicSubscriptionRequest $request): RedirectResponse
    {
        /**
         * 1. check if subscription is valid
         * 2. create the customer
         * 3. complete the subscription (should be another status such as TO_BE_CONFIRMED)
         * 4. return the response
         */

        Log::info("Request validated, proceeding...");

        // get validated data
        $validated = $request->validated();

        //checking if data is correct
        $canHandleSubscription = SubscriptionService::subscriptionCanBeConfirmed($validated['sub_token']);

        if (!$canHandleSubscription->count()) {
            Log::error("Cannot find subscription with token " . $request->input('sub_token'));
            abort(400);
        }

        //Create the customer
        try {
            $customer = Customer::create(
                $validated + [
                'email' => $canHandleSubscription->subscription_email, //should not be handled from the public form
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
