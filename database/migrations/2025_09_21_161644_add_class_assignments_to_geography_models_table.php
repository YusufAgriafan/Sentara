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
        Schema::table('geography_models', function (Blueprint $table) {
            $table->json('assigned_classes')->nullable()->after('educator_id');
            $table->boolean('is_public')->default(true)->after('assigned_classes');
            $table->text('detailed_description')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('geography_models', function (Blueprint $table) {
            $table->dropColumn(['assigned_classes', 'is_public', 'detailed_description']);
        });
    }
};
