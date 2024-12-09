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
        Schema::create('result_quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_material')->references('id')->on('materials')->nullable();
            $table->unsignedBigInteger('id_user')->references('id')->on('users')->nullable();
            $table->integer('totalQuestion')->nullable();
            $table->integer('correctAnswers')->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_quizzes');
    }
};
