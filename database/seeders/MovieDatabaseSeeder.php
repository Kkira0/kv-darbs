<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class MovieDatabaseSeeder extends Seeder
{
    private const API_KEY = '1a48de70587f1cb8090b3156f747b2f1';
    private const TOTAL_PAGES = 30;

    public function run(): void
    {
        $this->command->info('🎬 Starting TMDB import...');

        $genres = $this->fetchGenres();
        $this->insertGenres($genres);

        $movies = $this->fetchMovies();
        $this->insertMovies($movies);

        $this->command->info('✅ Import completed successfully!');
    }

    private function fetchGenres(): array
    {
        $response = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
            'api_key' => self::API_KEY,
            'language' => 'en-US',
        ]);

        if ($response->failed()) {
            throw new \Exception("Failed to fetch genres: " . $response->body());
        }

        return $response->json('genres') ?? [];
    }

    private function fetchMovies(): array
    {
        $allMovies = [];

        for ($page = 1; $page <= self::TOTAL_PAGES; $page++) {
            $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
                'api_key' => self::API_KEY,
                'language' => 'en-US',
                'page' => $page,
            ]);

            if ($response->failed()) {
                throw new \Exception("Failed to fetch movies on page {$page}");
            }

            $results = $response->json('results') ?? [];
            $allMovies = array_merge($allMovies, $results);
        }

        return $allMovies;
    }

    private function insertGenres(array $genres): void
    {
        $this->command->info('🧩 Inserting genres...');

        foreach ($genres as $g) {
            DB::table('genre')->updateOrInsert(
                ['id' => $g['id']],
                ['name' => $g['name']]
            );
        }
    }

    private function insertMovies(array $movies): void
    {
        $this->command->info('🎞️ Inserting movies...');

        foreach ($movies as $m) {

            $releaseDate = (!empty($m['release_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $m['release_date']))
                ? $m['release_date']
                : null;

            DB::table('movie')->updateOrInsert(
                ['id' => $m['id']],
                [
                    'adult' => $m['adult'] ?? 0,
                    'title' => $m['title'] ?? '',
                    'original_title' => $m['original_title'] ?? '',
                    'original_language' => $m['original_language'] ?? '',
                    'description' => $m['overview'] ?? '',
                    'release_date' => $releaseDate,
                    'vote_average' => $m['vote_average'] ?? 0,
                    'poster_path' => $m['poster_path'] ?? null,
                ]
            );

            if (!empty($m['genre_ids'])) {
                foreach ($m['genre_ids'] as $gid) {
                    DB::table('movie_genre')->updateOrInsert(
                        ['movie_id' => $m['id'], 'genres_id' => $gid],
                        []
                    );
                }
            }
        }
    }
}
