<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }

    public function tvshows()
    {
        return $this->belongsToMany('App\TVShow', 'tvshow_id', 'genre_id');
    }
}
