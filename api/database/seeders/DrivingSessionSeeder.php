<?php

namespace Database\Seeders;

use App\Enums\SlotStatus;
use App\Enums\UserRole;
use App\Models\DrivingSession;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Database\Seeder;

class DrivingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student_ids = User::where('role', UserRole::STUDENT)->get('id');
        $slots = Slot::whereIn('status', [SlotStatus::RESERVATION, SlotStatus::COMPLETED])->get();
        foreach($slots as $slot) {
            DrivingSession::factory()->create([
                'slot_id' => $slot->id,
                'student_id' => fake()->randomElement($student_ids),
            ]);
        }
    }
}
