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
                ->where([['show_events.show_id', '=', $request->show_id],
                    ['show_date', '>=', now()]])
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
        Log::info("Returning booking map for event with id {$show_event_id}...");
        $showEvent = ShowEvent::findOrFail($show_event_id);
        $bookingsCollection = Booking::select(['id', 'customer_id', 'place_number', 'row_letter'])
            ->where('show_event_id', '=', $show_event_id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'customer' => Customer::select(['id', 'first_name', 'last_name'])->where('id', '=', $item->customer_id)->get()[0],
                    'place_number' => $item->place_number,
                    'row_letter' => $item->row_letter
                ];
            })
            ->groupBy('row_letter')
            ->toArray();


        return Inertia::render(
            'Bookings/Form',
            [
                'bookings' => $bookingsCollection,
                'customers' => Customer::all()->map(function (Customer $customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $customer->fullName
                    ];
                }),
                'show' => [
                    'id' => $showEvent->show->id,
                    'title' => $showEvent->show->title,
                    'date' => Carbon::createFromTimeString($showEvent->show_date)->format('l d F Y - H:i')
                ],
                /*                'customers' => Customer::all()
                                    ->keyBy('id')
                                    ->map(function (Customer $customer) {
                                        return [
                                            'id' => $customer->id,
                                            'name' => $customer->full_name
                                        ];
                                    }),*/
                'show_event' => $showEvent,
            ]
        );
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
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'customer' => Customer::select(['id', 'first_name', 'last_name'])->where('id', '=', $item->customer_id)->get()[0],
                    'place_number' => $item->place_number,
                    'row_letter' => $item->row_letter
                ];
            })
            ->groupBy('row_letter')
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
        $showEventFromRequest = ShowEvent::findOrFail($request->get('show_event_id'));

        return Inertia::render(
            'Bookings/Form', [
                'bookings' => [],
                'show' => [
                    'id' => $showEventFromRequest->show->id,
                    'title' => $showEventFromRequest->show->title,
                    'date' => Carbon::createFromTimeString($showEventFromRequest->show_date)->format('l d F Y - H:i')
                ],
                'customers' => Customer::all()
                    ->map(function (Customer $customer) {
                        return [
                            'id' => $customer->id,
                            'name' => $customer->full_name
                        ];
                    }),
                'show_event' => $showEventFromRequest,
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
            $booking = Booking::where('id', '=', $request->id)
                ->firstOrFail();
        } catch (\Exception $exception) {
            Log::error("Cannot update booking: {$exception->getMessage()}");
            return Redirect::back()->with('error', "Errori nella richiesta");
        }

        Log::info("Updating booking with ID {$booking->id}: from place {$booking->row_letter}{$booking->place_number} to {$request->row}{$request->place}");
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
        return Redirect::route('bookings.detail', ['show_event_id' => $request->show_event_id])->with('success', 'Dati Modificati correttamente');
    }

    /**
     * @param Booking $booking
     * @return RedirectResponse
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        try {
            $booking->delete();
        } catch (\Exception $ex) {
            Log::alert("Cannot delete booking: {$ex->getMessage()}");
            Redirect::back()->with('error', 'Error while deleting booking');
        }

        return Redirect::back();
    }
}
