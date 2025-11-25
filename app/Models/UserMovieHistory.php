<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMovieHistory extends Model
{
    protected $table = 'user_movie_history';
    public $timestamps = false;

    protected $primaryKey = 'id'; 
    public $incrementing = true;  
    protected $keyType = 'int';  

    protected $fillable = [
        'users_id',
        'movie_id',
        'watched',
        'plan_to_watch',
        'preference'
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


