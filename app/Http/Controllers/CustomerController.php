<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class CustomerController extends Controller
{
    public function index()
    {
        return Inertia::render(
            'Customers',
            ['customers' => Customer::all()->map(function (Customer $customer) {
                return [
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'email' => $customer->email,
                    'edit' => URL::route('customers.edit', $customer)
                ];
            })
        ]
        );
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
        } catch (\Exception $ex) 
        {
            Log::error("Cannot find customer with Id: {$id}");
            return false; 
        }

        return Inertia::render('Customers/Form', [
            'customer' => [
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email
        ],
            '_method'  => 'put'     
    ]);
    }

    public function update(Request $request)
    {        
        Log::info("updating customer with id: {$request->input('id')}");
        Customer::updateOrCreate(
            ['id' => $request->input('id')],
            [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]
        );

        return Redirect::route('customers.index');

    }
}