<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AsyncController extends Controller
{
    /**
     * search for customers in async inputs
     * @param Request $request
     * @return JsonResponse
     */
    public function customers(Request $request): JsonResponse
    {

        $searchTerm = Str::lower($request->term) . '%';

        return response()->json(Customer::select(['id', 'first_name', 'last_name'])
            ->whereRaw('LOWER(first_name) LIKE ?', $searchTerm . "%")
            ->orWhereRaw('LOWER(last_name) LIKE ?', $searchTerm . "%")
            ->take(10)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->first_name . " " . $customer->last_name
                ];
            })
        );
    }
}
