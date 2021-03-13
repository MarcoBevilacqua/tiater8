<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 28/09/2016
 * Time: 17:50
 */

$factory->define(\App\Booking::class, function(\Faker\Generator $faker){

    $show = App\Show::all()->random(1);
    $event = App\ShowEvent::whereShowId($show->id)->inRandomOrder()->take(1)->get();
    $viewer = App\Viewer::all()->random(1);
    Log::debug("ShowEvent: {$event}");

    $int = $faker->numberBetween(1,4);
    $half = $faker->numberBetween(1,4);
    $tot = $int + $half;

    return [

        'viewer_id'         => $viewer->id,
        'show_id'           => $show->id,
        'event_id'          => $event[0]->id,
        'paid'              => $faker->randomElement(array(0, 1)),
        'full_price_qnt'    => $int,
        'half_price_qnt'    => $half,
        'total_qnt'         => $tot,
        'booking_date'      => $faker->dateTimeThisYear,
        'place_code'        => strtoupper($faker->randomDigit.$faker->randomLetter),
        'booking_code'      => $faker->sha1,
        'public_code'       => strtoupper(md5(uniqid(rand(), true)))
        
    ];
    
});