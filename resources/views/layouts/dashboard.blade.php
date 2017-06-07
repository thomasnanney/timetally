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
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
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
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="sidebar">
    <div class="sidebar-header text-center">
        <img src="{{asset('images/hourglass.png')}}">
    </div>
    <ul>
        <a href="{{url('/timer')}}">
            <li>
                <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                <span class="sidebar-text">Timer</span>
            </li>
        </a>
        <a href="{{url('/home')}}">
            <li>
                <i class="fa fa-tachometer" aria-hidden="true"></i>
                <span class="sidebar-text">Dashboard</span>
            </li>
        </a>
        <a href="#">
            <li>
                <i class="fa fa-line-chart" aria-hidden="true"></i>
                <span class="sidebar-text">Reports</span>
            </li>
        </a>
    </ul>
    <small>Manage</small>
    <ul>
        <a href="#">
            <li>
                <i class="fa fa-handshake-o" aria-hidden="true"></i>
                <span class="sidebar-text">Clients</span>
            </li>
        </a>
        <a href="#">
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
    </ul>
</div>
<div class="content">
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('js')
</body>
</html>
