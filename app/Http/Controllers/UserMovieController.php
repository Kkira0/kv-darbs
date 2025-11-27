<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMovieHistory;
use Illuminate\Support\Facades\Auth;

class UserMovieController extends Controller
{
    public function markWatched(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
        ]);

        $user = Auth::user();

        $existing = UserMovieHistory::where('users_id', $user->id)
            ->where('movie_id', $request->movie_id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'The movie has already been marked as watched.']);
        }

        UserMovieHistory::create([
            'users_id' => $user->id,
            'movie_id' => $request->movie_id,
            'watched' => true,
        ]);

        return redirect()->back()->with('success', 'The movie has been successfully marked as watched!');

    }

    public function unmarkWatched(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
        ]);

        $user = Auth::user();

        $deleted = UserMovieHistory::where('users_id', $user->id)
            ->where('movie_id', $request->movie_id)
            ->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'This movie is not marked as watched.');
        }

        return redirect()->back()->with('success', 'The movie has been successfully removed from the watched list.');
    }

    public function togglePlan(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
        ]);

        $user = Auth::user();

        $entry = UserMovieHistory::firstOrNew([
            'users_id' => $user->id,
            'movie_id' => $request->movie_id,
        ]);

        $entry->plan_to_watch = !$entry->plan_to_watch;

        $entry->save();

        return response()->json([
            'message' => $entry->plan_to_watch
                ? 'Added to the plan to watch!'
                : 'Removed from the plan to watch.'
        ]);


    }

    public function convertPlanToWatched(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $user = Auth::user();

        $entry = UserMovieHistory::where('id', $request->id)
            ->where('users_id', $user->id)
            ->first();

        if (!$entry || !$entry->plan_to_watch) {
            return redirect()->back()->with('error', 'This movie is not on the list to watch.');
        }

        $entry->update([
            'plan_to_watch' => false,
            'watched'       => true,
        ]);

        return redirect()->back()->with('success', 'The movie has been moved from planned to watched!');
    }

    public function setPreference(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
            'preference' => 'nullable|in:-1,1',
        ]);

        $user = Auth::user();

        $entry = UserMovieHistory::firstOrNew([
            'users_id' => $user->id,
            'movie_id' => $request->movie_id,
        ]);

        $entry->preference = $request->preference ?? 0;

        $entry->save();

        return response()->json([
            'message' => match($entry->preference) {
                1 => 'You liked this movie!',
                -1 => 'You disliked this movie!',
                default => 'No reaction set.',
            },
            'preference' => $entry->preference
        ]);
    }

}
