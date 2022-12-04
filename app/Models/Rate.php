<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    //
    protected $fillable = [
        'rate', 'movie_id', 'user_id'
    ];
}
