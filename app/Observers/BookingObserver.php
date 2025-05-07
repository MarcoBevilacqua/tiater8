<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 10/01/2017
 * Time: 10:33
 */

namespace App\Observers;

use App\Models\Booking;
use App\Models\Show;
use App\Models\ShowEvent;
use Illuminate\Support\Facades\Log;

class BookingObserver
{
    /**
     *
     * TODO: cannot check place availability bc a user can only book one place at the time
     * @param Booking $booking
     * @throws \Exception
     *
     * @return bool
     */
    public function saving(Booking $booking): bool
    {
        Log::info("Trying to save booking: {$booking}");
        /** @var ShowEvent $showEvent */
        $showEvent = $booking->showEvent;

        /** @var Show $show */
        $show = $showEvent->show;

        if($show->places == 0) {
            Log::error(__METHOD__ . "|Event {$showEvent->id} has no free places for booking");
            return false;
        }

        Log::info(__METHOD__ . "|Show {$show->id} has still free places, Event {$showEvent->id} will take them");
        return true;
    }

    /**
     * TODO: cannot check place availability bc a user can only book one place at the time
     * @param Booking $booking
     */
    public function updating(Booking $booking) {

        //check if places has been changed
//        if(($booking->getOriginal('full_price_qnt') != $booking->full_price_qnt) ||
//            ($booking->getOriginal('half_price_qnt') != $booking->half_price_qnt)){
//
//            //remove places from show/event
//            $booking->showEvent()->show->decrementPlaces();
//        }
//
//        //check if event has enough places available
//        if(!$booking->showEvent()->show->places > 0) {
//            throw new \Exception("Show has no free places");
//        }
    }

    /**
     * @param Booking $booking
     * @throws \Exception
     */
    public function saved(Booking $booking): void
    {
        //remove places from event
        Log::info(__METHOD__ . "::Booking obj in observer: " . $booking->id);
        /** @var ShowEvent $showEvent */
        $showEvent = $booking->showEvent;
        /** @var Show $show */
        $show = $showEvent->show;
        // decrement
        $show->decrement('places');
    }
}
