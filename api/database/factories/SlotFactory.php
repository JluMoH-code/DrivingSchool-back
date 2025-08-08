<?php

namespace Database\Factories;

use App\Enums\SlotStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slot>
 */
class SlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $availableHours = [8, 10, 13, 15, 17];
        $date = $this->faker->dateTimeInInterval('now', '+5 days');

        return [
            'start_time' => Carbon::createFromTimestamp($date->getTimestamp())
                                ->startOfDay()
                                ->addHours($this->faker->randomElement($availableHours)),
            'status' => $this->faker->randomElement(SlotStatus::values()),
        ];
    }
}
