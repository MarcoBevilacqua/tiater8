<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Hash;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{

    /**
     * the subscription index
     * @return Inertia view
     */
    public function index(){
        return Inertia::render(
            'Subscriptions',
            ['subscriptions' => Subscription::all()->map(function (Subscription $subscription) {
                return [
                    'token' => $subscription->token,
                    'customer' => $subscription->customer_id,
                    'status' => $subscription->status
                ];
            })
        ]
        );
    }

    /**
     * the subscription init (return the form url)
     * 
     * @param Request $request
     * @return string
     */
    public function init(Request $request){
        if(!$request->has('customer_email') || !$request->customer_email) {
            //TODO: refactor the error management
            abort(400);
        }

        //the url to be returned
        $formUrl = URL::to('/subscriptions/') . substr(str_shuffle(MD5(microtime())), 0, 8);

        //create a to-be-confirmed subscription
        $pendingSub = Subscription::create([            
            'token' => Hash::make($request->customer_email . "|" . time()),
            'status' => 'PENDING',
            'form_url' => $formUrl,
            'customer_id' => null
        ]);

        if(!$pendingSub){        
            abort(500);
        }

        return $formUrl;
    }
}
