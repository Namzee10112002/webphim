<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchList extends Model
{
    protected $table = 'watch_lists';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'movie_detail_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movieDetail()
    {
        return $this->belongsTo(MovieDetail::class, 'movie_detail_id');
    }
}
