<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieVariant extends Model
{
    protected $table = 'movie_variants';
    public $timestamps = false;

    protected $fillable = [
        'genre_id',
        'movie_id',
        'country_id',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
