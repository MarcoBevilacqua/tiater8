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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index()
    {
        return Inertia::render('Bookings', [
            'bookings' => Booking::orderByDesc('id')
            ->get()
            ->groupBy('show_event_id')
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id,
                    'show' => $booking->showEvent->show->title,
                    'date' => $booking->showEvent->show->show_date,
                    'places' => $booking->showEvent->full_price_qnt
                ];
            }),
            'createLink' => URL::route('bookings.create')
        ]);
    }

    /**
     * show the places map
     * @param int $id
     * @return $this
     */
    public function edit($id)
    {
        /**
         * TODO: how to structure the bookings collection?
         */
        $booking = Booking::findOrFail($id);
        return Inertia::render(
            'Bookings/Form',
            ['booked' => $booking->toArray(),
            'bookings' => Booking::where('show_event_id', $booking->show_event_id)->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id,
                    'show' => $booking->showEvent->show->title
                ];
            }),
            ]
        );
    }

    public function show($code)
    {
        $booking = Booking::where('public_code', $code)->get();
        return view('crud/prenotazioni.show', array('booking' => $booking));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return Inertia::render(
            'Bookings/Create',
            ['shows' => Show::orderByDesc('created_at')
            ->get()
            ->map(function (Show $show) {
                return [
                    'id' => $show->id,
                    'title' => $show->title
                ];
            }),
            'customers' => Customer::all()
            ->map(function (Customer $customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->first_name . " " . $customer->last_name
                ];
            }),
            '_method' => 'POST']
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
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'show_event_id' => 'required',
        ]);

        $booking = null;

        try {
            $booking = Booking::create([
                'customer_id' => $request->customer_id,
                'show_event_id' => $request->show_event_id,
                'booking_code' => strtoupper(Str::random(8))
            ]);
        } catch (\Exception $ex) {
            Log::error("Cannot save booking: {$ex->getMessage()}");
            return Redirect::to('bookings/create')->with('error', 'Invalid data');
        }

        return Redirect::to('bookings/edit/' . $booking->id);
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
