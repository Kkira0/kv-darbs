<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoviePerson extends Model
{
    use HasFactory;

    protected $table = 'movie_person';

    protected $fillable = [
        'movie_id',
        'person_id',
        'role',
        'character',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function person()
    {
        return $this->belongsTo(People::class, 'person_id');
    }
}
