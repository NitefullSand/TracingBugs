<div>
<ul>
	<h4><b>已有成员：</b></h4>
	<li><a href="">创建者 : {{ $organization->creator()->name }}</a></li>
	@foreach($organization->admins as $user)
	<li>
		<a href="">{{ $user->pivot->role }} : {{ $user->name }}</a>
		@if($organization->creator()->id == Auth::user()->id)
		<button class="btn_delOrgUser" data-oId="{{ $organization->id }}" data-rId="{{ $user->pivot->id }}">删除</button>
		@endif
	</li>
	@endforeach
	@foreach($organization->users as $user)
	<li>
		<a href="">{{ $user->pivot->role }} : {{ $user->name }}</a>

		@if ($organization->creator()->id == Auth::user()->id || $organization->isAdmin() == 1)
		<button class="btn_delOrgUser" data-oId="{{ $organization->id }}" data-rId="{{ $user->pivot->id }}">删除</button>
		@endif
	</li>
	@endforeach

	@if ($organization->creator()->id == Auth::user()->id || $organization->isAdmin() == 1)
	<h4><b>添加成员：</b></h4>
	<label for="user_email">邮箱：</label>
	<input type="text" id="user_email" name="user_email">

	<label for="role">角色: </label>
	<select id="role" name="role"">
	@foreach (array('成员','管理员') as $r)
	<option>{{ $r }}</option>
	@endforeach
	</select>
	<button id="btn_addOrgUser" data-oId="{{ $organization->id }}">添加</button>
	@endif
</ul>
</div>

<script>
addOrgUser();
delOrgUser();
</script>