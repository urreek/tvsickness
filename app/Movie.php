<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }
}
