<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $customerList = Customer::all();
        return Inertia::render('Customers', 
            ['customers' => $customerList]);
    }
}
