<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public $timestamps = false;

    protected $fillable = [
        'name_country',
        'status_country',
    ];

    public function movieVariants()
    {
        return $this->hasMany(MovieVariant::class, 'country_id');
    }
}
