<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'name',
        'known_for_department',
        'popularity',
        'profile_path',
    ];

    public function movies()
    {
        return $this->belongsToMany(
            Movie::class,
            'movie_person',
            'person_id',
            'movie_id'
        )->withPivot('role', 'character')->withTimestamps();
    }
}
