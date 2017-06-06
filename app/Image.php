<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Image extends Model
{
    use SoftDeletes;

    public function post()
    {
        return $this->belongsTo('\App\Post');
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function comments()
    {
        return $this->morphMany('\App\Comment', 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany('\App\Tag', 'tagable');
    }
    public function logs()
    {
       return $this->morphMany('App\Log', 'logable');
    }
    public static function modelRoute()
    {
        return 'image';
    }

    //
}
