<?php

namespace App\Models;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Viewer
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $quota
 * @property string $sign_date
 * @property string $phone
 * @property string $full_name
 * @method static \Illuminate\Database\Query\Builder|\App\Viewer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Viewer whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Viewer whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Viewer whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Viewer whereQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Viewer whereSignDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Viewer wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Viewer whereFullName($value)
 * @mixin \Eloquent
 */
class Viewer extends Model
{
    use SoftDeletes, HasFactory;

    public $timestamps = false;
    protected $dates = ['deleted_at'];

    public function user(){
        $this->belongsTo(User::class);
    }

    public function showEvent(){
        $this->belongsTo(ShowEvent::class);
    }

    public function hasBookings(){

        $usersBookingIds = Booking::where('viewer_id', '=', $this->id)->get();

        $collection = $usersBookingIds->filter(function($booking) {
            return $booking->event->show_date >= Carbon::now();
        });

        return $collection;
    }
}
