<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
	/**
	 * 该bug所属task
	 * @return [type] [description]
	 */
    public function task()
    {
    	return $this->belongsTo('App\Task');
    }

    /**
     * 创建者
     * @return [type] [description]
     */
    public function creator()
    {
    	return $this->hasOne('App\User', 'id', 'creator_id');
    }

    /**
     * 执行者
     * @return [type] [description]
     */
    public function executor()
    {
    	return $this->hasOne('App\User', 'id', 'executor_id');
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
