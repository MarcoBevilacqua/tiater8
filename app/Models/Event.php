<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Event
 *
 * @property integer $id
 * @property integer $show_id
 * @property string $show_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $full_price_qnt
 * @property boolean $half_price_qnt
 * @property boolean $total_qnt
 * @method static \Illuminate\Database\Query\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event whereShowId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event whereShowDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event whereFullPriceQnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event whereHalfPriceQnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event whereTotalQnt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use HasFactory, Notifiable;

    public function getShowDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format("d-m-Y H:i");
    }
}
