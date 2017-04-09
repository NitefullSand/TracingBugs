@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		@include('task.nameList')
		<div class="col-xs-9">
			@if ($showTask == '')
			<p>项目是空的，先创建个任务吧~</p>
			@else
			<p>描述：{{ $showTask->description }}</p>
			<p>优先级：{{ $showTask->priority }}</p>
			<p>开发负责人：{{  $showTask->developer()->name }}</p>
			<p>测试负责人：{{ $showTask->tester()->name }}</p>
			<p>截至日期：{{ $showTask->deadline }}</p>
			<p>创建者：{{ $showTask->creater()->name }}</p>
			<p>创建时间：{{ $showTask->created_at }}</p>
			@endif

			@foreach($showTask->bugs as $bug)
			{{ dd($bug) }}
			@endforeach
			<a data-toggle="modal" data-target="#createBugModal">添加Bug</a>
		</div>
	</div>
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="createBugModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					新建Bug
				</h4>
			</div>
			<div class="modal-body">
				<form action="/project/{{ $project->id }}/task/{{ $showTask->id }}/bug_store" method="POST">
					<label for="name">名称: </label>
					<!-- $name是TaskController中定义的$field的属性，当表单未被验证通过时会将旧值填入 -->
					<input id="name" type="text" name="name"  value="" autofocus>
					<br>
					<label for="description">描述: </label>
					<input id="description" type="text" name="description" value="">
					<br>
					<label for="priority">优先级: </label>
					<select id="priority" name="priority">
					@foreach (array('普通','紧急','非常紧急') as $p)
					<option>{{ $p }}</option>
					@endforeach
					</select>
					<br>
					<label for="deadline">截止时间: </label>
					<input id="deadline" type="text" name="deadline" value="">
					<input id="project_id" type="hidden" name="project_id" value="">
					
					<br>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭
						</button>
						<button type="submit" class="btn btn-primary">
							提交Bug
						</button>
					</div>
			        {{ csrf_field() }}
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>

@endsection