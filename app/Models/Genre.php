<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';
    public $timestamps = false;

    protected $fillable = [
        'name_genre',
        'status_genre',
    ];

    public function movieVariants()
    {
        return $this->hasMany(MovieVariant::class, 'genre_id');
    }
}
