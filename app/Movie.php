<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Genre;
use App\Actor;

class Movie extends Model
{
    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'movie_genre');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actor');
    }

    public function description()
    {
        return $this->hasMany(MovieDescription::class, 'movie_id');
    }

    protected $fillable = [
        'title','description','image_url','rating','release_year','gross_profit','director',
    ];

    public $timestamps = false;
}
