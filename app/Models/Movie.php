<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public $table = 'movies';

    public $timestamps = false;

    public function moviesGenre()
    {
        return $this->hasMany(MovieGenre::class);
    }
}
