<?php

namespace App;

use App\UserOrganization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Organization extends Model
{
    /**
     * 所有人员
     * @return [type] [description]
     */
    public function allUsers()
    {
        return $this->belongsToMany('App\User', 'user_organizations', 'organization_id', 'user_id')->orderBy('name');
    }

	/**
     * 普通成员 
	 * 多对多关系
     * belongsToMany
     * arg1: The model
     * arg2: The table
     * arg3: Foreign key
     * arg4: Local key
	 * @return Array users
	 */
    public function users()
    {
    	return $this->belongsToMany('App\User', 'user_organizations', 'organization_id', 'user_id')->wherePivot('role', '成员')->withPivot('role', 'role')->withPivot('id', 'id')->orderBy('name');
    }


    /**
     * organization中的管理员
     * @return [type] [description]
     */
    public function admins()
    {
        return $this->belongsToMany('App\User', 'user_organizations', 'organization_id', 'user_id')->wherePivot('role', '管理员')->withPivot('role', 'role')->withPivot('id', 'id')->orderBy('name');
    }

    /**
     * project的创建者
     * @return [type] [description]
     */
    public function creator()
    {
        return $this->belongsToMany('App\User', 'user_organizations', 'organization_id', 'user_id')->wherePivot('role', '创建者')->first();
    }

    public function isCreator()
    {
        if($this->creator()->id == Auth::user()->id) {
            return 1;
        }
        return 0;
    }

    /**
     * 是否是管理员
     * @return boolean 是/否
     */
    public function isAdmin()
    {
        if($this->admins->find(Auth::user()->id) != null) {
            return 1;
        }
        return 0;
    }

	/**
	 * 一对多关系
     * hasMany
     * arg1: The model
     * arg2: The table
     * arg3: Foreign key
     * arg4: Local key
	 * @return Array projects
	 */
    public function projects()
    {
    	return $this->hasMany('App\Project');
    }
}
