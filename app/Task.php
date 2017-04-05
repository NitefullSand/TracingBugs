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

    public function users()
    {
    	$user_table = DB::select('select users.id, users.name, user_tasks.task_id, user_tasks.role from users join user_tasks on users.id=user_tasks.user_id where user_tasks.task_id=?;', [$this->id]);
    	$users = collect($user_table);
    	return $users;
    }

    public function creater()
    {
    	$creater_name = DB::select('select name from users where id = ( select user_id from user_tasks where (task_id=? and role="创建者"));', [$this->id]);
    	return $creater_name[0]->name;
    }
}
