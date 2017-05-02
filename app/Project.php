<?php

namespace App;

use App\UserProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
	/**
	 * 项目属于某个组织
     * belongsTo
     * arg1: The model
     * arg2: The table
     * arg3: Foreign key
     * arg4: Local key
	 * @return The organization
	 */
    public function organization()
    {
    	return $this->belongsTo('App\Organization');
    }

    /**
     * project中的tasks
     * @return [type] [description]
     */
    public function tasks()
    {
        // 最新修改的排在前面
        return $this->hasMany('App\Task')->orderBy('updated_at', 'desc');
    }

    public function allUsers()
    {
        return $this->belongsToMany('App\User', 'user_projects', 'project_id', 'user_id')->orderBy('name');
    }

    /**
     * project中的普通成员
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_projects', 'project_id', 'user_id')->wherePivot('role', '成员')->withPivot('role', 'role')->withPivot('id', 'id')->orderBy('name');
    }

    /**
     * project中的管理员
     * @return [type] [description]
     */
    public function admins()
    {
        return $this->belongsToMany('App\User', 'user_projects', 'project_id', 'user_id')->wherePivot('role', '管理员')->withPivot('role', 'role')->withPivot('id', 'id')->orderBy('name');
    }

    /**
     * project的创建者
     * @return [type] [description]
     */
    public function creator()
    {
        return $this->belongsToMany('App\User', 'user_projects', 'project_id', 'user_id')->wherePivot('role', '创建者')->first();
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
     * 获得不在项目中的组织成员集合
     * @return collect 成员集合
     */
    public function orgOtherUsers()
    {
        // 将项目已有成员的user_id存入数组
        $proUsers = UserProject::All()->where('project_id', $this->id);
        $userArray = array();
        foreach ($proUsers as $proUser) {
            array_push($userArray, $proUser->user_id);
        }

        // 将组织中不在项目的成员加入otherUsers集合
        $otherUsers = collect();
        $orgAllUser = Auth::user()->getNowOrg()->allUsers;
        foreach ($orgAllUser as $user) {
            if(!in_array($user->id, $userArray)) {
                $otherUsers->push($user);
            }
        }
        return $otherUsers;
    }
}
