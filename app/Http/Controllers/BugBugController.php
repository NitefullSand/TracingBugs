<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBugRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BugBugController extends Controller
{
	protected $fields = [
    	'name' => '',
    	'description' => '',
    	'state' => '',
    	'task_id' => 0,
    	'creater' => 0,
    	'closer' => 0,
    ];

    public function store(CreateBugRequest $request)
    {
        DB::beginTransaction();
    }
}
