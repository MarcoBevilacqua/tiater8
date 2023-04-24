<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subscription_email' => 'example@example.com',
            'token' => 'abc123',
            'expires_at' => Carbon::now()->addHour(),
            'year_from' => '2021',
            'year_to' => '2022',
        ];
    }

    /**
     * A pending subscription
     *
     * @return array
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Subscription::PENDING
            ];
        });
    }

    /**
     * A pending subscription
     *
     * @return array
     */
    public function toBeCompleted()
    {
        $years = SubscriptionService::getSubscriptionYears();
        return $this->state(function (array $attributes) use ($years) {
            return [
                'status' => Subscription::TO_BE_COMPLETED,
                'expires_at' => Carbon::now()->addHour(),
                'year_from' => $years['from'],
                'year_to' => $years['to'],
            ];
        });
    }

    /**
     * A subscription to be confirmed
     *
     * @return array
     */
    public function toBeConfirmed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Subscription::TO_BE_CONFIRMED,
                'year_from' => '2021',
                'year_to' => '2022',
            ];
        });
    }
}
