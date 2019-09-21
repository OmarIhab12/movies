<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieDescription extends Model
{
    protected $table = 'movies_descriptions';

    public function movie()
    {
      return $this->belongsTo('App\Movie', 'movie_id');
    }

    protected $fillable = [
        'locale','description',
    ];

    public $timestamps = false;
}
