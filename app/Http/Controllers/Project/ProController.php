<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProRequest;
use App\Project;
use App\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProController extends Controller
{
	/**
	 * Project的属性
	 * @var [type]
	 */
	protected $fields = [
		'name' => '',
		'description' => ''
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

    public function show($id)
    {
        $project = Project::whereId($id)->firstOrFail();
        if($project->tasks->count() > 0) {
            $firstTask = $project->tasks->first();
            return redirect('project/'.$id.'/task/'.$firstTask->id);
        }
        return view('project.show')->with('project', $project)->with('task', null);
    }

    /**
     * 该方法会在点击“添加新项目”或者表单被填充但是验证失败时执行，对于后者我们会将传过来的
     * 数据通过 old 方法回写到表单中。
     * @param  
     * @return View                         返回“   ”视图
     */
    public function create()
    {
    	$data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        return view('project.create', $data);
    }

    /**
     * 保存新创建的Project
     * @param  CreateProRequest $request 	重新实现的Request类
     * @return 重定向
     */
    public function store(CreateProRequest $request)
    {
		$project = new Project();
	    foreach (array_keys($this->fields) as $field) {
	        $project->$field = $request->get($field);
	    }
        $org_id = Auth::user()->getNowOrg()->id;
	    $project->organization_id = $org_id;
	    $project->save();

        $userPro = new UserProject();
        $userPro->user_id = Auth::user()->id;
        $userPro->project_id = $project->id;
        $userPro->role = "创建者";
        $userPro->save();
	
        return redirect('/organization/'.$org_id.'/projects');
    }

    /**
     * 返回项目所有成员列表视图
     * @param  int $pId 项目id
     * @return view      成员列表视图
     */
    public function users($pId)
    {
        $project = Project::find($pId);

        return view('project.users')->with('project', $project);
    }

    public function user_add(Request $request, $pId)
    {
        $uId = $request->input('uId');
        $role = $request->input('role');
        
        try {
            $userPro = new UserProject();
            $userPro->project_id = (int)$pId;
            $userPro->user_id = (int)$uId;
            $userPro->role = $role;
            $userPro->save();
            return 'true';
        } catch (Exception $e) {
            return 'false';
        }
    }

    public function user_del(Request $request, $pId)
    {
        $rId = $request->input('rId');
        try {
            $userPro = UserProject::find($rId);
            $userPro->delete();
            return 'true';
        } catch (Exception $e) {
            return 'false';
        }
    }
}
