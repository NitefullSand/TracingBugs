<?php

namespace App\Http\Controllers\Organization;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrgRequest;
use App\Organization;
use App\User;
use App\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrgController extends Controller
{
    /**
     * 组织model中的字段名
     */
    protected $fields = [
        'name' => '',
        'description' => '',
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

    public function personal()
    {
        $organization = new Organization;
        $organization->name = "";
        Auth::user()->setNowOrg($organization);
        return view('organization\organization')->with('organization', $organization);
    }
    /**
     * Show the organization's infomation.
     * @param  interge $id organization's id.
     * @return 
     */
    public function show($id)
    {
    	$organization = Organization::whereId($id)->firstOrFail();
        Auth::user()->setNowOrg($organization);
        return view('organization\organization')->with('organization', $organization);
    }

    /**
     * Create a new organization.
     * 该方法中使用"事务"的方式添加组织资料、添加组织和创建者的关系
     * 执行过程中出现任何错误都将回滚数据库
     * @param  CreateOrgRequest.
     * @return 
     */
    public function create(CreateOrgRequest $request)
    {
        $org = new Organization;
        DB::beginTransaction();
        try {
            foreach (array_keys($this->fields) as $field) {
                $org->$field = $request->get($field);
            }
            $isOk = $org->save();
            if(!$isOk) {            // 如果保存失败也抛出异常
                throw new Exception("Save organization's info failed!", 1);
            }

            $userOrg = new UserOrganization;
            $userOrg->user_id = Auth::user()->id;
            $userOrg->organization_id = $org->id;
            $userOrg->role = "创建者";
            $isOk = $userOrg->save();
            if(!$isOk) {
                throw new Exception("Save organization's info failed!", 2);
            }
            DB::commit();           // 提交事务
        } catch (Exception $e) {
            DB::rollback();         // 遇到异常回滚
            echo $e->getMessage();
            echo $e->getCode();
        }

        return redirect('/')
            ->withSuccess("The organization: '$org->name' was created!");
    }

    /**
     * 返回组织所有成员列表视图
     * @param  int $pId 项目id
     * @return view      成员列表视图
     */
    public function users($oId)
    {
        $organization = Organization::find($oId);

        return view('organization.users')->with('organization', $organization);
    }

    public function user_add(Request $request, $oId)
    {
        $user_email = $request->input('user_email');

        $user = User::All()->where("email", $user_email)->first();

        // 判断组织中是否已经存在该用户
        if(UserOrganization::All()->where("user_id", $user->id)->where("organization_id", (int)$oId)->count() > 0){
            return "false";
        }

        $role = $request->input('role');
        
        try {
            $userOrg = new UserOrganization();
            $userOrg->organization_id = (int)$oId;
            $userOrg->user_id = $user->id;
            $userOrg->role = $role;
            $userOrg->save();
            return 'true';
        } catch (Exception $e) {
            return 'false';
        }
    }

    public function user_del(Request $request, $pId)
    {
        $rId = $request->input('rId');
        try {
            $userOrg = UserOrganization::find($rId);
            $userOrg->delete();
            return 'true';
        } catch (Exception $e) {
            return 'false';
        }
    }
}

