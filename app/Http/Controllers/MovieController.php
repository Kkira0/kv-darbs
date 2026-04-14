<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMovieHistory;
use App\Models\MoviePerson;

class MovieController extends Controller
{

    public function generateAuth(Request $request)
    {
        $user = Auth::user();

        $likedMovieIds = UserMovieHistory::where('users_id', $user->id)
            ->where('preference', 1)
            ->pluck('movie_id')
            ->toArray();

        if (count($likedMovieIds) < 2) {
            return $this->generate($request);
        }

        $favoritePeopleIds = MoviePerson::whereIn('movie_id', $likedMovieIds)
            ->whereHas('person', function ($q) {
                $q->whereIn('known_for_department', ['Acting', 'Directing']);
            })
            ->select('person_id')
            ->groupBy('person_id')
            ->limit(30)
            ->pluck('person_id')
            ->toArray();

        if (empty($favoritePeopleIds)) {
            return $this->generate($request);
        }

        $dislikedMovieIds = UserMovieHistory::where('users_id', $user->id)
            ->where('preference', -1)
            ->pluck('movie_id')
            ->toArray();

        $watchedMovieIds = UserMovieHistory::where('users_id', $user->id)
            ->where('watched', true)
            ->pluck('movie_id')
            ->toArray();

        $query = Movie::query();

        if (!empty($dislikedMovieIds)) {
            $query->whereNotIn('movie.id', $dislikedMovieIds);
        }

        if (!empty($watchedMovieIds)) {
            $query->whereNotIn('movie.id', $watchedMovieIds);
        }

        if (!empty($likedMovieIds)) {
            $query->whereNotIn('movie.id', $likedMovieIds);
        }

        $query->whereHas('people', function ($q) use ($favoritePeopleIds) {
            $q->whereIn('people.id', $favoritePeopleIds);
        });

        $movies = $query
            ->inRandomOrder()
            ->limit(20)
            ->get();

        if ($movies->isEmpty()) {
            return $this->generate($request);
        }

        $movie = $movies->random();

        return response()->json($movie->load('genres'));
    }

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

        if ($genres && !in_array('Any', $genres)) {
            foreach ($genres as $genre) {
                $query->whereHas('genres', function($q) use ($genre) {
                    $q->where('name', $genre);
                });
            }
        }

        if ($ratings && !in_array('Any', $ratings)) {
            $query->where(function ($q) use ($ratings) {
                foreach ($ratings as $rating) {
                    if ($rating == '9+ (Excellent)') {
                        $q->orWhere('vote_average', '>=', 9);
                    }

                    else if ($rating == '8+ (Great)') {
                        $q->orWhereBetween('vote_average', [8, 8.99]);
                    }

                    else if ($rating == '7+ (Good)') {
                        $q->orWhereBetween('vote_average', [7, 7.99]);
                    }

                    else if ($rating == '6+ (Average)') {
                        $q->orWhereBetween('vote_average', [6, 6.99]);
                    }

                    else if ($rating == 'Below 6 (Low Rated)') {
                        $q->orWhere('vote_average', '<', 6);
                    }

                }
            });
        }

        if ($years && !in_array('Any', $years)) {
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

    public function catalog()
    {
        $movies = Movie::all();

        return view('movies.catalog', compact('movies'));
    }

    public function show($id){
        $movie = Movie::with(['genres', 'actors', 'crew'])->findOrFail($id);
        return view('movies.show', compact('movie'));
    }
}
