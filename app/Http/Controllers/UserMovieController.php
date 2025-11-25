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
            return response()->json(['message' => 'Filma jau ir atzīmēta kā noskatīta.']);
        }

        UserMovieHistory::create([
            'users_id' => $user->id,
            'movie_id' => $request->movie_id,
            'watched' => true,
        ]);

        return redirect()->back()->with('success', 'Filma veiksmīgi atzīmēta kā noskatīta!');

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
            return redirect()->back()->with('error', 'Šī filma nav atzīmēta kā noskatīta.');
        }

        return redirect()->back()->with('success', 'Filma veiksmīgi noņemta no redzēto saraksta.');
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
                ? 'Pievienots plānā skatīties!'
                : 'Noņemts no plāna skatīties.'
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
            return redirect()->back()->with('error', 'Šī filma nav plānā skatīties.');
        }

        $entry->update([
            'plan_to_watch' => false,
            'watched'       => true,
        ]);

        return redirect()->back()->with('success', 'Filma pārvietota no plāna skatīties uz noskatītajām!');
    }

}
