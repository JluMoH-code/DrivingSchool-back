<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\Slot;
use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = Instructor::all();

        foreach ($instructors as $instructor)
        {
            Slot::factory()->count(20)->create([
                'instructor_id' => $instructor->id,
                'car_id' => $instructor->activeCar()->id,
            ]);
        }

    }
}
