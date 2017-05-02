<?php

namespace App\Http\Controllers\Bug;

use App\Bug;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBugRequest;
use App\Project;
use App\Task;
use App\User;
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
        $bug = null;
        if($bId != 0) {
            $bug = Bug::find($bId);
            foreach (array_keys($this->fields) as $field) {
                $data[$field] = $bug->$field;
            }
        }
        return view('bug.edit',['project' => $project, 'task' => $task, 'bug' => $bug], $data);
    }

    public function store(CreateBugRequest $request, $pId, $tId, $bId)
    {
        DB::beginTransaction();

        $comment_text = "";

        // $bId为0时新建Bug,否则修改Bug。
        $bug = null;
        if($bId == 0) {
            $bug = new Bug;
            $bug->creator_id = Auth::user()->id;
            $bug->task_id = (int)$tId;
            $comment_text = "创建了Bug。";
        } else {
            $bug = Bug::find($bId);
        }

        try {
            foreach (array('name', 'description', 'priority', 'state') as $field) 
            {
                $value = $request->get($field);
                if($bug->$field != $value) {
                    $comment_text = $comment_text."将Bug的[" . $field . "]设置为：" . $value . "。";
                    $bug->$field = $value;
                }
            }
            $executor_id = (int)$request->get('executor_id');
            $executor_name = "";
            if($bug->executor_id != $executor_id) {
                if($executor_id == 0){
                    $bug->executor_id = null;
                    $executor_name = "未指定";
                } else {
                    $bug->executor_id = $executor_id;
                    $executor_name = User::find($executor_id)->name;
                }
                $comment_text = $comment_text . "将Bug指派给了：[" . $executor_name . "]。";
            }

            $bug->save();

            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->bug_id = $bug->id;
            $comment->content = $comment_text;
            $comment->save();

            DB::commit();           // 提交事务
        } catch (Exception $e) {
            DB::rollback();         // 遇到异常回滚
            echo $e->getMessage();
            echo $e->getCode();
        }

        return redirect('/project/'.$pId.'/task/'.$tId);
    }
}
