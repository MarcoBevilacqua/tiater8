<?php

namespace Database\Factories;

use App\Models\Show;
use App\Models\ShowEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShowEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShowEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'show_id' => Show::factory(),
            'show_date' => $this->faker->date(),
            'full_price_qnt' => $this->faker->numberBetween(0,50),
            'half_price_qnt' => $this->faker->numberBetween(0,25),
            'total_qnt' => $this->faker->numberBetween(0,40),
            'full_price' => $this->faker->numberBetween(0,10),
            'half_price' => $this->faker->numberBetween(0,5)
        ];
    }
}
