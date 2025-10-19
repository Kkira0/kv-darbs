<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    public function generate(Request $request)
    {
        $data = $request->validate([
            'genre'  => ['array'],
            'rating' => ['array'],
            'year'   => ['array'],
        ]);

        $genres  = $data['genre']  ?? [];
        $ratings = $data['rating'] ?? [];
        $years   = $data['year']   ?? [];

        $query = Movie::query()->with('genres');

        if (!empty($genres) && !in_array('Any', $genres)) {
            foreach ($genres as $genre) {
                $query->whereHas('genres', fn($q) => $q->where('name', $genre));
            }
        }

        if (!empty($ratings) && !in_array('Any', $ratings)) {
            $query->where(function ($q) use ($ratings) {
                foreach ($ratings as $rating) {
                    match (true) {
                        str_contains($rating, '9')       => $q->orWhere('vote_average', '>=', 9),
                        str_contains($rating, '8')       => $q->orWhereBetween('vote_average', [8, 8.99]),
                        str_contains($rating, '7')       => $q->orWhereBetween('vote_average', [7, 7.99]),
                        str_contains($rating, '6+')      => $q->orWhereBetween('vote_average', [6, 6.99]),
                        str_contains($rating, 'Below 6') => $q->orWhere('vote_average', '<', 6),
                        default                          => null,
                    };
                }
            });
        }

        if (!empty($years) && !in_array('Any', $years)) {
            $query->where(function ($q) use ($years) {
                foreach ($years as $year) {
                    if ($year === 'Before 2018') {
                        $q->orWhereYear('release_date', '<', 2018);
                    } else {
                        $q->orWhereYear('release_date', $year);
                    }
                }
            });
        }

        $movies = $query->get();

        if ($movies->isEmpty()) {
            return response()->json(['error' => 'No movies found matching all filters.'], Response::HTTP_NOT_FOUND);
        }

        $movie = $movies->random();

        return response()->json($movie, Response::HTTP_OK);
    }
}
