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
        Schema::create('class_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('class')->onDelete('cascade');
            $table->foreignId('story_id')->constrained('stories')->onDelete('cascade');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();
            
            // Ensure unique combination
            $table->unique(['class_id', 'story_id']);
            
            // Add indexes for performance
            $table->index('class_id');
            $table->index('story_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_stories');
    }
};
