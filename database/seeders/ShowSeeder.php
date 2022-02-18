<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Show;
use App\Models\ShowEvent;

class ShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Show::factory()
        ->count(5)->create();
        /*         ->each(function (Show $show){
                    $faker = \Faker\Factory::create();
                    for($i = 0; $i <= mt_rand(1,3); $i++){
                        $date = $faker->dateTimeBetween('-2 months', '+1 year');
                        //datetime
                        $hour = $faker->randomElement(['12', '18', '20', '21']);
                        $minute = $faker->randomElement(['00', '30', '45']);
                        //set Time
                        $date->setTime($hour, $minute, 0);
                        $fullPriceQnt = $faker->numberBetween(20, $show->full_price_qnt);
                        $halfPriceQnt = $faker->numberBetween(1, $show->half_price_qnt);
                        $totalQnt = $fullPriceQnt + $halfPriceQnt;
                        ShowEvent::factory()->create(
                            array(
                                'show_id'           => $show->id,
                                'show_date'         => $date,
                                'full_price_qnt'    => $fullPriceQnt,
                                'half_price_qnt'    => $halfPriceQnt,
                                'total_qnt'         => $totalQnt,
                                'full_price'        => $faker->randomFloat(0, 1, 12),
                                'half_price'        => $faker->randomFloat(0, 1, 6),
                            )
                        );
                    }
                }); */
    }
}
