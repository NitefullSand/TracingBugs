@extends('layouts.app')

@section('content')
<div class="container">
	<form action="createOrganization" method="POST">
		<!-- $name是ProController中定义的$field的属性，当表单未被验证通过时会将旧值填入 -->
		<label for="name">Organization's Name: </label>
		<input id="name" type="text" name="name" autofocus>
		<label for="description">Organization's Description: </label>
		<input id="description" type="text" name="description">
		
		<button type="submit" class="btn btn-primary">
		    创建
		</button>
        {{ csrf_field() }}
	</form>
	@include('layouts.error')
</div>
@endsection