<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse menu" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <a href="{{url('/timer')}}">
                        <li class="{{ isActive('timer') }}">
                            <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                            <span class="sidebar-text">Timer</span>
                        </li>
                    </a>
                    <a href="{{url('/dashboard')}}">
                        <li class="{{ isActive('dashboard')}}">
                            <i class="fa fa-tachometer" aria-hidden="true"></i>
                            <span class="sidebar-text">Dashboard</span>
                        </li>
                    </a>
                    <a href="{{url('/reports')}}">
                        <li class="{{ isActive('reports')}}">
                            <i class="fa fa-line-chart" aria-hidden="true"></i>
                            <span class="sidebar-text">Reports</span>
                        </li>
                    </a>
                    <a href="{{url('/clients')}}">
                        <li>
                            <i class="fa fa-handshake-o" aria-hidden="true"></i>
                            <span class="sidebar-text">Clients</span>
                        </li>
                    </a>
                    <a href="{{url('/projects')}}">
                        <li>
                            <i class="fa fa-briefcase" aria-hidden="true"></i>
                            <span class="sidebar-text">Projects</span>
                        </li>
                    </a>
                    <a href="#">
                        <li>
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span class="sidebar-text">Users</span>
                        </li>
                    </a>
                    <a href="#">
                        <li>
                            <i class="fa fa-building" aria-hidden="true"></i>
                            <span class="sidebar-text">Workspaces</span>
                        </li>
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <li>
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span class="sidebar-text">Logout</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </a>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="sidebar menu">
    <div class="sidebar-header text-center">
        <img src="{{asset('images/hourglass.png')}}">
    </div>
    <ul>
        <a href="{{url('/timer')}}">
            <li class="{{ isActive('timer') }}">
                <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                <span class="sidebar-text">Timer</span>
            </li>
        </a>
        <a href="{{url('/dashboard')}}">
            <li class="{{ isActive('dashboard')}}">
                <i class="fa fa-tachometer" aria-hidden="true"></i>
                <span class="sidebar-text">Dashboard</span>
            </li>
        </a>
        <a href="{{url('/reports')}}">
            <li class="{{ isActive('reports')}}">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
                <span class="sidebar-text">Reports</span>
            </li>
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <li>
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <span class="sidebar-text">Logout</span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            </li>
        </a>
    </ul>
    <small>Manage</small>
    <ul>
        <a href="{{url('/clients')}}">
            <li>
                <i class="fa fa-handshake-o" aria-hidden="true"></i>
                <span class="sidebar-text">Clients</span>
            </li>
        </a>
        <a href="{{url('/projects')}}">
            <li>
                <i class="fa fa-briefcase" aria-hidden="true"></i>
                <span class="sidebar-text">Projects</span>
            </li>
        </a>
        <a href="{{url('/users')}}">
            <li>
                <i class="fa fa-users" aria-hidden="true"></i>
                <span class="sidebar-text">Users</span>
            </li>
        </a>
        <a href="{{url('/workspaces')}}">
            <li>
                <i class="fa fa-building" aria-hidden="true"></i>
                <span class="sidebar-text">Workspaces</span>
            </li>
        </a>
    </ul>
</div>
<div class="content">
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript">
    jQuery('.tk-dropdown-toggle').on('click', function(){
        var container = jQuery(this).parent();
        container.hasClass('active') ? container.removeClass('active') : container.addClass('active');
    });
</script>
@yield('js')
</body>
</html>
