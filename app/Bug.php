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
    public function creater()
    {
    	return $this->hasOne('App\User', 'id', 'creater');
    }

    /**
     * 关闭者
     * @return [type] [description]
     */
    public function closer()
    {
    	return $this->hasOne('App\User', 'id', 'closer');
    }
}
