<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
	/**
	 * 该Task所属的project
	 * @return [type] [description]
	 */
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    /**
     * 该Task中的所有user
     * @return [type] [description]
     */
    public function users()
    {
        // 获取中间表字段role
        return $this->belongsToMany('App\User', 'user_tasks', 'task_id', 'user_id')->withPivot('role', 'role');
    }

    public function creator()
    {
        // 通过中间表字段过滤关联关系
    	$creator = $this->belongsToMany('App\User', 'user_tasks', 'task_id', 'user_id')->wherePivot('role', '创建者')->first();
    	return $creator;
    }

    public function developer()
    {
        $developer = $this->belongsToMany('App\User', 'user_tasks', 'task_id', 'user_id')->wherePivot('role', '开发负责人')->first();
        if($developer == null) {
            $developer = new User;
            $developer->name = '未指定';
        }
        return $developer;
    }

    public function tester()
    {
        $tester = $this->belongsToMany('App\User', 'user_tasks', 'task_id', 'user_id')->wherePivot('role', '测试负责人')->first();
        if($tester == null) {
            $tester = new User;
            $tester->name = '未指定';
        }
        return $tester;
    }

    /**
     * 该任务中的bug
     * @return [type] [description]
     */
    public function bugs()
    {
        return $this->hasMany('App\Bug');
    }
}
