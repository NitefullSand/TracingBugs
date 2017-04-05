@extends('layouts.app')

@section('content')
<div class="container">
	@foreach ($project->tasks as $task)
	<h1>任务名：{{ $task->name }}</h1>
	<br>
	任务描述：{{ $task->description }}
	<br>
	优先级：{{ $task->priority }}
	<br>
	截至日期：{{ $task->deadline }}
	<br>
	所属项目: {{ $task->project->name }}
	<br>
	<h3>成员：</h3>
	<br>
	@foreach ($task->users() as $user)
	{{$user->role}} : {{ $user->name }}
	<br>
	@endforeach
	<br>
	<b>****************************************************************************************************************************************************************</b>
	@endforeach

	<br>
	<a href="/project/{{ $project->id }}/task_create">新任务</a>
</div>
@endsection