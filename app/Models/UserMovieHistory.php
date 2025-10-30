<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMovieHistory extends Model
{
    protected $table = 'user_movie_history';
    public $timestamps = false;

    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'users_id',
        'movie_id',
        'watched',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
