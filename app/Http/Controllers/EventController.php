<?php

namespace App\Http\Controllers;

use Booking;
use App\ShowEvent;
use Show;
use Carbon\Carbon;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Log;

class EventController extends Controller
{

    /**
     * @param $id
     * @return bool
     */
    public function edit($id)
    {
        if (!$id) {
            return false;
        }
        
        $event = ShowEvent::find($id);
        $shows = Show::select(['id', 'name'])->get();
        
        return view('crud.eventi.edit', ['event' => $event, 'shows' => $shows]);
    }

    
    public function update($id, Request $request)
    {

        //validation
        $validator = \Validator::make($request->all(), [
            'show' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('event/create')
                ->withErrors($validator);
        }

        $data = $request->all();

        if (!$id) {
            return redirect('show');
        }

        $element = $data['data'][0];

        $formatted = $element . " " . $data['ora'][0] . ":" .
            (($data['minuti'][0] == "0") ? "00" : $data['minuti'][0]);

        /** @var Carbon $date */
        $date = Carbon::createFromFormat("d/m/Y H:i", $formatted);

        /** @var ShowShowEvent $event */
        $event = ShowShowEvent::findOrFail($id);

        /** @var \ShowShowEvent $event */
        $event->show_date = $date;
        $event->full_price_qnt = $data['full_price_qnt'];
        $event->half_price_qnt = $data['half_price_qnt'];
        $event->full_price = $data['full_price'];
        $event->half_price = $data['half_price'];
        $event->total_qnt = $data['full_price_qnt'] + $data['half_price_qnt'];

        try {
            $event->save();

            if ($event->exists) {
                Log::info("Evento creato con ID: {$event->id}");
            }
        } catch (\Exception $ex) {
            Log::error("Cannot save event", $ex->getMessage());
            return response(array(
                'success' => false,
                'message' => "Cannot save event"
            ));
        }

        return redirect('show', 302, array(
            'success'   => true
        ));
    }
    
    /**
     * @param $id
     * @return bool|int
     */
    public function destroy($id)
    {
        if (!$id) {
            return false;
        }

        $deleted = ShowShowEvent::destroy($id);

        if ($deleted == 0) {
            return false;
        }

        return redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * add action function
     * @param Request $request
     * @return bool|Response
     */
    protected function store(Request $request)
    {
        //validation
        $validator = \Validator::make($request->all(), [
            'show'      => 'required|numeric',
            'data'      => 'required|array',
            'ora'       => 'required|array',
            'minuti'    => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect('event/create')
                ->withErrors($validator);
        }

        $duplicateValues = 0;
        $dateCounter = 0;

        //decode form
        $form = $request->all();

        //show ID
        $show_id = $form['show'];

        //full and half price
        $full_price = $form['full_price'];
        $half_price = $form['half_price'];

        //redirect
        $redirect = (array_key_exists('redirect', $form)) ? $form['redirect'] : 'event/create';

        foreach ($form['data'] as $element) {
            $formatted = $element." ".$form['ora'][$dateCounter].":".
                (($form['minuti'][$dateCounter] == "0") ? "00" : $form['minuti'][$dateCounter]);

            /** @var Carbon $date */
            $date = Carbon::createFromFormat("d/m/Y H:i", $formatted);

            if ($this->eventExists($show_id, $date)) {
                Log::debug("ShowEvent for show id {$show_id} and date {$date->format("d-m-Y H:i")} already exists, skipping");
                continue;
            }

            /** @var \ShowShowEvent $event */
            $event = new \ShowShowEvent();
            $event->show_id = $show_id;
            $event->show_date =  $date;
            $event->full_price_qnt = $full_price;
            $event->half_price_qnt = $half_price;
            $event->total_qnt = $full_price + $half_price;

            try {
                $event->save();

                if ($event->exists) {
                    Log::info("Evento creato con ID: {$event->id}");
                    $duplicateValues++;
                }
            } catch (\Exception $ex) {
                Log::error("Cannot save event", $ex->getMessage());
                return response(array(
                    'success'   => false,
                    'message'  => "Cannot save event"
                ));
            }
            ++$dateCounter;
        }

        return redirect(
            $redirect,
            302,
            array(
                'success'   => true,
                'elements'  => $duplicateValues
            )
        );
    }

    /**
     * @param Request $request
     * @return string
     */
    public function bookingList(Request $request)
    {
        $id = $request->get("id");
        if (!$id) {
            return false;
        }

        /** @var ShowEvent $event */
        $event = ShowEvent::findOrFail($id);
        $items = array();
        $labels = array(
            1 => '<label class="label label-success"><i class="fa fa-thumbs-up" /></label>',
            0 => '<label class="label label-danger"><i class="fa fa-thumbs-down" /></label>');

        $full_price = $event->full_price ? $event->full_price : $event->getShow()->full_price;
        $half_price = $event->half_price ? $event->half_price : $event->getShow()->half_price;

        $full_price_total = 0;
        $half_price_total = 0;

        if (!$id) {
            return view('bookConfirm');
        }

        $bookingsWithViewers = Booking::where('event_id', '=', $id)
            ->join('viewer', 'bookings.viewer_id', '=', 'viewer.id')
            ->get();

        if ($bookingsWithViewers->count() > 0) {
            Log::info("Found {$bookingsWithViewers->count()} bookings for event id");
        }

        foreach ($bookingsWithViewers as $booking) {
            $booking_full_price_total = $full_price * $booking->full_price_qnt;
            $booking_half_price_total = $half_price * $booking->half_price_qnt;

            //single booking total
            $total = $booking_full_price_total + $booking_half_price_total;

            //final totals
            $full_price_total += $booking_full_price_total;
            $half_price_total += $booking_half_price_total;

            $items[] = array(
                'public_code'       => $booking->public_code,
                'name'              => $booking->full_name,
                'email'             => $booking->email,
                'places'            => $booking->full_price_qnt + $booking->half_price_qnt,
                'full_price'        => $full_price,
                'half_price'        => $half_price,
                'full_price_qnt'    => $booking->full_price_qnt,
                'half_price_qnt'    => $booking->half_price_qnt,
                'qnt'               => $booking->total_qnt,
                'full_price_total'  => $booking_full_price_total,
                'half_price_total'  => $booking_half_price_total,
                'place_code'        => $booking->place_code,
                'paid'              => $labels[$booking->paid],
                'total'             => $total
            );
        }

        $data = array(
            'bookings' => $items,
            'totals' => array(
                'full_price_total' => $full_price_total,
                'half_price_total' => $half_price_total
                )
        );

        return json_encode($data);
    }

    /**
     * [async] events for show in add event page (grouped)
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forShow($id)
    {
        $ret = DB::table('events')
            ->where('events.show_id', '=', $id)
            ->select(DB::raw(
                '                
                COUNT(events.`id`) AS evs,
                SUM(events.full_price_qnt + events.half_price_qnt) AS qnt,
                (SELECT COUNT(b.id) FROM bookings b WHERE b.show_id = events.show_id) AS book'
            ))
            ->groupBy('events.show_id')
            ->get();

        return \Response::json($ret);
    }

    /**
     * [async] get events for show ID
     * @param $id
     * @return bool|Response
     */
    protected function forShowId($id)
    {
        if (!$id) {
            return false;
        }

        $res = \ShowShowEvent::where('show_id', $id)
            ->select(['show_date', 'id', 'full_price_qnt', 'half_price_qnt', 'total_qnt'])
            ->get();

        if (!$res) {
            return false;
        }

        return response($res);
    }

    /**
     * hp calendar filler
     * @param $month
     * @return mixed
     */
    protected function forMonth($month)
    {
        $events = \ShowShowEvent::whereRaw('MONTH(show_date) = ?', [$month])
            ->whereRaw('show_date >= NOW()')
            ->join('shows', 'show_id', '=', 'shows.id')
            ->select(['show_date', 'shows.name'])
            ->get();

        return $events;
    }

    /**
     * @param $showId
     * @param $date
     * @return bool
     */
    private function eventExists($showId, $date)
    {
        $event = ShowShowEvent::where('show_id', '=', $showId)
            ->where('show_date', '=', $date)
            ->first();

        if (!$event) {
            return false;
        }

        return $event->exists();
    }
}
