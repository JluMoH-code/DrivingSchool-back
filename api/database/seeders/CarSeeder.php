<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = Instructor::all();
        foreach ($instructors as $instructor) {
            Car::factory()->create(['instructor_id' => $instructor->id]);
        }
    }
}
