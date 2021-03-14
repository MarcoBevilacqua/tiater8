<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Booking
 *
 * @property integer $id
 * @property integer $viewer_id
 * @property string $paid
 * @property integer $full_price_qnt
 * @property integer $half_price_qnt
 * @property integer $total_qnt
 * @property string $booking_date
 * @property string $place_code
 * @property string $booking_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $public_code
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereViewerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereShowId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking wherePaid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereFullPriceQnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereHalfPriceQnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereTotalQnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereBookingDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking wherePlaceCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereBookingCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking wherePublicCode($value)
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use HasFactory, Notifiable;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function viewer(){
        return $this->belongsTo(Viewer::class);
    }

    /**
     * @param \App\ShowEvent $event
     * @param $places
     * @return bool
     * @throws \Exception
     */
    public function removePlacesFromEvent(ShowEvent $event, $places){

        try{
            $event->full_price_qnt -= $places['full_price_qnt'];
            $event->half_price_qnt -= $places['half_price_qnt'];
            $event->save();
        } catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }

        return true;
    }

    /**
     * @return int
     */
    private function getEventPlaceTotal()
    {
        return $this->getEvent()->getResults()->full_price_qnt +
            $this->getEvent()->getResults()->half_price_qnt;
    }

}
