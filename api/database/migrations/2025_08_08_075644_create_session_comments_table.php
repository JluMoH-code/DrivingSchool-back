<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\DrivingSession;
use App\Models\User;
use App\Models\SessionComment;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_comments', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->string('type');
            $table->foreignIdFor(DrivingSession::class)->onDelete('cascade');
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->foreignIdFor(SessionComment::class, 'parent_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_comments');
    }
};
