@extends('layouts.dashboard')

@section('css')
    <link href="{{asset('/css/dashboard.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="row">
        <div class="timer-container col-xs-12">
            <h1>Dashboard</h1>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-md-8">

        </div>
        <div class="col-xs-12 col-md-4 activity-sidebar">
            <div class="row">
                <div class="col-sm-4">
                    <h2>Most Contributions this Week</h2>
                    <h1>Jerry Seinfeld</h2>
                </div>
                <div class="col-sm-8 portrait-container">
                    <img src="{{asset('images/seinfeld3.png')}}">
                </div>
            </div>
            <br>
            <h2>Activity</h2>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p style="font-size: 14px"><strong>Jane Doe from <a>Department A</a> worked on <a>Project B</a></strong></p>
                    <p style="font-size: 14px">Worked on fixing a problem with the thing</p>
                </div>
                <div class="col-sm-4">
                    <p>a day ago</p>
                    <p>01:30:00</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')

@endsection