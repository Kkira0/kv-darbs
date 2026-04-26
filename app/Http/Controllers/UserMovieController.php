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

        $entry = UserMovieHistory::firstOrNew([
            'users_id' => $user->id,
            'movie_id' => $request->movie_id,
        ]);

        if ($entry->watched) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Already marked as watched'
            ]);
        }

        $entry->watched = true;
        $entry->save();

        return response()->json([
            'status' => 'ok'
        ]);

    }

    public function unmarkWatched(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
        ]);

        $user = Auth::user();

        $entry = UserMovieHistory::where('users_id', $user->id)
            ->where('movie_id', $request->movie_id)
            ->first();

        if (!$entry || !$entry->watched) {
            return response()->json([
                'status' => 'error',
                'message' => 'Movie is not marked as watched'
            ]);
        }

        $entry->watched = false;
        $entry->save();

        return redirect()->route('profile');
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

        if ($entry->plan_to_watch) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Already in plan to watch'
            ]);
        }

        $entry->plan_to_watch = true;

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
            'preference' => 'nullable|in:-1,0,1',
        ]);

        $user = Auth::user();

        $entry = UserMovieHistory::firstOrNew([
            'users_id' => $user->id,
            'movie_id' => $request->movie_id,
        ]);

        if ($entry->preference == $request->preference) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Already set'
            ]);
        }

        $entry->preference = $request->preference ?? 0;

        $entry->save();

        return redirect()->back()->with('success', match($entry->preference) {
            1 => 'You liked this movie!',
            -1 => 'You disliked this movie!',
            default => 'Reaction removed.',
        });
    }

}
