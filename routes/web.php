<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;


Route::get('/', function () {
    return view('home');
});

Route::post('/generate-film', [MovieController::class, 'generate'])->name('generate.film');