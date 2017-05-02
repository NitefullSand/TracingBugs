<div class="col-xs-3" >
	<div class="row">
		<ul class="nav nav-pills nav-stacked">
			@foreach ($project->tasks as $task)
				<li class="active"><a href="/project/{{ $project->id }}/task/{{ $task->id }}">{{ $task->name }}</a></li>
			@endforeach

		</ul>
	</div>
	<div class="row">
		<a href="/project/{{ $project->id }}/task_create">新任务</a>
	</div>
</div>