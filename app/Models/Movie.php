<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movie';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'adult',
        'title',
        'original_title',
        'original_language',
        'description',
        'release_date',
        'vote_average',
        'poster_path'
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genres_id');
    }

    public function watchedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_movie_history', 'movie_id', 'users_id')
                    ->withPivot('watched', 'plan_to_watch', 'preference');
    }

    public function people()
    {
        return $this->belongsToMany(
            People::class,
            'movie_person',
            'movie_id',
            'person_id'
        )->withPivot('role', 'character')->withTimestamps();
    }

        public function actors()
    {
        return $this->people()->wherePivot('role', 'Actor');
    }

    public function crew()
    {
        return $this->people()->wherePivot('role', '<>', 'Actor');
    }

}