@extends('layouts.app')

@section('content')
<div class="container">
	<form action="/project_store" method="POST">
		<label for="name">Project's Name: </label>
		<!-- $name是ProController中定义的$field的属性，当表单未被验证通过时会将旧值填入 -->
		<input id="name" type="text" name="name"  value="{{ $name }}" autofocus>
		<label for="description">Project's Description: </label>
		<input id="description" type="text" name="description" value="{{ $description }}">
		
		<button type="submit" class="btn btn-primary">
		    创建
		</button>
        {{ csrf_field() }}
	</form>
	@include('layouts.error')
</div>
@endsection