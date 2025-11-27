<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserMovieController;


Route::get('/', function () {
    return view('home');
});

Route::post('/generate-film', [MovieController::class, 'generate'])->name('generate.film');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/movie/mark-watched', [UserMovieController::class, 'markWatched'])->name('movie.markWatched');
    Route::delete('/movie/unmark-watched', [UserMovieController::class, 'unmarkWatched'])->name('movie.unmarkWatched');
    Route::post('/movie/toggle-plan', [UserMovieController::class, 'togglePlan'])->name('movie.togglePlan');
    Route::post('/movie/convert-plan-to-watched', [UserMovieController::class, 'convertPlanToWatched'])->name('movie.convertPlanToWatched');
    Route::post('/movie/set-preference', [UserMovieController::class, 'setPreference'])->name('movie.setPreference');

});

Route::get('/catalog', [MovieController::class, 'catalog'])->name('movies.catalog');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movies.show');

