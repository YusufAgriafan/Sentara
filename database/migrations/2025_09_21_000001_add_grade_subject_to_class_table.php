<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class', function (Blueprint $table) {
            $table->string('grade')->nullable()->after('name');
            $table->string('subject')->nullable()->after('grade');
        });
    }

    public function down(): void
    {
        Schema::table('class', function (Blueprint $table) {
            $table->dropColumn(['grade', 'subject']);
        });
    }
};