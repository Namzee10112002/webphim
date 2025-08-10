<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieDetail extends Model
{
    protected $table = 'movie_details';
    public $timestamps = false;

    protected $fillable = [
        'movie_id',
        'name_detail',
        'link',
        'orders',
        'description',
        'status_detail',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'movie_detail_id');
    }

    public function watchLists()
    {
        return $this->hasMany(WatchList::class, 'movie_detail_id');
    }
}
