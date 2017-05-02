@extends('layouts.app')

@section('topbar')
	@parent

    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                @if (!Auth::guest())
                <!-- Right Side Of Navbar Organization menu-->
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/"> 
                        首页 >
                        </a>
                    </li>
                    <li><a href="/project/{{ $project->id }}">{{ $project->name }}</a></li>
                </ul>
                @endif
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="" id="usersPanel" data-id="{{ $project->id }}" data-toggle="modal" data-target="#manageModal">项目成员</a></li>
                    @if($project->isCreator() || $project->isAdmin())
                    <!-- <li><a href="" id="projectPanel" data-toggle="modal" data-target="#manageModal">项目管理</a></li> -->
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endsection