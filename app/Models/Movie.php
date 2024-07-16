<?php

namespace App\Models;

use App\Models\MovieGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
