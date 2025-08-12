<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';
    public $timestamps = false;

    protected $fillable = [
        'name_movie',
        'image_movie',
        'description',
        'director',
        'actor',
        'duration',
        'year_release',
        'is_series',
        'clicks',
        'likes',
        'status_movie',
    ];

     public static function getLatestActive($limit = 10)
    {
        return self::with(['genres', 'countries'])
                    ->where('status_movie', 0)
                    ->orderBy('id', 'desc')
                    ->take($limit)
                    ->get();
    }
    public static function getMostView($limit = 10)
    {
        return self::with(['genres', 'countries'])
                    ->where('status_movie', 0)
                    ->orderBy('clicks', 'desc')
                    ->take($limit)
                    ->get();
    }

    public function movieDetails()
    {
        return $this->hasMany(MovieDetail::class, 'movie_id');
    }

    public function movieLikes()
    {
        return $this->hasMany(MovieLike::class, 'movie_id');
    }

    public function movieVariants()
    {
        return $this->hasMany(MovieVariant::class, 'movie_id');
    }


    // Lấy genres thông qua bảng movie_variant
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_variants', 'movie_id', 'genre_id');
    }

    // Lấy countries thông qua bảng movie_variant
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'movie_variants', 'movie_id', 'country_id');
    }
    public function comments()
{
    return $this->hasManyThrough(
        Comment::class,
        MovieDetail::class,
        'movie_id',         // Khóa ngoại trên bảng movie_details
        'movie_detail_id',  // Khóa ngoại trên bảng comments
        'id',               // Khóa chính của bảng movies
        'id'                // Khóa chính của bảng movie_details
    );
}

}
