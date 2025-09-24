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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('category'); // Prasejarah Indonesia, Kerajaan, Sejarah Nasional Indonesia, Kemerdekaan
            $table->string('subcategory')->nullable(); // Era Kolonialisme, Era perjuangan Kedaerahan, dll
            $table->string('sub_subcategory')->nullable(); // Portugis, Inggris, Perang Maluku, dll
            $table->integer('order_index')->default(0); // untuk urutan tampil
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
