<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Show;
use App\Models\ShowEvent;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    /**
     * index showing bookings total grouped by show events
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Bookings', [
            'shows' => Show::get()
                ->map(function (Show $show) {
                    return [
                        'id' => $show->id,
                        'title' => $show->title,
                        'description' => Str::limit($show->description, 120),
                        'edit' => route('shows.edit', ['show' => $show->id])
                    ];
                }),
            'bookings' => DB::table('bookings')
                ->rightJoin('show_events', 'bookings.show_event_id', '=', 'show_events.id')
                ->join('shows', 'show_events.show_id', '=', 'shows.id')
                ->selectRaw('count(bookings.id) as booking_nr, shows.title, show_events.show_date, show_events.id as event_id')
                ->where('show_events.show_id', '=', $request->show_id)
                ->groupBy('show_events.show_date', 'shows.title', 'show_events.id')
                ->get()
                ->map(function ($item) use ($request) {
                    return [
                        'id' => $item->event_id,
                        'total' => $item->booking_nr,
                        'show' => $item->title,
                        'date' => Carbon::createFromTimeString($item->show_date)->format('l d F Y - H:i'),
                        'show_event_id' => $item->event_id,
                        'detail' => URL::route('bookings.detail', ['show_event_id' => $item->event_id]),
                        'create' => URL::route('bookings.create', ['show_id' => $request->show_id, 'show_event_id' => $item->event_id])
                    ];
                }),
            'createLink' => URL::route('bookings.create')
        ]);
    }

    /**
     * showing booking detail
     * @param int $show_event_id
     * @return Response
     */
    public function detail(int $show_event_id): Response
    {
        Log::info("Returning booking details for event with id {$show_event_id}...");
        return Inertia::render('Bookings/Detail', [
            'bookings' => Booking::where('show_event_id', '=', $show_event_id)
                ->get()
                ->map(function (Booking $booking) {
                    return [
                        'id' => $booking->event_id,
                        'customer' => collect(['id' => $booking->customer->id, 'name' => $booking->customer->full_name]),
                        'code' => $booking->full_place,
                        'created_at' => $booking->created_at->format('d/m/Y'),
                        'edit' => URL::route('bookings.edit', $booking->id)
                    ];
                }),
            'show' => ShowEvent::where('id', '=', $show_event_id)->with(['show' => function ($query) {
                return $query->select('id', 'title');
            }])->first()->show,
            'createLink' => URL::route('bookings.create')
        ]);
    }

    /**
     * show the places map
     * @param int $id the show event id
     * @param Request $request
     * @return Response
     */
    public function edit(int $id, Request $request): Response
    {
        $isAddingPlaces = $request->has('addPlace') && $request->addPlace;
        $booking = Booking::findOrFail($id);
        $showEvent = ShowEvent::findOrFail($booking->show_event_id);
        $bookingsCollection = Booking::select(['id', 'customer_id', 'place_number', 'row_letter'])
            ->where([
                ['show_event_id', '=', $booking->show_event_id],
            ])
            ->get()
            ->groupBy('row_letter')

            // ->map(function ($groupedBooking) {
            //     return [
            //         'id' => $groupedBooking->id,
            //         'customer_id' => $groupedBooking->customer_id,
            //         'place' => $groupedBooking->place_number
            //     ];
            // })

            ->toArray();


        return Inertia::render(
            'Bookings/Form',
            [
                'bookings' => $bookingsCollection,
                'customerBooking' => Booking::where('id', '=', $id)->with(['customer' => function ($query) {
                    return $query->select(['last_name', 'first_name', 'id']);
                }])->get()->first(),
                'show' => [
                    'id' => $id,
                    'title' => $showEvent->show->title,
                    'date' => Carbon::createFromTimeString($showEvent->show_date)->format('l d F Y - H:i')
                ],
                'customers' => Customer::all()
                    ->keyBy('id')
                    ->map(function (Customer $customer) {
                        return [
                            'id' => $customer->id,
                            'name' => $customer->full_name
                        ];
                    }),
                'addPlace' => $isAddingPlaces,
                '_method' => 'put',
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $showFromRequest = Show::where('id', $request->get('show_id'))->select(['id', 'title'])->get()->toArray()[0];
        $showEventFromRequest = ShowEvent::where('id', $request->get('show_event_id'))->select(['id', 'show_date'])->get()->toArray()[0];

        return Inertia::render(
            'Bookings/Create', [
                'show' => $showFromRequest,
                'customers' => Customer::all()
                    ->map(function (Customer $customer) {
                        return [
                            'id' => $customer->id,
                            'name' => $customer->full_name
                        ];
                    }),
                'show_event' => collect([
                    'id' => $showEventFromRequest['id'],
                    'date' => Carbon::createFromTimeString($showEventFromRequest['show_date'])->format('l d F Y - H:i')
                ]),
                '_method' => 'POST']
        );
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'place' => 'required',
            'row' => 'required',
            'customer_id' => 'required|exists:customers,id',
            'show_event_id' => 'required|exists:show_events,id',
        ]);

        try {
            $booking = Booking::where([
                ['customer_id', '=', $request->customer_id],
                ['show_event_id', '=', $request->show_event_id]])
                ->firstOrFail();
        } catch (\Exception $exception) {
            Log::error("Cannot update booking: {$exception->getMessage()}");
            return Redirect::back()->with('error', "Errori nella richiesta");
        }

        $booking->update([
            'place_number' => $request->place,
            'row_letter' => $request->row
        ]);

        return Redirect::back()->with('success', 'Dati Modificati correttamente');
    }

    /**
     * save booking
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'show_event_id' => 'required',
        ]);

        try {
            $booking = Booking::create([
                'customer_id' => $request->customer_id,
                'show_event_id' => $request->show_event_id,
                'booking_code' => strtoupper(Str::random(8)),
                'place_number' => $request->place,
                'row_letter' => $request->row,
                'number_of_places' => 1
            ]);
        } catch (\Exception $ex) {
            Log::error("Cannot save booking: {$ex->getMessage()}");
            return Redirect::back()->with('error', 'Invalid data');
        }
        if (!$request->row || !$request->place) {
            //request is coming from form not from map, should redirect to update
            return Redirect::to('bookings/' . $booking->id . '/edit');
        }
        return Redirect::back()->with('success', 'Dati Modificati correttamente');
    }

    /**
     * @param $code
     * @return bool|RedirectResponse|\Illuminate\Routing\Redirector
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
}
