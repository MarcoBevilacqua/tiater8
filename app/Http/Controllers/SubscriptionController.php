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
        $this->rules = [
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
    public function index(Request $request)
    {
        return Inertia::render(
            'Subscriptions',
            ['subscriptions' => Subscription::when($request->has('search'), function ($query) use ($request) {
                $query->where('subscription_email', 'LIKE', '%' . $request->search . '%');
            })
                ->orderByDesc('id')
                ->paginate(25)
                ->through(function (Subscription $subscription) {
                    return [
                    'id' => $subscription->id,
                    'customer' => $subscription->subscription_email,
                    'created' => $subscription->created_at->format('d/m/Y'),
                    'statusID' => $subscription->status,
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
            Redirect::back()->with("error", "Errore durante l'elaborazione");
        }

        return Redirect::route('subscriptions.index')->with("success", "Operazione completata con successo");
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

    /**
     * update entity
     * @param Request $request
     * @return Redirect
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|numeric',
            'contact_type' => 'required|numeric',
            'activity' => 'required|numeric',
            'year_from' => 'required|numeric',
            'year_to' => 'required|numeric'
        ]);

        $subscription = Subscription::where('id', '=', $request->id)->firstOrFail();
        
        try {
            $subscription->update(
                [
            'status' => $request->input('status'),
            'subscription_email' => $request->input('subscription_email'),
            'activity' => $request->input('activity'),
            'contact_type' => $request->input('contact_type'),
            'year_from' => $request->input('year_from'),
            'year_to' => $request->input('year_to')
        ]
            );
        } catch (\Exception $exception) {
            Log::error("Cannot update subscription: {$exception->getMessage()}");
            Redirect::back()->with("error", "Impossibile aggiornare i dati");
        }

        return Redirect::route('subscriptions.index')->with("success", "Dati aggiornati correttamente");
    }

    /**
     * update status (uses PATCH)
     * @param int $status
     */
    public function updateStatus(Subscription $subscription, int $status)
    {
        $oldStatus = $subscription->status;
        if ($oldStatus == $status || !in_array($status, [Subscription::ACTIVE, Subscription::EXPIRED, Subscription::INACTIVE])) {
            Log::info("Cannot change status from {$oldStatus} to {$status}");
            return Redirect::to('subscriptions')->with('error', 'Impossibile modificare lo status della sottoscrizione');
        }

        $subscription->update([
            'status' => $status
        ]);

        return Redirect::to('subscriptions')->with('success', 'Sottoscrizione aggiornata correttamente');
    }

    public function destroy(Subscription $subscription)
    {
        try {
            Subscription::findOrFail($subscription->id)->delete();
        } catch (\Exception $exception) {
            Log::error("Cannot find subscription with ID {$subscription->id}: {$exception->getMessage()}");
            return Redirect::to('subscriptions')->with('error', 'Impossibile cancellare la sottoscrizione');
        }

        Log::info("Subscription successfully deleted");
        return Redirect::to('subscriptions')->with('success', 'Cancellazione avvenuta correttamente');
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
            'customer_email' => 'required|email:filter'
        ]);

        //check if email has already been taken
        $shouldBeBlocked = SubscriptionService::getSubscriptionByEmail($request->customer_email);
        if ($shouldBeBlocked) {
            Log::error("Subscription with email {$request->customer_email} has already been stored");
            return Redirect::back()->with('error', "Indirizzo email non disponibile");
        }

        //the url to be returned
        $randomString = substr(str_shuffle(MD5(microtime())), 0, 22);

        //create a to-be-confirmed subscription
        try {
            Subscription::updateOrCreate([
                'subscription_email' => $request->customer_email], [
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
}
