@extends('layouts.app')

@section('content')
<div class="container">
	<form action="/project/{{ $project_id }}/task_store" method="POST">
		<label for="name">Task's Name: </label>
		<!-- $name是TaskController中定义的$field的属性，当表单未被验证通过时会将旧值填入 -->
		<input id="name" type="text" name="name"  value="{{ $name }}" autofocus>
		<label for="description">Task's Description: </label>
		<input id="description" type="text" name="description" value="{{ $description }}">
		<label for="priority">Task's Priority: </label>
		<input id="priority" type="text" name="priority" value="{{ $priority }}">
		<label for="deadline">Task's Deadline: </label>
		<input id="deadline" type="text" name="deadline" value="{{ $deadline }}">
		<input id="project_id" type="hidden" name="project_id" value="{{ $project_id }}">
		
		<button type="submit" class="btn btn-primary">
		    创建
		</button>
        {{ csrf_field() }}
	</form>
	@include('layouts.error')
</div>
@endsection