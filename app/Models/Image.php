<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $table='images';
    protected $fillable=['movie_id','image'];

    public function movie()
    {
        return $this->belongsTo('App\Movie');
    }
}
