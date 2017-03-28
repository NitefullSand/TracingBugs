<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrganization extends Model
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
    	return $this->belongsToMany('App\Users', 'user_organizations', 'organization_id', 'user_id');
    }
}
