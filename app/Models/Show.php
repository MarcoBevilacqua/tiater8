<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Show
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $places
 * @property float $full_price
 * @property float $half_price
 * @property string $image
 * @property string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ShowEvent[] $events
 * @method static \Illuminate\Database\Query\Builder|\App\Show whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Show whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Show whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Show wherePlaces($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Show whereFullPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Show whereHalfPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Show whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Show whereUrl($value)
 * @mixin \Eloquent
 */
class Show extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $fillable = ['name', 'description', 'places', 'full_price', 'image', 'half_price', 'url'];
    
    /**
     * has-many relationship with events table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events(){

        return $this->hasMany(ShowEvent::class);
    }

    /**
     * retrieve events from show
     * @return Collection
     */
    public function getEvents(){

        /** @var Collection $collection */
        $collection = $this->events->filter(function($event){
            if(strtotime($event->show_date) >= time()){
                return $event;
            }
        });

        return $collection;
    }
}
