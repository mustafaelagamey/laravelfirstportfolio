<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;


    //
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function logs()
    {
        return $this->morphMany('App\Log', 'logable');
    }

    public static function modelRoute()
    {
        return 'comment';
    }






}
