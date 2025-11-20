    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('movie_genre', function (Blueprint $table) {
                $table->unsignedBigInteger('movie_id');
                $table->unsignedBigInteger('genres_id');

                $table->primary(['movie_id', 'genres_id']);

                $table->foreign('movie_id')->references('id')->on('movie')->onDelete('cascade');
                $table->foreign('genres_id')->references('id')->on('genre')->onDelete('cascade');
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('movie_genre');
        }
    };
