@extends('layouts.dashboard')

@section('css')
   <link href="{{asset('libs/clockpicker/dist/bootstrap-clockpicker.css') }}" type="text/css" rel="stylesheet">
    <link href="{{asset('libs/datepicker/css/datepicker.css') }}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/timer.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('content')
    <div id="userManager"></div>

{{--<div class="log-container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-xs-12">--}}
                {{--<h2>Users</h2>--}}
                {{--<ul>--}}
                    {{--<li>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-12 col-md-6">--}}
                                {{--Name:--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}
                                {{--Level:--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}
                                {{--Email:--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-12 col-md-6">--}}
                                {{--Elaine Benes--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}

                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}
                                {{--elaine.benes@gmail.com--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-12 col-md-6">--}}
                                {{--Selina Kyle--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}
                                {{--<span class="label label-success">Admin</span>--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}
                                {{--selina.kyle@wh.gov--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-12 col-md-6">--}}
                                {{--Christine Campbell--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}

                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}
                                {{--christine.campbell@hotmail.com--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-12 col-md-6">--}}
                                {{--Julia Louis-Dreyfus--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}
                                {{--<span class="label label-success">Admin</span>--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 col-md-3">--}}
                                {{--julia.louisdreyfus@yahoo.com--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--</li>--}}

                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@endsection

@section('js')

@endsection