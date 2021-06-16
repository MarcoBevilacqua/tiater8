<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Hash;
use Illuminate\Http\Response;

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

        //check if email has already been taken 
        $shouldBeBlocked = Subscription::where('email', $request->customer_email)->first();
        if($shouldBeBlocked){
            abort(403);
        }

        //the url to be returned
        $formUrl = URL::to('/subscriptions') . "/" . substr(str_shuffle(MD5(microtime())), 0, 22);

        //create a to-be-confirmed subscription
        $pendingSub = Subscription::create([            
            'token' => Hash::make($request->customer_email . "|" . time()),
            'status' => 0,
            'form_url' => $formUrl,
            'customer_id' => null
        ]);

        if(!$pendingSub){        
            //TODO: refactor the error management
            abort(500);
        }

        return $formUrl;
    }

    public function generate(Request $request){

        $token = $request->session()->token();
        $token = csrf_token();

        return Inertia::render(
            'Subscription/GenerateLink', [
                'token' => $token
            ]);
    }

    public function fill(string $token){
        return Response::HTTP_OK;
    }

    public function complete(){
        return true;
    }
}
