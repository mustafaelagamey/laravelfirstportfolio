<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;
    //
    public function posts()
    {
        return $this->morphedByMany('\App\Post', 'tagable');
    }

    public function images()
    {
        return $this->morphedByMany('\App\Image', 'tagable');
    }


    public function user(){
        return $this->belongsTo('\App\User');
    }public function logs()
{
    return  $this->morphMany('App\Log', 'logable');
}
    public static function modelRoute()
    {
        return 'tag';
    }

}
