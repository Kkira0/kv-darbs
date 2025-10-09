<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    protected $table = 'movie_genre';
    public $timestamps = false;

    protected $fillable = [
        'movie_id',
        'genres_id'
    ];
}
