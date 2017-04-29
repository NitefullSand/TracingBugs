<div>
	<p>描述：{{ $task->description }}</p>
	<p>状态：{{ $task->state }}</p>
	<p>开始时间：{{ $task->begin_at }}</p>
	<p>结束时间：{{ $task->end_at }}</p>
	<p>所属版本：{{ $task->version }}</p>
	<p>所属模块：{{ $task->module }}</p>
	<p>任务类型：{{ $task->type }}</p>
	<p>开发负责人：{{  $task->developer()->name }}</p>
	<p>测试负责人：{{ $task->tester()->name }}</p>
	<p>创建者：{{ $task->creator()->name }}</p>
	<p>创建时间：{{ $task->created_at }}</p>

	<table class="table table-hover">
		<caption>Bug列表</caption>
		<thead>
			<tr>
				<th>编号</th>
				<th>名称</th>
				<th>状态</th>
				<th>优先级</th>
				<th>执行者</th>
			</tr>
		</thead>
		<tbody>
		@foreach($task->bugs as $bug)
			<tr onclick="editBug({{ $bug->id }})" data-toggle="modal" data-target="#createBugModal">
				<th>{{ $bug->id }}</th>
				<th>{{ $bug->name }}</th>
				<th>{{ $bug->state }}</th>
				<th>{{ $bug->priority }}</th>
				@if($bug->executor == null)
				<th>未指派</th>
				@else
				<th>{{ $bug->executor->name }}</th>
				@endif
			</tr>
		@endforeach
		</tbody>
	</table>
	<a data-toggle="modal" data-target="#createBugModal" onclick="editBug(0)">添加Bug</a>
</div>

@if ($task != null)
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
			<div class="modal-body" id="createBugForm">
				<!-- Insert html content by ajax. -->
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
@endif