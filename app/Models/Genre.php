<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genre';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name'
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_genre', 'genres_id', 'movie_id');
    }
}
