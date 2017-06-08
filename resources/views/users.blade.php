@extends('layouts.dashboard')

@section('css')
   <link href="{{asset('libs/clockpicker/dist/bootstrap-clockpicker.css') }}" type="text/css" rel="stylesheet">
    <link href="{{asset('libs/datepicker/css/datepicker.css') }}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/timer.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('content')

<div class="log-container">
        <div class="row">
            <div class="col-xs-12">
                <ul>
                    <li>Users</li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                Elaine Benes
                            </div>
                            <div class="col-xs-4 col-md-4">
                                elaine.benes@gmail.com
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                Selina Kyle <span class="label label-default">admin</span>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                selina.kyle@wh.gov
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                Christine Campbell
                            </div>
                            <div class="col-xs-4 col-md-4">
                                christine.campbell@hotmail.com
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                Julia Louis-Dreyfus <span class="label label-default">admin</span>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                julia.louisdreyfus@yahoo.com
                            </div>
                        </div>
                    </li>
                    </li>

                </ul>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection