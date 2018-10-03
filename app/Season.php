<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public function tvshow()
    {
        return $this->belongsTo('App\TVShow');
    }
}
