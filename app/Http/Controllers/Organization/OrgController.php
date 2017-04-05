<?php

namespace App\Http\Controllers\Organization;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrgRequest;
use App\Organization;
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
}

