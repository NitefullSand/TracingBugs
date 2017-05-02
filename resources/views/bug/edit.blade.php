<div>
	<form action="/project/{{ $project->id }}/task/{{ $task->id }}/bug_store/{{ $bug_id }}" method="POST">
		<label for="name">名称: </label>
		<input id="name" type="text" name="name" value="{{ $name }}" autofocus>
		<br>
		<label for="description">描述: </label>
		<input id="description" type="text" name="description" value="{{ $description }}">
		<br>
		<label for="priority">优先级: </label>
		<select id="priority" name="priority" value="{{ $priority }}">
		@foreach (array('普通','紧急','非常紧急') as $p)
		<option
		@if ($p == $priority)
		selected="selected"
		@endif
		>{{ $p }}</option>
		@endforeach
		</select>
		<label for="state">状态: </label>
		<select id="state" name="state">
		@foreach (array('新建','验证中','修复中', '已修复', '关闭') as $s)
		<option value="{{ $s }}"
		@if ($s == $state)
		selected="selected"
		@endif 
		>{{ $s }}</option>
		@endforeach
		</select>
		<br>
	    <label for="executor_id">执行者：</label>  
		<select id="executor_id" name="executor_id" class="selectpicker bla bla bli" data-live-search="true" title="用户">
			<option value="0">未指定</option>
			@foreach($project->allUsers as $user)
			<option value="{{ $user->id }}"
			@if ($user->id == $executor_id) selected="selected" @endif
			>{{ $user->name }}</option>
			@endforeach
		</select>

		@if($bug != null)
		<br>
		<label>评论：</label>
		<div class="bug-comments">
			@foreach($bug->comments as $comment)
			<span>
				<p><b>{{ $comment->user->name }}:</b>{{$comment->content}} <i>——{{ $comment->created_at }}</i></p>
			</span>
			@endforeach
		</div>
		@endif
		
		<br>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭  x
			</button>
			<button type="submit" class="btn btn-primary">
				提交Bug
			</button>
		</div>
	    {{ csrf_field() }}
	</form>
</div>
