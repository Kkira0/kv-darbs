<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movie')->cascadeOnDelete();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->string('role')->nullable();
            $table->string('character')->nullable();
            $table->timestamps();
            $table->unique(['movie_id', 'person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_person');
    }
};
