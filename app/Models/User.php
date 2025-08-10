<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'role',
        'status_user',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function movieLikes()
    {
        return $this->hasMany(MovieLike::class, 'user_id');
    }

    public function watchLists()
    {
        return $this->hasMany(WatchList::class, 'user_id');
    }
}
