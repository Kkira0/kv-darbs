<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function watchedMovies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'user_movie_history', 'users_id', 'movie_id')
                    ->withPivot('watched', 'plan_to_watch', 'preference');
    }

    public function movieHistory()
    {
        return $this->hasMany(UserMovieHistory::class, 'users_id');
    }

}
