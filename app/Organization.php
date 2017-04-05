<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	/**
	 * 多对多关系
     * belongsToMany
     * arg1: The model
     * arg2: The table
     * arg3: Foreign key
     * arg4: Local key
	 * @return Array user
	 */
    public function user()
    {
    	return $this->belongsToMany('App\User', 'user_organizations', 'organization_id', 'user_id');
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
