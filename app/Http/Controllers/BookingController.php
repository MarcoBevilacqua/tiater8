<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Show;
use App\Models\ShowEvent;
use App\Models\Subscription;
use App\Models\Viewer;
use Faker\Factory;
use Illuminate\View\View;
use Validator;
use Log;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index()
    {
        /**
         * TODO: how to structure the bookings collection?
         */
        return Inertia::render('Bookings', [
            'bookings' => Booking::orderByDesc('id')
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id
                ];
            }),
            'customers' => Subscription::active()->get()
            ->map(function (Subscription $subscription) {
                return [
                    'id' => $subscription->id,
                    'name' => $subscription->customer->first_name . ' ' . $subscription->customer->last_name
                ];
            }),
            'createLink' => URL::route('bookings.create')
        ]);
    }

    public function show($code)
    {
        $booking = Booking::where('public_code', $code)->get();
        return view('crud/prenotazioni.show', array('booking' => $booking));
    }

    /**
     * @param $code
     * @return $this
     */
    public function edit($code)
    {
        $booking = Booking::wherePublicCode($code)->firstOrFail();
        $events = Show::find($booking->show_id)->getEvents();
        return view('crud/prenotazioni.edit', array('booking' => $booking, 'events' => $events));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        //shows form create new
        return view(
            'crud/prenotazioni.create',
            ['shows' => Show::pluck('name', 'id')]
        );
    }

    /**
     * Update the specified resource in storage.
     * @param $code
     * @return mixed
     */
    public function update(Request $request, $code)
    {
        $data = $request->all();

        $event_id = $data['event_id'];
        $full_price = $data['full_price_qnt'];
        $half_price = $data['half_price_qnt'];
        $paid = $data['paid'];
        $place_code = $data['place_code'];


        //validazione
        $rules = array(
            'event_id' => 'required',
            'full_price_qnt' => 'required|numeric',
            'half_price_qnt' => 'required|numeric',
            'paid' => 'required',
            'place_code' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('prenotazioni/'. $code . '/edit')
                ->withErrors($validator);
        } else {

            /** @var Booking $booking */
            $booking = Booking::wherePublicCode($code)->first();

            if ($booking) {

                //pulling off places from show
                $show = Show::find($booking->show_id);
                $show->places += ($booking->full_price_qnt + $booking->half_price_qnt);

                $booking->event_id = $event_id;
                $booking->full_price_qnt = $full_price;
                $booking->half_price_qnt = $half_price;
                $booking->place_code = $place_code;
                $booking->paid = $paid;

                try {
                    $booking->save();
                } catch (\Exception $ex) {
                    Log::error("cannot update booking: {$ex->getMessage()}");
                    return redirect('prenotazioni/'. $code . '/edit');
                }

                return redirect('book/get/list/' . $show->url);
            }
        }
    }

    /**
     * save booking
     * @param Request $request
     * @return bool
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (!$data || empty($data)) {
            return false;
        }

        //vars
        $returnVars = array();
        $factory = Factory::create();
        $factory->addProvider('Faker\Provider\Miscellaneous');
        $paid = array_key_exists('paid', $data) ? true : false;

        $token = new Booking();

        $token->viewer_id = $data['viewer'];
        $token->event_id = $data['date'];
        $token->show_id = $data['show'];
        $token->paid = $paid;
        $token->full_price_qnt = $data['full_price_qnt'];
        $token->half_price_qnt = $data['half_price_qnt'];
        $token->total_qnt = $data['full_price_qnt'] + $data['half_price_qnt'];
        $token->booking_date = new \DateTime();
        $token->place_code = $data['place_code'];
        $token->public_code = $this->createPublicCode();
        $token->booking_code = $factory->sha256;


        //TODO Controlli su disponibilità posti

        //salva prenotazione
        try {
            $token->save();
        } catch (\Exception $ex) {
            \Session::flash('save_error', $ex->getMessage());
            Log::error("Booking not saved: " . $ex->getMessage());
            return view('crud/prenotazioni/create');
        }

        if ($token->exists()) {
            $returnVars['token'] = $token;

            $event = ShowEvent::find($data['date']);
            $show = Show::find($data['show']);

            $returnVars['event'] = $event;
            $returnVars['show'] = $show;
            $returnVars['viewer'] = Viewer::find($data['viewer']);

            //$afterBookingEventOps = $this->afterBookingEvent($event, $toRemoveArray);
            //$afterBookingShowOps = $this->afterBookingShow($show, $toRemoveSum);
        }

        return view('bookConfirm', ['data' => $returnVars]);
    }

    /**
     * @param $code
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($code)
    {
        if (!$code) {
            return false;
        }
        
        try {
            Booking::wherePublicCode($code)->delete();
        } catch (\Exception $ex) {
            Log::alert("Cannot delete booking: {$ex->getMessage()}");
            return false;
        }

        return redirect(\URL::to('/'));
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function findByEvent($id)
    {

        /** @var \App\Booking $bookings */
        $bookings = Booking::where('event_id', '=', $id);

        if (!$bookings) {
            return false;
        }

        return response($bookings->toJson());
    }


    /**
     * create public code for booking search optimization
     * @return string
     */
    private function createPublicCode()
    {
        $chars = str_split('abcdefghijklmnopqrstuvwxyz0123456789@!*_|&=');
        $factory = Factory::create();
        $code = $factory->randomElements($chars, 10);

        return strtoupper(implode("", $code));
    }
}
