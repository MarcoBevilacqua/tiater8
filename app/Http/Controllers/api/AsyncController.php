<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Response;

class AsyncController extends Controller
{
    /**
     * search for customers in async inputs
     * @param Request $request
     * @return Response
     */
    public function customers(Request $request)
    {
        return Customer::select(['id', 'first_name', 'last_name'])
            ->where('first_name', 'LIKE', '%' . $request->term . '%')
            ->orWhere('last_name', 'LIKE', '%' . $request->term . '%')
            ->get()
            ->toArray();
    }
}
