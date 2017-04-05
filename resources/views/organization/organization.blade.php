@extends('layouts.app')

@section('content')
<div class="container">
	<!-- 如果该用户有项目则显示其项目，否则提示先创建新组织 -->
	@if (Auth::user()->organization->count() > 0)
		@foreach ($organization->projects as $project)
		项目: <a href="/project/{{ $project->id }}">{{ $project->name }}</a>
		<br>
		@endforeach
		<br>
		<a href="/project_create">新项目</a>
	@else
		<a href="/createOrganization">先创建一个组织吧~</a>
	@endif
</div>
@endsection