<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\ShowEvent
 *
 * @property integer $id
 * @property integer $show_id
 * @property string $show_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $full_price_qnt
 * @property boolean $half_price_qnt
 * @property boolean $total_qnt
 * @method static \Illuminate\Database\Query\Builder|\App\ShowEvent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShowEvent whereShowId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShowEvent whereShowDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShowEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShowEvent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShowEvent whereFullPriceQnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShowEvent whereHalfPriceQnt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShowEvent whereTotalQnt($value)
 * @mixin \Eloquent
 */
class ShowEvent extends Model
{
    use HasFactory, Notifiable;

    public function show(){
        $this->belongsTo(Show::class);
    }
    
    public function getShowDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format("d-m-Y H:i");
    }

    /**
     * @return Show|Model|null
     */
    public function getShow()
    {
        return Show::first($this->id);
    }
}
