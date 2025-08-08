<?php

namespace Database\Factories;

use App\Enums\DrivingSessionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DrivingSession>
 */
class DrivingSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'score' => $this->faker->numberBetween(0, 5),
            'status' => $this->faker->randomElement(DrivingSessionStatus::values()),
        ];
    }
}
