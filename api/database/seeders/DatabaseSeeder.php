<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create(['pernumber' => '100000000', 'role' => 'admin']);
        User::factory()->create(['pernumber' => '100000001', 'role' => 'instructor']);
        User::factory()->create(['pernumber' => '100000002', 'role' => 'student']);

        User::factory()->count(5)->create(['role' => 'instructor']);
        User::factory()->count(10)->create(['role' => 'student']);

        $this->call([
            InstructorSeeder::class,
            CarSeeder::class,
            SlotSeeder::class,
            DrivingSessionSeeder::class,
        ]);
    }
}
