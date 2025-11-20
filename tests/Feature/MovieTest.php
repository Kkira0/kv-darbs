<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_page_loads()
    {
        $response = $this->get(route('movies.catalog'));

        $response->assertStatus(200);
    }

    public function test_movie_show_page_displays_movie_details()
    {
        $movie = Movie::create([
            'adult' => 0,
            'title' => 'Test Movie',
            'original_title' => 'Original Test Movie',
            'original_language' => 'en',
            'description' => 'This is a test description',
            'release_date' => '2020-01-01',
            'vote_average' => 8.5,
            'poster_path' => '/test.jpg'
        ]);

        $response = $this->get("/movie/{$movie->id}");

        $response->assertStatus(200);
        $response->assertSee('Test Movie');
        $response->assertSee('This is a test description');
    }

}
