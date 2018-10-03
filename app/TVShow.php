<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TVShow extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'tvshows';
    protected $guarded = [];

    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'genre_tvshow', 'tvshow_id', 'genre_id');
    }

    public function seasons()
    {
        return $this->hasMany('App\Season', 'tvshow_id');
    }
}
