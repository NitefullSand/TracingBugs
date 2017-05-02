<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/myjs.js') }}"></script>

    <!-- 下拉搜索框所用资源 -->
    <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap-select/2.0.0-beta1/js/bootstrap-select.js"></script>    
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap-select/2.0.0-beta1/css/bootstrap-select.css"> 

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        @section('topbar')
        <nav class="navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                                
                    @if (!Auth::guest())
                    <!-- Right Side Of Navbar Organization menu-->
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                组织
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <!-- 遍历当前用户的所有组织，展示组织的名字 -->
                                <!-- 点击组织名链接到"/organization/该组织的id/projects"页面 -->
                                @foreach (Auth::user()->organization as $organ)
                                    <li><a href="/organization/{{ $organ->id }}/projects">{{ $organ->name }}</a></li>
                                @endforeach
                                    <li class="divider"></li>
                                    <li>
                                        <a href="/createOrganization">
                                            创建组织
                                        </a>
                                    </li>
                            </ul>
                        </li>
                        @if (Auth::user()->organization->count() > 0)
                        <li>
                            <a href="/organization/{{ Auth::user()->getNowOrg()->id }}/projects"> 
                            <!-- 展示当前用户当前选中的组织名 -->
                            {{ Auth::user()->getNowOrg()->name }}
                            </a>
                        </li>
                        @endif
                    </ul>
                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            
                            @if(Auth::user()->organization->count() > 0)
                                <li><a href="" id="orgUsersPanel" data-id="{{ Auth::user()->getNowOrg()->id }}" data-toggle="modal" data-target="#manageModal">组织成员</a></li>
                                @if(Auth::user()->getNowOrg()->isCreator() || Auth::user()->getNowOrg()->isAdmin())
                                <!-- <li><a href="" id="orgPanel" data-toggle="modal" data-target="#manageModal">组织管理</a></li> -->
                                @endif
                            @endif

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">个人中心</a></li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ui>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @show

        @yield('content')
        
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="manageModal" tabindex="-1" role="dialog" aria-labelledby="manageModalTitle" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="manageModalTitle">
                            <!-- Modal title -->
                        </h4>
                    </div>
                    <div class="modal-body" id="manageModalContent">
                        <!-- Modal content -->
                    </div>
<!--                     <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <button type="button" class="btn btn-primary">
                            提交更改
                        </button>
                    </div> -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>
</body>
</html>
