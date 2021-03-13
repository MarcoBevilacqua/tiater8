<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 10/01/2017
 * Time: 10:33
 */

namespace App\Observers;


use App\Booking;
use App\ShowEvent;
use Log;

class BookingObserver
{
    /**
     * @param Booking $booking
     * @throws \Exception
     */
    public function saving(Booking $booking){

        Log::info("Trying to save booking: {$booking}");
        if(!$booking->event->hasFreePlaces($booking)){
            Log::error(__METHOD__ . "|Event {$booking->getEvent} has no free places for booking");
            return false;
        }

        Log::info(__METHOD__ . "|Show {$booking->show_id} has still free places, Event {$booking->event_id} will take them");
        return true;
    }

    /**
     * @param Booking $booking
     * @throws \Exception
     */
    public function updating(Booking $booking){

        //check if places has been changed
        if(($booking->getOriginal('full_price_qnt') != $booking->full_price_qnt) ||
            ($booking->getOriginal('half_price_qnt') != $booking->half_price_qnt)){

            //remove places from show/event
            $booking->event()->getResults()->decrementPlaces($booking);
        }

        //check if event has enough places available
        if(!$booking->event()->getResults()->hasFreePlaces()){
            throw new \Exception("Show has no free places");
        }

    }

    /**
     * @param Booking $booking
     * @throws \Exception
     */
    public function saved(Booking $booking){
        //remove places from event
        Log::info(__METHOD__ . "::BOoking obj in observer: " . $booking->event()->getResults());
        $booking->event()->getResults()->decrementPlaces($booking);
    }

}