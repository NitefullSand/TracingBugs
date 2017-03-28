<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 多对多关系
     * belongsToMany
     * arg1: The model
     * arg2: The table
     * arg3: Foreign key
     * arg4: Local key
     * @return Array organization
     */
    public function organization()
    {
        return $this->belongsToMany('App\Organizations', 'user_organizations', 'user_id', 'organization_id');
    }
}
