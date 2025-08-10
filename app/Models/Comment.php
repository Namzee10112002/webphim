<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'movie_detail_id',
        'content',
        'status_comment',
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
