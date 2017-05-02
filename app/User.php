<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

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
        return $this->belongsToMany('App\Organization', 'user_organizations', 'user_id', 'organization_id');
    }

    /**
     * 用户所有的project
     * @return [type] [description]
     */
    public function projects()
    {
        return $this->belongsToMany('App\Projects', 'user_projects', 'user_id', 'project_id');
    }

    protected $nowOrg = NULL;

    public function getNowOrg()
    {
        if($this->nowOrg == NULL){
            if ($this->organization->count() > 0) {
                $this->nowOrg = $this->organization->first();
            } else {
                $this->nowOrg = new Organization;
                $this->nowOrg->name = "";
            }
        }
        return $this->nowOrg;
    }
    public function setNowOrg($org)
    {
        $this->nowOrg = $org;
    }

    public function task()
    {
        return $this->belongsToMany('App\Task', 'user_tasks', 'user_id', 'task_id');
    }
    /**
     * 所有评论
     * @return [type] [description]
     */
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at');
    }
}
