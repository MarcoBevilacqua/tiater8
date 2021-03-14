<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 * @property int $full_price_qnt
 * @property int $half_price_qnt
 * @property int $total_qnt
 * @property-read int|null $events_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|Show newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Show newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Show query()
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereFullPriceQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereHalfPriceQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Show whereTotalQnt($value)
 */
	class Show extends \Eloquent {}
}

namespace App\Models{
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
 * @property int $full_price
 * @property int $half_price
 * @method static \Illuminate\Database\Eloquent\Builder|ShowEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShowEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShowEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShowEvent whereFullPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShowEvent whereHalfPrice($value)
 */
	class ShowEvent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
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
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Viewer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Viewer newQuery()
 * @method static \Illuminate\Database\Query\Builder|Viewer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Viewer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Viewer whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Viewer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Viewer withoutTrashed()
 */
	class Viewer extends \Eloquent {}
}

