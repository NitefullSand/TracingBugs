@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		@include('task.nameList')
		<div class="col-xs-9">
			<form action="/project/{{ $project->id }}/task_store" method="POST">
				<label for="name">名称: </label>
				<!-- $name是TaskController中定义的$field的属性，当表单未被验证通过时会将旧值填入 -->
				<input id="name" type="text" name="name"  value="{{ $name }}" autofocus>
				<br>
				<label for="description">描述: </label>
				<input id="description" type="text" name="description" value="{{ $description }}">
				<br>
				<label for="begin_at">开始时间: </label>
				<input id="begin_at" type="text" name="begin_at" value="{{ $begin_at }}">
				<br>
				<label for="end_at">截止时间: </label>
				<input id="end_at" type="text" name="end_at" value="{{ $end_at }}">
				<br>
				<label for="version">所属版本: </label>
				<input id="version" type="text" name="version" value="{{ $version }}">
				<br>
				<label for="module">所属模块: </label>
				<input id="module" type="text" name="module" value="{{ $module }}">
				<br>
				<label for="type">任务类型: </label>
				<input id="type" type="text" name="type" value="{{ $type }}">
				<input id="project_id" type="hidden" name="project_id" value="{{ $project->id }}">
				<br>
				<button type="submit" class="btn btn-primary">
				    创建
				</button>
		        {{ csrf_field() }}
			</form>
		</div>
	</div>
	@include('layouts.error')
</div>
@endsection