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
            'show_date' => $this->faker->dateTimeBetween('+0 days', '+2 years')
        ];
    }
}
