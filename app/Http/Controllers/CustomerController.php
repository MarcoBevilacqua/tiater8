<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render(
            'Customers',
            [
            'customers' => Customer::when($request->has('search'), function ($query) use ($request) {
                $query->where('first_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');
            })
            ->orderByDesc('id')
            ->paginate(25)
            ->through(function (Customer $customer) {
                return [
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'email' => $customer->email,
                    'edit' => URL::route('customers.edit', $customer)
                ];
            })
        , 'createLink' => route('customers.create')]
        );
    }

    public function create()
    {
        return Inertia::render('Customers/Create', [
            'activities' => SubscriptionService::getAllFancyActivityLabels(),
            'contacts' => SubscriptionService::getAllFancyContactLabels(),
            '_method' => 'post'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
            'resident' => 'required',
            'birth' => 'required'
        ]);

        try {
            Customer::create($validated);
        } catch (\Exception $exception) {
            Log::error("Cannot create customer: {$exception->getMessage()}");
            return Redirect::route('customers.create');
        }

        return Redirect::route('customers.index');
    }

    /**
     * @param int $id
     * return bool|App/Models/Customer
     */
    public function edit(int $id)
    {
        Log::info("Customer id: {$id}");
        try {
            $customer = Customer::findOrFail($id);
            Log::info("Customer: {$customer}");
        } catch (\Exception $ex) {
            Log::error("Cannot find customer with Id: {$id}");
            return false;
        }

        return Inertia::render('Customers/Form', [
            'customer' => [
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'address' => $customer->address,
            'city' => $customer->city,
            'phone' => $customer->phone,
            'birth' => $customer->birth,
            'fiscal_code' => $customer->fiscal_code,
            'postal_code' => $customer->postal_code,
            'province'=> $customer->province,
            'resident' => $customer->resident
        ],
            '_method'  => 'put'
    ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'birth' => 'required',
            'resident' => 'required',
        ]);

        Log::debug("Valid data: " . implode(",", $validated));

        Log::info("updating customer with id: {$request->input('id')}");
        try {
            Customer::updateOrCreate(
                ['id' => $request->input('id')],
                $validated
            );
        } catch (\Exception $exception) {
            Log::error("Cannot update customer: {$exception->getMessage()}");
        }

        return Redirect::route('customers.index');
    }
}
