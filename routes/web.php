<?php

use Illuminate\Auth\user;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', function() {
    return redirect("/");
});

Route::get('/', function () {
	// 登陆过则展示项目
	if (!Auth::guest()) {
		if(Auth::user()->organization->count() == 0) {	// 如果该用户没有组织
			return redirect("/projects");
		} else {
			$organ_id = Auth::user()->organization->first()->id;	// 获取该用户第一个组织的id
			return redirect("/organization/{$organ_id}/projects");
		}
	}
	// 否则展示欢迎界面
	return view('welcome');
});

Route::get('/projects', 'Organization\OrgController@personal');
Route::get('/organization/{id}/projects', 'Organization\OrgController@show');
Route::get('/createOrganization', function() {
    return view('organization/create');
});
Route::Post('/createOrganization', 'Organization\OrgController@create');

Route::get('/project/{id}', 'Project\ProController@show');
Route::get('/project_create', 'Project\ProController@create');
Route::post('/project_store', 'Project\ProController@store');

Route::get('/project/{pId}/task/{id}', 'Task\TaskController@show');
Route::get('/project/{pId}/task_create', 'Task\TaskController@create');
Route::Post('/project/{pId}/task_store', 'Task\TaskController@store');

Route::get('/project/{pId}/task/{tId}/bug_edit/{bId}', 'Bug\BugController@edit');
Route::Post('/project/{pId}/task/{tId}/bug_store/{bId}', 'Bug\BugController@store');