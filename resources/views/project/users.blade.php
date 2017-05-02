<div>
<ul>
	<h4><b>已有成员：</b></h4>
	<li><a href="">创建者 : {{ $project->creator()->name }}</a></li>
	@foreach($project->admins as $user)
	<li>
		<a href="">{{ $user->pivot->role }} : {{ $user->name }}</a>
		@if($project->creator()->id == Auth::user()->id)
		<button class="btn_delProUser" data-pId="{{ $project->id }}" data-rId="{{ $user->pivot->id }}">删除</button>
		@endif
	</li>
	@endforeach
	@foreach($project->users as $user)
	<li>
		<a href="">{{ $user->pivot->role }} : {{ $user->name }}</a>

		@if ($project->creator()->id == Auth::user()->id || $project->isAdmin() == 1)
		<button class="btn_delProUser" data-pId="{{ $project->id }}" data-rId="{{ $user->pivot->id }}">删除</button>
		@endif
	</li>
	@endforeach

	@if ($project->creator()->id == Auth::user()->id || $project->isAdmin() == 1)
	<h4><b>添加成员：</b></h4>
	<label for="user_id">姓名：</label>
	<select id="user_id" name="user_id" class="selectpicker bla bla bli" data-live-search="true" title="用户">
		@foreach($project->orgOtherUsers() as $user)
		<option value="{{ $user->id }}">
		{{ $user->name }}</option>
		@endforeach
	</select>

	<label for="role">角色: </label>
	<select id="role" name="role"">
	@foreach (array('成员','管理员') as $r)
	<option>{{ $r }}</option>
	@endforeach
	</select>
	<button id="btn_addProUser" data-pId="{{ $project->id }}">添加</button>
	@endif
</ul>
</div>

<script>
addProUser();
delProUser();
</script>