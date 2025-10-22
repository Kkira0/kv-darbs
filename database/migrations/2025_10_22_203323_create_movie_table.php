<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie', function (Blueprint $table) {
            $table->id();
            $table->boolean('adult')->default(false);
            $table->string('title', 255);
            $table->string('original_title', 255);
            $table->string('original_language', 10);
            $table->text('description')->nullable();
            $table->date('release_date')->nullable();
            $table->decimal('vote_average', 4, 2)->default(0);
            $table->string('poster_path', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie');
    }
};
