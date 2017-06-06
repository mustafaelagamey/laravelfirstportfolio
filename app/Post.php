<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    //

    use SoftDeletes;

    public function writer()
    {
        return $this->belongsTo('\App\User','writer_id');
    }

    public function updater()
    {
        return $this->belongsTo('\App\User','updater_id');
    }

    public function image()
    {
        return $this->hasOne('\App\Image');
    }

    public function comments(){
      return  $this->morphMany('\App\Comment', 'commentable');
    }

    public function tags(){
      return  $this->morphToMany('\App\Tag', 'tagable');
    }

    public function logs()
    {
        return   $this->morphMany('App\Log', 'logable');
    }
    public static function modelRoute()
    {
        return 'post';
    }

}
