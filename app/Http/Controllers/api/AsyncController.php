<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

        $searchTerm = Str::lower($request->term) . '%';

        return Customer::select(['id', 'first_name', 'last_name'])
            ->whereRaw('LOWER(first_name) LIKE ?', $searchTerm . "%")
            ->orWhereRaw('LOWER(last_name) LIKE ?', $searchTerm . "%")
            ->take(10)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->first_name . " " . $customer->last_name
                ];
            });
    }
}
