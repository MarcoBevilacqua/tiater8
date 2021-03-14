<?php

namespace Database\Factories;

use App\Models\Show;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Show::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(mt_rand(1, 3), true);
        $url = str_replace(" ", "-", $name);
        $url = str_replace(".", "", $url);
    
        $fullPriceQnt   = $this->faker->numberBetween(20, 60);
        $halfPriceQnt   = $this->faker->numberBetween(1, $fullPriceQnt);
        $totalQnt       = $fullPriceQnt + $halfPriceQnt;
    
        $image          = $this->faker->imageUrl(480, 640);

        return [
            'name'              => $name,
            'description'       => $this->faker->realText(),
            'places'            => $this->faker->numberBetween(0, 50),
            'full_price_qnt'    => $fullPriceQnt,
            'half_price_qnt'    => $halfPriceQnt,
            'total_qnt'         => $totalQnt,
            'full_price'        => $this->faker->randomFloat(0, 1, 12),
            'half_price'        => $this->faker->randomFloat(0, 1, 6),
            'image'             => $image,
            'url'               => strtolower($url)
        ];
    }
}
