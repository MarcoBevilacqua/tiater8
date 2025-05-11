<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Customer;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

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
     *
     * @param Request $request
     * @return Response view
     */
    public function index(Request $request)
    {
        return Inertia::render(
            'Subscriptions',
            ['subscriptions' => Subscription::select(['id', 'customer_id', 'subscription_email', 'year_from', 'status', 'created_at'])
                ->when($request->has('search'), function ($query) use ($request) {
                    $query->where('subscription_email', 'LIKE', '%' . $request->search . '%');
                })
                ->orderByDesc('id')
                ->paginate(25)
                ->through(function (Subscription $subscription) {
                    return [
                        'id' => $subscription->id,
                        'email' => $subscription->subscription_email,
                        'customer' => $subscription->customer_id ? Customer::find($subscription->customer_id)->first()->fullName : "",
                        'created' => $subscription->created_at,
                        'season' => $subscription->year_from . "/" . ($subscription->year_from + 1),
                        'status' => ['value' => $subscription->status, 'label' => SubscriptionService::getSubFancyStatusLabel($subscription->status)],
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
    public function create(): Response
    {
        $years = SubscriptionService::getSubscriptionYears()->toArray();

        return Inertia::render('Subscription/Create', [
            'year_from' => $years['from'],
            'year_to' => $years['to'],
            'av_statuses' => SubscriptionService::getAllSubFancyStatusLabel(),
            'activities' => SubscriptionService::getAllFancyActivityLabels(),
            'contacts' => SubscriptionService::getAllFancyContactLabels(),
            '_method' => 'post',
        ]);
    }

    /**
     * creation from form
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules['store']);

        /** @var string $subscriptionEmail */
        $subscriptionEmail = Customer::findOrFail($validated['customer_id'])->email;

        try {
            Subscription::create($validated + ['subscription_email' => $subscriptionEmail]);
        } catch (\Exception $exception) {
            Log::error("Cannot create subscription: {$exception->getMessage()}");
            Redirect::back()->with("error", "Errore durante l'elaborazione");
        }

        return Redirect::route('subscriptions.index')->with("success", "Operazione completata con successo");
    }

    /**
     * @param int $subscriptionId
     * @return Response view
     */
    public function edit(int $subscriptionId): Response
    {
        /** @var Subscription $subscription */
        $subscription = Subscription::findOrFail($subscriptionId);

        return Inertia::render('Subscription/Form', [
            'subscription' => $subscription,
            'customer' => $subscription->customer->fullName ?? "",
            '_method' => 'put',
            'av_statuses' => SubscriptionService::getAllSubFancyStatusLabel(),
            'activities' => SubscriptionService::getAllFancyActivityLabels(),
            'contacts' => SubscriptionService::getAllFancyContactLabels(),
        ]);
    }

    /**
     * update entity
     * @param UpdateSubscriptionRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(UpdateSubscriptionRequest $request): RedirectResponse
    {
        /** @var Subscription $subscription */
        $subscription = Subscription::where('id', '=', $request->id)->firstOrFail();

        try {
            $subscription->update(
                [
                    'customer_id' => $request->input('customer_id'),
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
            Redirect::back()
                ->with("error", "Impossibile aggiornare i dati");
        }

        return Redirect::route('subscriptions.index')->with("success", "Dati aggiornati correttamente");
    }

    public function destroy(Subscription $subscription): RedirectResponse
    {
        try {
            $sub = Subscription::findOrFail($subscription->id);
        } catch (\Exception $exception) {
            Log::error("Cannot find subscription with ID {$subscription->id}: {$exception->getMessage()}");
            return Redirect::to('subscriptions')->with('error', 'Impossibile cancellare la sottoscrizione');
        }

        $sub->delete();

        Log::info("Subscription successfully deleted");
        return Redirect::to('subscriptions')->with('success', 'Cancellazione avvenuta correttamente');
    }
}
