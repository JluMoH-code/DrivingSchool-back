<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Slot;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('driving_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('score')->nullable();
            $table->string('status')->default('reservation');
            $table->foreignIdFor(Slot::class)->onDelete('cascade');
            $table->foreignIdFor(User::class, 'student_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driving_sessions');
    }
};
