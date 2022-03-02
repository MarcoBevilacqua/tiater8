<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Show;
use Carbon\Carbon;
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
            // ->groupBy('show_event_id')
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id,
                    'show' => $booking->showEvent->show->title,
                    'customer' => $booking->customer->full_name,
                    'date' => Carbon::createFromTimeString($booking->showEvent->show_date)->format('l d F Y - h:i'),
                    'places' => $booking->number_of_places,
                    'edit' => URL::route('bookings.edit', $booking)
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
            ['booked' => [
                'id' => $booking->id,
                'customer' => $booking->customer->full_name,
                'show' => $booking->showEvent->show->title,

            ],
            'bookings' => Booking::where('show_event_id', $booking->show_event_id)->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id,
                    'show' => $booking->showEvent->show->title
                ];
            }),
            '_method'  => 'put',
            ]
        );
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
                    'name' => $customer->full_name
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
    public function update(Request $request)
    {
        $request->validate([
            'place' => 'required',
            'row' => 'required',
            'booking' => 'required|exists:bookings,id'
        ]);
            
        try {
            $booking = Booking::findOrFail($request->booking);
        } catch (\Exception $exception) {
            Log::error("Cannot update booking: {$exception->getMessage()}");
            return Redirect::back()->with('error', "Errori nella richiesta");
        }

        $booking->update([
                'place' => $request->place,
                'row' => $request->row
            ]);

        return Redirect::to('bookings');
    }

    /**
     * save booking
     * @param Request $request
     * @return bool
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'show_event_id' => 'required',
        ]);

        $booking = null;

        try {
            $booking = Booking::create([
                'customer_id' => $request->customer_id,
                'show_event_id' => $request->show_event_id,
                'booking_code' => strtoupper(Str::random(8)),
                'number_of_places' => 1
            ]);
        } catch (\Exception $ex) {
            Log::error("Cannot save booking: {$ex->getMessage()}");
            return Redirect::to('bookings/create')->with('error', 'Invalid data');
        }

        return Redirect::to('bookings/' . $booking->id .'/edit');
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
