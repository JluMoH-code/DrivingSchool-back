<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', UserRole::INSTRUCTOR)->get();
        foreach ($users as $user) {
            Instructor::factory()->create(['user_id' => $user->id]);
        }
    }
}
