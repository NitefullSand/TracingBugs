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
				<label for="priority">优先级: </label>
				<select id="priority" name="priority">
				@foreach (array('普通','紧急','非常紧急') as $p)
				<option @if($p == $priority) selected="selected" @endif>{{ $p }}</option>
				@endforeach
				</select>
				<br>
				<label for="deadline">截止时间: </label>
				<input id="deadline" type="text" name="deadline" value="{{ $deadline }}">
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