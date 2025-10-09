<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanToWatch extends Model
{
    protected $table = 'plan_to_watch';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'movie_id'
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
