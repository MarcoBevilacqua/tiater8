<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 28/09/2016
 * Time: 16:48
 */

$factory->define(\App\Show::class, function(Faker\Generator $faker){
    
    $name = $faker->words(mt_rand(1, 3), true);
    $url = str_replace(" ", "-", $name);
    $url = str_replace(".", "", $url);

    $fullPriceQnt   = $faker->numberBetween(20, 60);
    $halfPriceQnt   = $faker->numberBetween(1, $fullPriceQnt);
    $totalQnt       = $fullPriceQnt + $halfPriceQnt;

    $image          = $faker->image("public/img", 480, 640,"",  false);

    return [
        'name'              => $name,
        'description'       => $faker->realText(),
        'places'            => $faker->numberBetween(0, 50),
        'full_price_qnt'    => $fullPriceQnt,
        'half_price_qnt'    => $halfPriceQnt,
        'total_qnt'         => $totalQnt,
        'full_price'    => $faker->randomFloat(0, 1, 12),
        'half_price'    => $faker->randomFloat(0, 1, 6),
        'image'         => $image,
        'url'           => strtolower($url)
    ];

});