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
        // Geography models and class table already have user tracking columns
        // We only need to add to class_discussions table
        
        // Add user tracking to class_discussions table
        Schema::table('class_discussions', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable()->after('student_id');
            $table->unsignedBigInteger('deleted_by')->nullable()->after('updated_by');
            
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_discussions', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
            $table->dropColumn(['updated_by', 'deleted_by', 'deleted_at']);
        });
    }
};
