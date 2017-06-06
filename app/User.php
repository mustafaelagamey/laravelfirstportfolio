<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo('\App\Role');
    }

    public function hasAccess($access)
    {

        if (is_array($access)) {
            foreach ($access as $accessItem)
                foreach ($this->role->privileges as $item)
                    if ($item->access == $accessItem) return true;
        } else
            foreach ($this->role->privileges as $item) {
                if ($item->access == $access) {
                    return true;
                }
            }
        return (false);
    }


    public function writtenPosts()
    {
        return $this->hasMany('\App\Post', 'writer_id');
    }

    public function updatedPosts()
    {
        return $this->hasMany('\App\Post', 'updater_id');
    }

    public function uploadedImages()
    {
        return $this->hasMany('\App\Image');
    }

    public function comments()
    {
        return $this->hasMany('\App\Comment');
    }

    public function tags()
    {
        return $this->hasMany('\App\Tag');
    }
    public function logs()
    {
        return $this->morphMany('App\Log', 'logable');
    }

    public function ownLogs()
    {
        return $this->hasMany('App\Log');
    }
    public static function modelRoute()
    {
        return 'user';
    }

}
