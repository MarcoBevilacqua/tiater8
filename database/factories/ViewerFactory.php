<?php

namespace Database\Factories;

use App\Models\ShowEvent;
use App\Models\User;
use App\Models\Viewer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViewerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Viewer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'event_id' => ShowEvent::factory(),
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'email' => $this->faker->email
        ];
    }
}
