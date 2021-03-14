<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Show;
use App\Models\ShowEvent;
use App\Models\Viewer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Log;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $show = Show::inRandomOrder()->first();        
        $event = ShowEvent::whereShowId($show->id)->inRandomOrder()->take(1)->get();
        $viewer = Viewer::inRandomOrder()->first();
        Log::debug("ShowEvent: {$event}");
        
        $int = $this->faker->numberBetween(1,4);
        $half = $this->faker->numberBetween(1,4);
        $tot = $int + $half;
    
        return [
    
            'viewer_id'         => $viewer->id,
            // 'show_id'           => $show->id,
            //'event_id'          => $event[0]->id,
            'paid'              => $this->faker->randomElement(["0", "1"]),
            'full_price_qnt'    => $int,
            'half_price_qnt'    => $half,
            'total_qnt'         => $tot,
            'booking_date'      => $this->faker->dateTimeThisYear,
            'place_code'        => strtoupper($this->faker->randomDigit.$this->faker->randomLetter),
            'booking_code'      => $this->faker->sha1,
            'public_code'       => $this->faker->randomNumber(5) 
        ];
    }
}
