<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_movie_history', function (Blueprint $table) {
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('movie_id');
            $table->boolean('watched')->default(false);
            $table->tinyInteger('rating')->nullable();

            $table->primary(['users_id', 'movie_id']);

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movie')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_movie_history');
    }
};
