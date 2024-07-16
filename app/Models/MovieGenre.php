<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    use HasFactory;
    public $table = 'movie_genre';
    public $timestamps = false;

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
