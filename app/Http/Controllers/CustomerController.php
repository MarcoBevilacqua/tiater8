<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;



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
        try {
            $customer = Customer::find($id)->firstOrFail();
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
}
