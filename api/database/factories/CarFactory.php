<?php

namespace Database\Factories;

use App\Enums\Transmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = [
            'Toyota' => ['Corolla', 'Camry', 'RAV4'],
            'Hyundai' => ['Solaris', 'Elantra', 'Creta'],
            'Volkswagen' => ['Polo', 'Jetta', 'Golf'],
            'Lada' => ['Granta', 'Vesta', 'Kalina'],
            'Skoda' => ['Rapid', 'Octavia', 'Fabia'],
        ];

        $brand = array_rand($brands);
        $model = $this->faker->randomElement($brands[$brand]);

        $region = $this->faker->numberBetween(1, 999);
        $letters = $this->faker->randomElements(['А', 'В', 'Е', 'К', 'М', 'Н', 'О', 'Р', 'С', 'Т', 'У', 'Х'], 3);
        $numbers = str_pad($this->faker->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);

        $stateNumber = sprintf(
            '%s%s%s%s%s',
            $letters[0],
            $numbers,
            $letters[1],
            $letters[2],
            $region
        );

        return [
            'brand' => $brand,
            'model' => $model,
            'color' => $this->faker->colorName(),
            'state_number' => $stateNumber,
            'transmission' => $this->faker->randomElement(Transmission::values()),
        ];
    }
}
