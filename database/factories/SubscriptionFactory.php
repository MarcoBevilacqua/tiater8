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
            'year_from' => now()->format('Y'),
            'year_to' => now()->addYear()->format('Y'),
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
     * @return SubscriptionFactory
     */
    public function toBeCompleted(): SubscriptionFactory
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
     * @return SubscriptionFactory
     */
    public function toBeConfirmed(): SubscriptionFactory
    {
        $years = SubscriptionService::getSubscriptionYears();
        return $this->state(function (array $attributes) use ($years) {
            return [
                'status' => Subscription::TO_BE_CONFIRMED,
                'year_from' => $years['from'],
                'year_to' => $years['to'],
            ];
        });
    }

    /**
     * A subscription that is expired bc is older than a year
     *
     * @return SubscriptionFactory
     */
    public function expired(): SubscriptionFactory
    {
        $years = SubscriptionService::getSubscriptionYears();
        return $this->state(function (array $attributes) use ($years) {
            return [
                'status' => Subscription::EXPIRED,
                'year_from' => $years['from'] - 1,
                'year_to' => $years['to'] - 1,
                'created_at' => now()->subYear()->subDays(7)
            ];
        });
    }
}
