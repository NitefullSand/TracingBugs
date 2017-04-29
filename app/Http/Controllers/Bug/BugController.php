<?php

namespace App\Http\Controllers\Bug;

use App\Bug;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBugRequest;
use App\Project;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BugController extends Controller
{
    protected $fields = [
    	'name' => '',
    	'description' => '',
    	'priority' => '',
    	'state' => '',
    	'task_id' => 0,
    	'creator_id' => 0,
    	'executor_id' => 0,
    ];


    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($pId, $tId, $bId)
    {
        $project = Project::find($pId);
        $task = Task::find($tId);
        $data = $this->fields;
        $data['bug_id'] = $bId;
        if($bId != 0) {
            $bug = Bug::find($bId);
            foreach (array_keys($this->fields) as $field) {
                $data[$field] = $bug->$field;
            }
        }
        return view('bug.edit',['project' => $project, 'task' => $task], $data);
    }

    public function store(CreateBugRequest $request, $pId, $tId, $bId)
    {
        DB::beginTransaction();

        // $bId为0时新建Bug,否则修改Bug。
        $bug = null;
        if($bId == 0) {
            $bug = new Bug;
            $bug->creator_id = Auth::user()->id;
            $bug->task_id = (int)$tId;
        } else {
            $bug = Bug::find($bId);
        }

        try {
            foreach (array('name', 'description', 'priority', 'state') as $field) 
            {
                $bug->$field = $request->get($field);
            }
            $executor_id = (int)$request->get('executor_id');

            if($executor_id == 0){
                $bug->executor_id = null;
            } else {
                $bug->executor_id = $executor_id;
            }
            $bug->save();
            DB::commit();           // 提交事务
        } catch (Exception $e) {
            DB::rollback();         // 遇到异常回滚
            echo $e->getMessage();
            echo $e->getCode();
        }

        return redirect('/project/'.$pId.'/task/'.$tId);
    }
}
