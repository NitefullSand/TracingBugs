@extends('layouts.app')

@section('content')
<div class="container">
	Name: {{ $organization->name}}
	<br>
	Description: {{ $organization->description }}
</div>
@endsection