<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
