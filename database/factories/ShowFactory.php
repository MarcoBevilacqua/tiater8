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
        return [
            'title'             => $this->faker->words(mt_rand(1, 3), true),
            'description'       => $this->faker->realText(),
            'places'            => $this->faker->numberBetween(0, 50),
            'full_price'        => $this->faker->randomFloat(0, 1, 12),
            'half_price'        => $this->faker->randomFloat(0, 1, 6),
            'image'             => $this->faker->imageUrl(480, 640),
            'url'               => $this->faker->url
        ];
    }
}
