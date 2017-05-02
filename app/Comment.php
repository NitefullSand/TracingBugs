<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	/**
	 * 该comment所属bug
	 * @return [type] [description]
	 */
    public function bug()
    {
    	return $this->belongsTo('App\Bug');
    }

	/**
	 * 该comment所属user
	 * @return [type] [description]
	 */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
