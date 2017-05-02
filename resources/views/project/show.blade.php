@extends('layouts.task')

@section('content')
<div class="container">
	<div class="row">
		@include('task.nameList')
		<div class="col-xs-9">
			@if ($task == null)
			<p>项目是空的，先创建个任务吧~</p>
			@else
				@include('task.show')
			@endif

		</div>
	</div>
</div>

@endsection