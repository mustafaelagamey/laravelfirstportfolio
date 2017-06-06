<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    //
    public function roles(){
       return $this->belongsToMany('App\Role');

    }
    public function logs()
    {
        return  $this->morphMany('App\Log', 'logable');
    }
    public static function modelRoute()
    {
        return 'privilege';
    }

}
