<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function users()
    {
        return $this->hasMany('App\User');
    }


    public function privileges()
    {
        return $this->belongsToMany('App\Privilege');

    }

    public function logs()
    {
        return $this->morphMany('App\Log', 'logable');
    }
    public static function modelRoute()
    {
        return 'role';
    }

}
