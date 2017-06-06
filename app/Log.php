<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    //
    use SoftDeletes;
    public function logable(){
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function modelRoute()
    {
        return 'log';
    }

    public function logs()
    {
        return   $this->morphMany('App\Log', 'logable');
    }

}
