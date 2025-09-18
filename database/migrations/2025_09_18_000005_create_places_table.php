<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedBigInteger('coordinate_id');
            $table->string('location', 255);
            $table->enum('era', ['prasejarah', 'kerajaan', 'penjajahan', 'kemerdekaan']);
            $table->text('description')->nullable();
            $table->foreign('coordinate_id')->references('id')->on('coordinate')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
