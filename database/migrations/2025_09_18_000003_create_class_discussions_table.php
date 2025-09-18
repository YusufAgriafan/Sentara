<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_discussions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('educator_id');
            $table->string('name');
            $table->text('class_discussion_message')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->text('message')->nullable();
            $table->text('reply')->nullable();
            $table->foreign('class_id')->references('id')->on('class')->onDelete('cascade');
            $table->foreign('educator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_discussions');
    }
};
