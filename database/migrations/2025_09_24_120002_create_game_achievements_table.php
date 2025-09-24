<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('achievement_type'); // completed_level, perfect_score, speed_run, etc.
            $table->string('achievement_name');
            $table->text('description')->nullable();
            $table->json('achievement_data')->nullable(); // Additional data for achievement
            $table->timestamps();
            
            $table->unique(['user_id', 'game_id', 'achievement_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_achievements');
    }
};