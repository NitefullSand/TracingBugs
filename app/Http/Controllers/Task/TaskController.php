<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Project;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $fields = [
    	'name' => '',
    	'description' => '',
    	'begin_at' => '',
        'end_at' => '',
        'version' => '',
        'module' => '',
        'type' => '',
    	'project_id' => 0,
        'state' => '',
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

    /**
     * 显示某个task
     * @param  int $id task'id
     * @return view     显示任务的页面
     */
    public function show($pId, $id)
    {
        $project = Project::whereId($pId)->firstOrFail();
        $task = Task::whereId($id)->firstOrFail();
        return view('project.show')->with('project', $project)->with('task', $task);
    }

    /**
     * 该方法会在点击“添加新任务”或者表单被填充但是验证失败时执行，对于后者我们会将传过来的
     * 数据通过 old 方法回写到表单中。
     * @return view 创建任务页面
     */
    public function create($pId)
    {
    	$data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        // 如果没填end_at，则默认为明天此时
        if($data['begin_at'] == '') {
            $data['begin_at'] = Carbon::now()->toDateTimeString();
        }
        // 如果没填end_at，则默认为明天此时
        if($data['end_at'] == '') {
        	$data['end_at'] = Carbon::now()->addDay(1)->toDateTimeString();
        }
        $data['project_id'] = $pId;

        $project = Project::whereId($pId)->firstOrFail();
        $data['project'] = $project;
        return view('task/create', $data);
    }

    public function store(CreateTaskRequest $request, $pId)
    {
        DB::beginTransaction();
        $task = new Task;
        try {
		    foreach (array_keys($this->fields) as $field) {
		        $task->$field = $request->get($field);
		    }
            $task->state = '新建';
			$task->save();

			$user_id = Auth::user()->id;
			$task_id = $task->id;
			DB::insert('insert into user_tasks (user_id, task_id, role) values (?, ?, ?)', [$user_id, $task_id, '创建者']);
            DB::commit();           // 提交事务
        } catch (Exception $e) {
            DB::rollback();         // 遇到异常回滚
            echo $e->getMessage();
            echo $e->getCode();
        }

        return redirect('/project/'.$pId.'/task/'.$task->id);
    }
}
